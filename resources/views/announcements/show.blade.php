@extends('layouts.app')

@section('title', $announcement->title)

@section('content')
<div class="px-5 py-8 max-w-4xl mx-auto">
  <div class="mb-8 rounded-3xl border border-white/10 bg-[#151515] p-8 shadow-xl shadow-black/10">
    <div class="flex items-center gap-4 mb-6">
      <div class="w-14 h-14 rounded-3xl {{ $announcement->icon_bg }} flex items-center justify-center text-3xl">{{ $announcement->icon }}</div>
      <div>
        <div class="text-[11px] uppercase tracking-[0.25em] text-gold/70">Announcement</div>
        <h1 class="mt-2 text-3xl font-semibold text-white">{{ $announcement->title }}</h1>
        <p class="mt-1 text-sm text-gray-400">{{ $announcement->created_at->translatedFormat('d M Y H:i') }} - {{ $announcement->is_new ? 'New' : 'Published' }}</p>
      </div>
    </div>

    <div class="prose prose-invert max-w-none text-gray-200">
      <p>{{ $announcement->description }}</p>
    </div>

    <div class="mt-8 flex flex-wrap gap-3">
      <a href="{{ route('announcements.edit', $announcement) }}" class="sys-btn">Edit</a>
      <a href="{{ route('announcements.index') }}" class="sys-btn bg-slate-700 hover:bg-slate-600">Back to list</a>
    </div>
  </div>
</div>
@endsection
