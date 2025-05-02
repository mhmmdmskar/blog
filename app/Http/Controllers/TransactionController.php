<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Product;
use App\Services\MidtransService;

class TransactionController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|numeric|min:1',
        ]);

        $product = Product::find($request->product_id);
        if ($product->stock < $request->quantity) {
            return back()->with('error', 'Stok produk tidak cukup.');
        }

        $total_price = $product->price * $request->quantity;

        $transaction = Transaction::create([
            'user_id'     => auth()->id(),
            'product_id'  => $product->id,
            'total_price' => $total_price,
            'status'      => Transaction::STATUS_PENDING,
            'quantity'    => $request->quantity,
        ]);

        $transaction->details()->create([
            'product_id'  => $product->id,
            'quantity'    => $request->quantity,
            'price'       => $product->price,
            'total_price' => $total_price,
        ]);

        $transaction_data = [
            'transaction_details' => [
                'order_id'     => $transaction->id,
                'gross_amount' => $total_price,
            ],
            'item_details' => [[
                'id'       => $product->id,
                'name'     => $product->name,
                'price'    => $product->price,
                'quantity' => $request->quantity,
            ]],
            'customer_details' => [
                'first_name' => auth()->user()->name,
                'email'      => auth()->user()->email,
            ]
        ];

        try {
            $snapToken = $this->midtransService->getSnapToken($transaction_data);
            if (!$snapToken) {
                \Log::error("❌ SnapToken gagal dibuat untuk transaksi ID {$transaction->id}");
                $transaction->delete();
                return back()->with('error', 'Gagal membuat SnapToken.');
            }

            $transaction->snap_token = $snapToken;
            $transaction->save();
            \Log::info("✅ SnapToken dibuat: {$snapToken} (Transaksi ID: {$transaction->id})");
        } catch (\Exception $e) {
            \Log::error("🔥 Gagal SnapToken: " . $e->getMessage());
            $transaction->delete();
            return back()->with('error', 'Terjadi kesalahan saat membuat SnapToken.');
        }

        return redirect()->route('user.transactions.invoice', $transaction->id)
            ->with('success', 'Transaksi berhasil dibuat! Silakan lakukan pembayaran.');
    }

    public function midtransCallback(Request $request)
    {
        \Log::info('📬 Callback diterima:', $request->all());

        $serverKey     = config('services.midtrans.server_key');
        $expectedSign  = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($expectedSign !== $request->signature_key) {
            \Log::warning('🚫 Signature key tidak valid!');
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        $transaction = Transaction::find($request->order_id);
        if (!$transaction) {
            \Log::warning("🚫 Transaksi ID {$request->order_id} tidak ditemukan.");
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        switch ($request->transaction_status) {
            case 'settlement':
                $transaction->status = Transaction::STATUS_SUCCESS;

                $product = Product::find($transaction->product_id);
                if ($product) {
                    $product->stock -= $transaction->quantity;
                    $product->save();
                }
                break;

            case 'expire':
            case 'cancel':
            case 'deny':
                $transaction->status = Transaction::STATUS_FAILED;
                break;

            default:
                $transaction->status = Transaction::STATUS_PENDING;
                break;
        }

        $transaction->save();
        \Log::info("✅ Transaksi #{$transaction->id} diperbarui ke status: {$transaction->status}");

        return response()->json(['message' => 'Callback processed successfully']);
    }

    public function index()
    {
        $transactions = Transaction::with('details.product')
            ->where('user_id', auth()->id())
            ->select('id', 'user_id', 'status', 'snap_token', 'created_at')
            ->latest()
            ->paginate(10);

        return view('user.transactions.index', compact('transactions'));
    }

    public function invoice(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            abort(403);
        }

        return view('user.transactions.invoice', compact('transaction'));
    }
}
