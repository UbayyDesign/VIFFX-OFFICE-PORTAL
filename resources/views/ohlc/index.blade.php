@extends('layouts.app')

@section('title', 'OHLC Data')

@section('content')
<div class="px-5 py-8 max-w-6xl mx-auto">
  <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
      <div class="text-[11px] tracking-[0.2em] uppercase text-gold/60 mb-2">{{ $page['eyebrow'] ?? 'Market Data' }}</div>
      <h1 class="text-3xl font-bold text-white">{{ $page['title'] ?? 'OHLC Data' }}</h1>
      <p class="text-gray-400 mt-2 max-w-2xl">{{ $page['description'] ?? 'Open, High, Low, Close harga aset trading' }}</p>
    </div>
  </div>

  @if(session('success'))
    <div class="rounded-2xl border border-emerald-400/20 bg-emerald-400/10 p-4 text-emerald-100 mb-6">
      {{ session('success') }}
    </div>
  @endif

  <div class="grid gap-4 lg:grid-cols-2">
    @forelse($ohlcData as $data)
      <article class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-xl shadow-black/10">
        <div class="flex items-start justify-between mb-4">
          <div>
            <div class="text-2xl font-bold text-white">{{ $data['symbol'] }}</div>
            <div class="text-sm text-gray-400 mt-1">{{ $data['date'] }}</div>
          </div>
          <div class="flex gap-2">
            <a href="{{ route('ohlc.show', $data['symbol']) }}" class="px-3 py-1.5 rounded-lg bg-blue-500/10 text-blue-200 hover:bg-blue-500/20 transition-colors text-xs font-medium">Detail</a>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-4">
          <div>
            <div class="text-xs text-gray-500 mb-1">Open</div>
            <div class="text-lg font-bold text-white">${{ number_format($data['open'], 2) }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500 mb-1">High</div>
            <div class="text-lg font-bold text-emerald-400">${{ number_format($data['high'], 2) }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500 mb-1">Low</div>
            <div class="text-lg font-bold text-rose-400">${{ number_format($data['low'], 2) }}</div>
          </div>
          <div>
            <div class="text-xs text-gray-500 mb-1">Close</div>
            <div class="text-lg font-bold text-sky-400">${{ number_format($data['close'], 2) }}</div>
          </div>
        </div>

        <div class="pt-4 border-t border-white/10">
          <div class="text-xs text-gray-500">
            Change: 
            @php
              $change = $data['close'] - $data['open'];
              $changePercent = ($change / $data['open']) * 100;
              $changeClass = $change >= 0 ? 'text-emerald-400' : 'text-rose-400';
            @endphp
            <span class="{{ $changeClass }} font-bold">
              {{ $change >= 0 ? '+' : '' }}{{ number_format($change, 2) }} ({{ number_format($changePercent, 2) }}%)
            </span>
          </div>
        </div>
      </article>
    @empty
      <div class="col-span-full rounded-2xl border border-white/[0.08] bg-black/10 p-8 text-center">
        <div class="text-gray-400">Tidak ada data OHLC tersedia</div>
      </div>
    @endforelse
  </div>

  <div class="mt-8 p-6 rounded-2xl border border-white/10 bg-[#151515]">
    <h3 class="text-lg font-bold mb-3">📊 Tentang OHLC</h3>
    <p class="text-gray-400 text-sm leading-relaxed">
      OHLC (Open, High, Low, Close) adalah istilah yang digunakan di pasar keuangan untuk menggambarkan empat titik harga penting dalam periode tertentu:
    </p>
    <ul class="mt-4 space-y-2 text-sm text-gray-400">
      <li><strong class="text-white">Open (O):</strong> Harga pembukaan pada awal periode</li>
      <li><strong class="text-white">High (H):</strong> Harga tertinggi yang dicapai selama periode</li>
      <li><strong class="text-white">Low (L):</strong> Harga terendah yang dicapai selama periode</li>
      <li><strong class="text-white">Close (C):</strong> Harga penutupan pada akhir periode</li>
    </ul>
  </div>
</div>
@endsection
