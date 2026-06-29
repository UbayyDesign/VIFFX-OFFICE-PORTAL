@extends('layouts.app')

@section('title', $page['title'] ?? 'OHLC Detail')

@section('content')
<div class="px-5 py-8 max-w-4xl mx-auto">
  <div class="mb-8 flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
    <div>
      <div class="text-[11px] tracking-[0.2em] uppercase text-gold/60 mb-2">{{ $page['eyebrow'] ?? 'Market Detail' }}</div>
      <h1 class="text-3xl font-bold text-white">{{ $page['title'] ?? 'OHLC Detail' }}</h1>
      <p class="text-gray-400 mt-2 max-w-2xl">{{ $page['description'] ?? 'Analisis detail OHLC' }}</p>
    </div>
    <a href="{{ route('ohlc.index') }}" class="sys-btn">← Back to List</a>
  </div>

  <div class="grid gap-6">
    {{-- Header Card --}}
    <article class="rounded-3xl border border-white/10 bg-[#151515] p-6 shadow-xl shadow-black/10">
      <div class="flex items-center justify-between mb-4">
        <div>
          <div class="text-4xl font-bold text-white">{{ $ohlcDetail['symbol'] }}</div>
          <div class="text-sm text-gray-400 mt-1">{{ $ohlcDetail['name'] }}</div>
        </div>
        <div class="text-right">
          <div class="text-sm text-gray-400 mb-1">Market Cap</div>
          <div class="text-2xl font-bold text-gold">{{ $ohlcDetail['marketCap'] }}</div>
        </div>
      </div>
      <div class="grid grid-cols-3 gap-4">
        <div>
          <div class="text-xs text-gray-500 mb-2">Sektor</div>
          <div class="font-semibold text-white">{{ $ohlcDetail['sector'] }}</div>
        </div>
        <div>
          <div class="text-xs text-gray-500 mb-2">Volume</div>
          <div class="font-semibold text-white">{{ number_format($ohlcDetail['volume']) }}</div>
        </div>
        <div>
          <div class="text-xs text-gray-500 mb-2">Update</div>
          <div class="font-semibold text-white">{{ $ohlcDetail['date'] }}</div>
        </div>
      </div>
    </article>

    {{-- OHLC Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
      <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
        <div class="text-xs text-gray-500 mb-2">Open</div>
        <div class="text-3xl font-bold text-white">${{ number_format($ohlcDetail['open'], 2) }}</div>
        <div class="text-xs text-gray-600 mt-2">Harga Pembukaan</div>
      </div>

      <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
        <div class="text-xs text-gray-500 mb-2">High</div>
        <div class="text-3xl font-bold text-emerald-400">${{ number_format($ohlcDetail['high'], 2) }}</div>
        <div class="text-xs text-gray-600 mt-2">Harga Tertinggi</div>
      </div>

      <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
        <div class="text-xs text-gray-500 mb-2">Low</div>
        <div class="text-3xl font-bold text-rose-400">${{ number_format($ohlcDetail['low'], 2) }}</div>
        <div class="text-xs text-gray-600 mt-2">Harga Terendah</div>
      </div>

      <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
        <div class="text-xs text-gray-500 mb-2">Close</div>
        <div class="text-3xl font-bold text-sky-400">${{ number_format($ohlcDetail['close'], 2) }}</div>
        <div class="text-xs text-gray-600 mt-2">Harga Penutupan</div>
      </div>
    </div>

    {{-- Analysis Card --}}
    <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
      <h3 class="text-lg font-bold mb-4">📈 Analisis OHLC</h3>
      
      @php
        $range = $ohlcDetail['high'] - $ohlcDetail['low'];
        $change = $ohlcDetail['close'] - $ohlcDetail['open'];
        $changePercent = ($change / $ohlcDetail['open']) * 100;
        $pricePercentile = (($ohlcDetail['close'] - $ohlcDetail['low']) / $range) * 100;
      @endphp

      <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
          <div class="text-sm text-gray-400 mb-1">Perubahan Harga</div>
          <div class="flex items-baseline gap-2">
            <span class="text-2xl font-bold {{ $change >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
              {{ $change >= 0 ? '+' : '' }}{{ number_format($change, 2) }}
            </span>
            <span class="text-sm {{ $change >= 0 ? 'text-emerald-400' : 'text-rose-400' }}">
              ({{ number_format($changePercent, 2) }}%)
            </span>
          </div>
        </div>

        <div>
          <div class="text-sm text-gray-400 mb-1">Range Harian</div>
          <div class="text-2xl font-bold text-white">${{ number_format($range, 2) }}</div>
        </div>
      </div>

      <div class="mb-4">
        <div class="text-sm text-gray-400 mb-2">Posisi Harga dalam Range</div>
        <div class="flex h-2 rounded-full overflow-hidden bg-white/10">
          <div class="bg-gold flex-grow"></div>
        </div>
        <div class="text-xs text-gray-500 mt-1">{{ number_format($pricePercentile, 1) }}% dalam range harian</div>
      </div>

      <p class="text-sm text-gray-400 leading-relaxed">
        @if($changePercent >= 5)
          Pergerakan yang kuat dengan penutupan yang lebih tinggi dari pembukaan.
        @elseif($changePercent >= 0)
          Pergerakan positif yang moderat dengan penutupan di atas pembukaan.
        @elseif($changePercent >= -5)
          Pergerakan negatif yang moderat dengan penutupan di bawah pembukaan.
        @else
          Pergerakan yang kuat ke bawah dengan penurunan yang signifikan.
        @endif
      </p>
    </div>

    {{-- Information Card --}}
    <div class="rounded-2xl border border-white/10 bg-[#151515] p-6">
      <h3 class="text-lg font-bold mb-3">ℹ️ Informasi OHLC</h3>
      <p class="text-sm text-gray-400 leading-relaxed">
        Data OHLC menunjukkan pergerakan harga suatu aset dalam periode tertentu. Informasi ini digunakan oleh trader dan investor untuk:
      </p>
      <ul class="mt-4 space-y-2 text-sm text-gray-400">
        <li class="flex gap-2"><span class="text-gold">✓</span> Menganalisis volatilitas harga</li>
        <li class="flex gap-2"><span class="text-gold">✓</span> Mengidentifikasi tren pasar</li>
        <li class="flex gap-2"><span class="text-gold">✓</span> Membuat keputusan trading</li>
        <li class="flex gap-2"><span class="text-gold">✓</span> Menetapkan support dan resistance level</li>
      </ul>
    </div>
  </div>
</div>
@endsection
