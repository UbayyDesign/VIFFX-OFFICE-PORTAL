@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="p-4">
  <div class="mb-6">
    <h1 class="text-xl font-bold">Edit User</h1>
    <p class="text-sm text-gray-400">Perbarui data user, status aktif, dan role.</p>
  </div>

  <form action="{{ route('users.update', $user) }}" method="POST" class="space-y-4 bg-[#101010] border border-white/10 rounded-3xl p-6">
    @csrf
    @method('PUT')

    <div>
      <label class="block text-sm text-gray-300">Nama</label>
      <input type="text" name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full rounded-2xl border border-white/10 bg-[#0d0d0d] px-4 py-3 text-white" required>
      @error('name') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-300">Email</label>
      <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full rounded-2xl border border-white/10 bg-[#0d0d0d] px-4 py-3 text-white" required>
      @error('email') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-300">Password baru <span class="text-xs text-gray-500">(kosongkan jika tidak ingin mengubah)</span></label>
      <input type="password" name="password" class="mt-1 block w-full rounded-2xl border border-white/10 bg-[#0d0d0d] px-4 py-3 text-white">
      @error('password') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label class="block text-sm text-gray-300">Role</label>
      <select name="role" class="mt-1 block w-full rounded-2xl border border-white/10 bg-[#0d0d0d] px-4 py-3 text-white" required>
        @foreach(['FP','RO','MM','CMM','BDM','BM','HRD','ADMIN'] as $role)
          <option value="{{ $role }}" {{ old('role', $user->role) === $role ? 'selected' : '' }}>{{ $role }}</option>
        @endforeach
      </select>
      @error('role') <p class="text-rose-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3">
      <label class="inline-flex items-center gap-2 text-sm text-gray-300">
        <input type="checkbox" name="is_active" {{ old('is_active', $user->is_active) ? 'checked' : '' }} class="rounded border-white/20 bg-[#0d0d0d] text-gold focus:ring-gold">
        Aktifkan akun
      </label>
    </div>

    <div class="flex gap-3">
      <a href="{{ route('users.index') }}" class="sys-btn bg-gray-700 hover:bg-gray-600">Batal</a>
      <button type="submit" class="sys-btn">Perbarui User</button>
    </div>
  </form>
</div>
@endsection
