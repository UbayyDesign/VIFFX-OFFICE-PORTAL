@extends('layouts.app')

@section('title', 'Announcements')

@section('content')
<div class="px-5 py-8 max-w-6xl mx-auto">
  <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
      <div class="text-[11px] tracking-[0.2em] uppercase text-gold/60 mb-2">Announcement</div>
      <h1 class="text-3xl font-bold text-white">Pengumuman Internal</h1>
      <p class="text-gray-400 mt-2 max-w-2xl">Kelola pengumuman perusahaan dan informasi penting untuk semua pengguna.</p>
    </div>
    <a href="{{ route('announcements.create') }}" class="sys-btn">Buat Pengumuman Baru</a>
  </div>

  @if(session('success'))
    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-emerald-100 mb-6">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid gap-4 lg:grid-cols-2">
    @forelse($announcements as $announcement)
      <article class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-xl shadow-black/10">
        <div class="flex items-start gap-4 mb-3">
          <div class="w-12 h-12 rounded-2xl {{ $announcement->icon_bg }} flex items-center justify-center text-xl">{{ $announcement->icon }}</div>
          <div class="space-y-1">
            <div class="text-sm font-semibold text-slate-100">{{ $announcement->title }}</div>
            <div class="text-xs text-gray-400">{{ $announcement->created_at->translatedFormat('d M Y H:i') }}</div>
          </div>
        </div>

        <p class="text-sm text-gray-300 leading-relaxed">{{ Str::limit($announcement->description, 190) }}</p>

        <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-gray-400">
          <span class="rounded-full border border-white/10 bg-white/5 px-2 py-1">{{ $announcement->is_new ? 'New' : 'Published' }}</span>
          <span class="rounded-full border border-white/10 bg-white/5 px-2 py-1">Creator: {{ optional($announcement->creator)->name ?? 'System' }}</span>
        </div>

        <div class="mt-4 flex flex-wrap gap-2">
          <a href="{{ route('announcements.edit', $announcement) }}" class="sys-btn text-sm">Edit</a>
          <form action="{{ route('announcements.destroy', $announcement) }}" method="POST" class="inline-block">
            @csrf
            @method('DELETE')
            <button type="submit" class="sys-btn bg-rose-500 hover:bg-rose-400">Delete</button>
          </form>
          <a href="{{ route('announcements.show', $announcement) }}" class="sys-btn bg-slate-700 hover:bg-slate-600">View</a>
        </div>
      </article>
    @empty
      <div class="col-span-2 rounded-3xl border border-white/10 bg-[#151515] p-8 text-center text-gray-400">
        Tidak ada pengumuman tersedia.
      </div>
    @endforelse
  </div>

  <div class="mt-8">
    {{ $announcements->links() }}
  </div>
</div>
@endsection
