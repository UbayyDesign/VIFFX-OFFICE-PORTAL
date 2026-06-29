@extends('layouts.app')

@section('title', 'Manage Users')

@section('content')
<div class="p-4">
  <div class="flex items-center justify-between gap-4 mb-6">
    <div>
      <h1 class="text-xl font-bold">Manage Users</h1>
      <p class="text-sm text-gray-400">Daftar semua user dan role yang dapat diatur oleh ADMIN.</p>
    </div>
    <a href="{{ route('users.create') }}" class="sys-btn">Tambah User</a>
  </div>

  @if(session('success'))
    <div class="mb-4 rounded-lg bg-emerald-500/10 border border-emerald-500 text-emerald-100 p-4">{{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="mb-4 rounded-lg bg-rose-500/10 border border-rose-500 text-rose-100 p-4">{{ session('error') }}</div>
  @endif

  <div class="overflow-x-auto rounded-2xl border border-white/10 bg-[#101010] p-3">
    <table class="min-w-full text-left text-sm text-white">
      <thead>
        <tr class="text-xs uppercase tracking-[0.16em] text-gray-400 border-b border-white/10">
          <th class="px-3 py-3">Nama</th>
          <th class="px-3 py-3">Email</th>
          <th class="px-3 py-3">Role</th>
          <th class="px-3 py-3">Status</th>
          <th class="px-3 py-3">Created At</th>
          <th class="px-3 py-3">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($users as $user)
          <tr class="border-b border-white/5 hover:bg-white/5">
            <td class="px-3 py-3">{{ $user->name }}</td>
            <td class="px-3 py-3">{{ $user->email }}</td>
            <td class="px-3 py-3">{{ strtoupper($user->role) }}</td>
            <td class="px-3 py-3">{{ $user->is_active ? 'Aktif' : 'Nonaktif' }}</td>
            <td class="px-3 py-3">{{ $user->created_at->format('d M Y') }}</td>
            <td class="px-3 py-3 flex gap-2">
              <a href="{{ route('users.edit', $user) }}" class="px-3 py-1 rounded-lg bg-blue-500/10 text-blue-200">Edit</a>
              @if($user->id !== auth()->id())
              <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus user ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-3 py-1 rounded-lg bg-rose-500/10 text-rose-200">Hapus</button>
              </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $users->links() }}
  </div>
</div>
@endsection
