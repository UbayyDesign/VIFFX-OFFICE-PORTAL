@extends('layouts.app')

@section('title', 'Create Announcement')

@section('content')
<div class="px-5 py-8 max-w-4xl mx-auto">
  <div class="mb-8">
    <div class="text-[11px] tracking-[0.2em] uppercase text-gold/60 mb-2">Announcement</div>
    <h1 class="text-3xl font-bold text-white">Buat Pengumuman Baru</h1>
    <p class="text-gray-400 mt-2">Isi pengumuman baru untuk ditampilkan di portal.</p>
  </div>

  <form action="{{ route('announcements.store') }}" method="POST" class="space-y-6 rounded-3xl border border-white/10 bg-[#151515] p-8">
    @csrf
    @include('announcements.form')
  </form>
</div>
@endsection
