@extends('layouts.app')

@section('title', $page['title'])

@section('content')
@php
    \Illuminate\Support\Facades\Log::info('NewsBlade payload', [
        'feedFailed' => $feedFailed,
        'items_count' => count($items),
        'first_item_title' => count($items) ? $items[0]['title'] : null,
    ]);
@endphp
<div class="p-4 md:p-6 space-y-6">
  <div class="rounded-3xl border border-white/10 bg-[#151515] p-6 shadow-2xl shadow-black/20">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
      <div>
        <p class="text-xs uppercase tracking-[0.35em] text-gold/80">{{ $page['eyebrow'] }}</p>
        <h1 class="mt-2 text-2xl font-semibold text-white md:text-3xl">{{ $page['title'] }}</h1>
        <p class="mt-3 max-w-2xl text-sm text-gray-300 md:text-base">{{ $page['description'] }}</p>
      </div>
      <div class="rounded-2xl border border-white/10 bg-black/20 px-4 py-3 text-sm text-gray-200">
        <div class="font-semibold text-gold">Status saat ini</div>
        <div class="mt-1 flex items-center gap-2 text-xs text-gray-300">
          <span class="h-2.5 w-2.5 rounded-full {{ $page['status_color'] ?? 'bg-emerald-400' }}"></span>
          {{ $page['status_label'] ?? 'Online' }}
        </div>
      </div>
    </div>
  </div>

  <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
    @if(count($items) > 0)
      <div class="grid gap-4">
        @foreach($items as $item)
          <article class="rounded-3xl border border-white/8 bg-black/20 p-5 shadow-sm shadow-black/10 transition hover:-translate-y-0.5 hover:border-gold/30">
            <div class="flex flex-col gap-4 md:flex-row md:items-start md:justify-between">
              <div class="space-y-3">
                <div class="flex flex-wrap items-center gap-2">
                  @foreach($item['categories'] as $category)
                    <span class="rounded-full border border-gray-700/80 bg-gray-800/80 px-3 py-1 text-[11px] font-semibold uppercase tracking-[0.22em] text-gray-300">{{ $category }}</span>
                  @endforeach
                </div>
                <h2 class="text-xl font-semibold text-white">{{ $item['title'] }}</h2>
                <p class="text-xs uppercase tracking-[0.25em] text-gray-500">{{ $item['published_at'] }}</p>
                <p class="mt-3 text-sm leading-6 text-gray-300">{{ $item['summary'] }}</p>
              </div>
              <div class="flex items-center md:justify-end">
                <a href="{{ $item['link'] }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-2xl bg-gold px-4 py-3 text-sm font-semibold text-black transition hover:bg-amber-300">
                  Baca Artikel
                </a>
              </div>
            </div>
          </article>
        @endforeach
      </div>
    @elseif(! empty($feedFailed) && $feedFailed)
      <div class="rounded-3xl border border-white/8 bg-black/20 p-10 text-center text-gray-300">
        <p class="text-lg font-semibold text-white">Berita sementara tidak tersedia.</p>
        <p class="mt-2 text-sm text-gray-400">Silakan coba beberapa saat lagi.</p>
      </div>
    @else
      <div class="rounded-3xl border border-white/8 bg-black/20 p-10 text-center text-gray-300">
        <p class="text-lg font-semibold text-white">Tidak ada berita tersedia saat ini.</p>
        <p class="mt-2 text-sm text-gray-400">Coba muat ulang halaman setelah beberapa saat. Jika feed tidak tersedia, informasi akan kembali otomatis saat koneksi pulih.</p>
      </div>
    @endif
  </section>
</div>
@endsection
