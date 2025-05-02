@extends('layouts.admin')

@section('content')
<div class="max-w-md mx-auto mt-10 bg-white p-6 rounded shadow">
    <h2 class="text-xl font-bold text-[#305c88] mb-4">Edit User</h2>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm mb-1">Nama</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full p-2 border rounded" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Password Baru (kosongkan jika tidak ingin mengganti)</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded shadow-sm">
        </div>

        <div class="mb-4">
            <label class="block text-sm mb-1">Konfirmasi Password Baru</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded shadow-sm">
        </div>

        <div class="flex justify-between items-center">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-500 hover:underline">← Kembali</a>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Update
            </button>
        </div>
    </form>
</div>
@endsection