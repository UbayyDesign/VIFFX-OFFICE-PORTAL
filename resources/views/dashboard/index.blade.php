@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="flex flex-col lg:flex-row gap-4 p-4 h-full">

  {{-- CENTER COLUMN --}}
  <div class="flex-1 flex flex-col gap-3.5 min-w-0">

    {{-- HERO --}}
    <div class="rounded-2xl p-7 relative overflow-hidden min-h-[180px] bg-cover bg-center"
         style="background-image: linear-gradient(135deg, rgba(17,24,39,0.82), rgba(15,23,42,0.88)), url('/images/backgrounds/dashboard-hero.svg');">
      <div class="relative z-10">
        <p class="text-[13px] text-white/70 mb-1">Good Morning,</p>
        <h1 class="text-[26px] font-bold mb-1.5">
          {{ auth()->user()->name }} <span>👋</span>
        </h1>
        <p class="text-[12px] text-white/60 leading-relaxed">
          Welcome back to VIFFX Portal<br>
          One access for all company systems.<br>
          Have a productive day!
        </p>
        <div class="flex gap-4 mt-5 flex-wrap">
          @foreach($systemStatuses as $sys)
          @php $statusClass = strtolower($sys['status'] ?? 'Online') === 'error' ? 'bg-rose-500' : 'bg-emerald-500'; @endphp
          <div class="flex items-center gap-1.5">
            <div class="w-[18px] h-[18px] rounded-full {{ $statusClass }} flex items-center justify-center flex-shrink-0">
              <svg class="w-2.5 h-2.5" fill="none" stroke="white" stroke-width="3" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            </div>
            <div>
              <div class="text-[11px] font-semibold">{{ $sys['name'] }}</div>
              <div class="text-[10px] font-medium {{ strtolower($sys['status'] ?? 'Online') === 'error' ? 'text-rose-300' : 'text-emerald-300' }}">{{ $sys['status'] }}</div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="absolute right-7 top-1/2 -translate-y-1/2 text-center opacity-50 z-10">
        <div class="text-[38px] font-black text-gold tracking-widest leading-none">VIFX</div>
        <div class="text-[9px] text-white/50 tracking-[3px] mt-1">Vision • Integrity • Freedom</div>
      </div>
    </div>

    {{-- STATS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-2.5">
      <div class="stat-card">
        <div class="flex justify-between items-start mb-2">
          <span class="text-[11px] text-gray-400">Total Users</span>
          <div class="w-8 h-8 rounded-lg bg-blue-500/15 flex items-center justify-center text-base">👥</div>
        </div>
        <div class="text-[26px] font-bold leading-none mb-1">{{ $stats['total_users'] }}</div>
        <div class="text-[10px] text-gray-400">Active Users</div>
        <div class="text-[10px] text-green-400 font-medium mt-0.5">+12% from last month</div>
      </div>
      <div class="stat-card">
        <div class="flex justify-between items-start mb-2">
          <span class="text-[11px] text-gray-400">Total Teams</span>
          <div class="w-8 h-8 rounded-lg bg-green-500/15 flex items-center justify-center text-base">👨‍👩‍👧</div>
        </div>
        <div class="text-[26px] font-bold leading-none mb-1">{{ $stats['total_teams'] }}</div>
        <div class="text-[10px] text-gray-400">Active Teams</div>
        <div class="text-[10px] text-green-400 font-medium mt-0.5">+1 from last month</div>
      </div>
      <div class="stat-card">
        <div class="flex justify-between items-start mb-2">
          <span class="text-[11px] text-gray-400">Total Reports</span>
          <div class="w-8 h-8 rounded-lg bg-gold/15 flex items-center justify-center text-base">📋</div>
        </div>
        <div class="text-[26px] font-bold leading-none mb-1">{{ number_format($stats['total_reports']) }}</div>
        <div class="text-[10px] text-gray-400">This Month</div>
        <div class="text-[10px] text-green-400 font-medium mt-0.5">+18% from last month</div>
      </div>
      <div class="stat-card">
        <div class="flex justify-between items-start mb-2">
          <span class="text-[11px] text-gray-400">Total Candidates</span>
          <div class="w-8 h-8 rounded-lg bg-red-500/15 flex items-center justify-center text-base">👤</div>
        </div>
        <div class="text-[26px] font-bold leading-none mb-1">{{ $stats['total_candidates'] }}</div>
        <div class="text-[10px] text-gray-400">In Database</div>
        <div class="text-[10px] text-green-400 font-medium mt-0.5">+25% from last month</div>
      </div>
    </div>

    {{-- ALL SYSTEMS --}}
    <div>
      <h2 class="text-sm font-semibold mb-2.5">All Systems</h2>
      <div class="grid grid-cols-3 gap-2.5">

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-green-500/15 flex items-center justify-center text-xl mb-1">🌐</div>
          <div class="text-[13px] font-semibold">Company Website</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Website resmi perusahaan VIFX</div>
          <a href="https://viffx.com" class="sys-btn" target="_blank" rel="noopener noreferrer">Open Website →</a>
        </div>

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-indigo-500/15 flex items-center justify-center text-xl mb-1">📤</div>
          <div class="text-[13px] font-semibold">Vimport</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Import dan kelola data perusahaan secara terpusat</div>
          <a href="https://vimport.viffx.com" class="sys-btn" target="_blank" rel="noopener noreferrer">Open System →</a>
        </div>

        @if($hasKpiAccess ?? false)
        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-gold/15 flex items-center justify-center text-xl mb-1">📊</div>
          <div class="text-[13px] font-semibold">KPI Marketing</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Dashboard KPI, laporan marketing, report harian</div>
          <a href="{{ route('kpi.sso.login') }}" class="sys-btn">Open System →</a>
        </div>
        @endif

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-purple-500/15 flex items-center justify-center text-xl mb-1">👥</div>
          <div class="text-[13px] font-semibold">Recruitment Database</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Kelola data pelamar, interview, dan status kandidat</div>
          <a href="https://ro.viffx.com" class="sys-btn" target="_blank" rel="noopener noreferrer">Open System →</a>
        </div>

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-blue-500/15 flex items-center justify-center text-xl mb-1">☁️</div>
          <div class="text-[13px] font-semibold">Nextcloud</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Akses file, dokumen dan data kantor</div>
          <a href="{{ Route::has('nextcloud.index') ? route('nextcloud.index') : '#' }}" class="sys-btn">Open System →</a>
        </div>

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-yellow-500/15 flex items-center justify-center text-xl mb-1">📰</div>
          <div class="text-[13px] font-semibold">News</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Analisa trading dan berita pasar terkini</div>
          <a href="{{ Route::has('news.index') ? route('news.index') : '#' }}" class="sys-btn">Open News →</a>
        </div>

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-pink-500/15 flex items-center justify-center text-xl mb-1">📈</div>
          <div class="text-[13px] font-semibold">OHLC</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Data Open, High, Low, Close harga aset trading</div>
          <a href="{{ Route::has('ohlc.index') ? route('ohlc.index') : '#' }}" class="sys-btn">Open OHLC →</a>
        </div>

        <div class="sys-card">
          <div class="w-11 h-11 rounded-xl bg-orange-500/15 flex items-center justify-center text-xl mb-1">📢</div>
          <div class="text-[13px] font-semibold">Announcement</div>
          <div class="text-[11px] text-gray-400 leading-relaxed flex-1">Pengumuman dan informasi penting perusahaan</div>
          <a href="{{ Route::has('announcements.index') ? route('announcements.index') : '#' }}" class="sys-btn">View All →</a>
        </div>


      </div>

      {{-- Calendar full width --}}
      <div class="sys-card mt-2.5" style="flex-direction:row; display:flex; align-items:center;">
        <div class="w-11 h-11 rounded-xl bg-teal-500/15 flex items-center justify-center text-xl flex-shrink-0">📅</div>
        <div class="ml-4 flex-1">
          <div class="text-[13px] font-semibold">Calendar</div>
          <div class="text-[11px] text-gray-400">Jadwal meeting, event, dan agenda perusahaan</div>
        </div>
        <a href="{{ Route::has('calendar.index') ? route('calendar.index') : '#' }}" class="sys-btn" style="margin-top:0;">Open Calendar →</a>
      </div>
    </div>

  </div>{{-- /center-col --}}

  {{-- RIGHT PANEL — hanya Announcement + Calendar (Quick Access dihapus) --}}
  <aside class="w-full lg:w-64 flex-shrink-0 flex flex-col gap-3.5 overflow-y-auto">

    {{-- ANNOUNCEMENTS --}}
    <div class="panel-card">
      <div class="flex justify-between items-center mb-3">
        <h3 class="text-[13px] font-semibold">Announcement</h3>
        <a href="{{ Route::has('announcements.index') ? route('announcements.index') : '#' }}" class="text-[11px] text-gold font-medium">View All</a>
      </div>
      @foreach($announcements as $ann)
      <div class="flex gap-2.5 mb-3 pb-3 border-b border-white/[0.06] last:border-0 last:mb-0 last:pb-0">
        <div class="w-8 h-8 rounded-lg {{ $ann->icon_bg }} flex items-center justify-center text-sm flex-shrink-0">
          {{ $ann->icon }}
        </div>
        <div>
          @if($ann->is_new)
            <span class="inline-block bg-gold text-black text-[8px] font-bold px-1.5 py-0.5 rounded mb-1">New</span>
          @endif
          <div class="text-[12px] font-semibold">{{ $ann->title }}</div>
          <div class="text-[10px] text-gray-400 leading-relaxed mb-1">{{ Str::limit($ann->description, 60) }}</div>
          <div class="text-[10px] text-gray-600">{{ $ann->created_at->format('d M Y') }}</div>
        </div>
      </div>
      @endforeach
    </div>

    {{-- CALENDAR --}}
    <div class="panel-card">
      <div class="flex justify-between items-center mb-2.5">
        <h3 class="text-[13px] font-semibold">
          Calendar <span class="text-[10px] text-gray-500 font-normal">(Today)</span>
        </h3>
        <a href="{{ Route::has('calendar.index') ? route('calendar.index') : '#' }}" class="text-[11px] text-gold font-medium">View All</a>
      </div>
      <div class="text-[12px] text-gray-400 mb-2.5 font-medium">
        {{ now()->translatedFormat('d F Y') }}
      </div>
      @foreach($todayEvents as $event)
      <div class="flex gap-2 mb-2 items-start">
        <div class="text-[11px] text-gold font-semibold min-w-[36px]">
          {{ \Carbon\Carbon::parse($event->start_time)->format('H:i') }}
        </div>
        <div>
          <div class="text-[12px] font-medium">{{ $event->title }}</div>
          <div class="text-[10px] text-gray-500">{{ $event->location }}</div>
        </div>
      </div>
      @endforeach
      @if($todayEvents->isEmpty())
        <div class="text-[11px] text-gray-500 text-center py-3">Tidak ada acara hari ini</div>
      @endif
    </div>

  </aside>

</div>
@endsection
