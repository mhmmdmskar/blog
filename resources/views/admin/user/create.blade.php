@extends('layouts.app')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">

    <h2 class="text-xl font-bold text-[#305c88] mb-6">Tambah Akun User</h2>

    {{-- Tampilkan error validasi --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 px-4 py-2 rounded">
            <ul class="list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-6">
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full p-2 border rounded" required>
        </div>

        <div class="flex justify-between items-center">
            <!-- Tombol Batal untuk kembali ke halaman daftar user -->
            <a href="{{ route('admin.users.index') }}" class="text-gray-500 hover:underline text-sm">← Batal</a>
            <button type="submit" class="bg-[#305c88] text-white px-4 py-2 rounded hover:bg-[#27496d]">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection