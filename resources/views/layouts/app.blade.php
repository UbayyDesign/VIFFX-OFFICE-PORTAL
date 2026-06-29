<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="theme-color" content="#0d0d0d">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>VIFFX Portal — @yield('title', 'Dashboard')</title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
  <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}" />
  <link rel="apple-touch-icon" href="{{ asset('images/logos/vifx-logo.png') }}">
  <link rel="icon" type="image/png" href="{{ asset('images/logos/vifx-logo.png') }}">
  <link rel="mask-icon" href="{{ asset('images/logos/vifx-logo.png') }}" color="#111827">
  <meta name="msapplication-TileImage" content="{{ asset('images/logos/vifx-logo.png') }}">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
@php
  $notifications = $layoutNotifications ?? [];
  $unreadNotificationCount = $unreadNotificationCount ?? count($notifications);
@endphp

{{--
  FIX 1: Tambah sidebarOpen dan profileOpen ke x-data di <body>
  Sebelumnya sidebarOpen dipakai di aside tapi tidak dideklarasikan → Alpine error
--}}
<body x-data="{
  sidebarOpen: false,
  notificationOpen: false,
  profileOpen: false,
  theme: localStorage.getItem('vif-theme') || 'dark',
  searchQuery: '',
  menuItems: [
    { label: 'Dashboard',        url: '{{ Route::has('dashboard') ? route('dashboard') : '#' }}',                    keywords: ['dashboard', 'utama', 'home'] },
    { label: 'Company Website',  url: 'https://viffx.com',                                                           keywords: ['company', 'website', 'perusahaan'] },
    { label: 'Vimport',          url: 'https://vimport.viffx.com',                                                   keywords: ['vimport', 'import', 'data'] },
      @if($hasKpiAccess ?? false)
      { label: 'KPI Marketing',    url: '{{ Route::has('kpi.sso.login') ? route('kpi.sso.login') : '#' }}',                                                    keywords: ['kpi', 'dashboard', 'report', 'marketing'] },
      @endif
    { label: 'Recruitment',      url: 'https://ro.viffx.com',                                                        keywords: ['recruitment', 'candidate', 'pelamar', 'hr'] },
    { label: 'Nextcloud',        url: '{{ Route::has('nextcloud.index') ? route('nextcloud.index') : '#' }}',        keywords: ['nextcloud', 'file', 'dokumen', 'storage'] },
    { label: 'News Analisa Trading', url: '{{ Route::has('news.index') ? route('news.index') : '#' }}',             keywords: ['news', 'analisa', 'trading', 'berita'] },
    { label: 'OHLC',             url: '{{ Route::has('ohlc.index') ? route('ohlc.index') : '#' }}',                 keywords: ['ohlc', 'open', 'high', 'low', 'close', 'chart'] },
    { label: 'Announcement',     url: '{{ Route::has('announcements.index') ? route('announcements.index') : '#' }}', keywords: ['announcement', 'pengumuman', 'info'] },
    { label: 'User Management',  url: '{{ Route::has('users.index') ? route('users.index') : '#' }}',               keywords: ['user', 'admin', 'management', 'role'] },
    { label: 'Calendar',         url: '{{ Route::has('calendar.index') ? route('calendar.index') : '#' }}',         keywords: ['calendar', 'agenda', 'jadwal', 'event'] },
    { label: 'System Status',    url: '{{ Route::has('system.status') ? route('system.status') : '#' }}',           keywords: ['system', 'status', 'server', 'monitoring'] },
    { label: 'Profile Setting',  url: '{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}',             keywords: ['profile', 'setting', 'akun', 'password'] },
  ],
  filteredMenu: []
}"
     x-init="filteredMenu = menuItems"
     x-effect="
       document.body.classList.toggle('theme-light', theme === 'light');
       document.body.classList.toggle('theme-dark', theme === 'dark');
       localStorage.setItem('vif-theme', theme);
     "
     class="flex h-screen overflow-hidden bg-[#0d0d0d] text-white text-[13px]">

  {{-- Overlay mobile --}}
  <div class="fixed inset-0 z-30 bg-black/60 lg:hidden"
       x-show="sidebarOpen"
       x-transition.opacity
       @click="sidebarOpen = false"
       style="display:none;"></div>

  {{-- ═══════════════════════════════════════════
       SIDEBAR
  ═══════════════════════════════════════════ --}}
  <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
         class="fixed inset-y-0 left-0 z-40 w-[220px] lg:static lg:w-[200px]
                bg-[#111] flex flex-col py-5 border-r border-white/[0.06]
                flex-shrink-0 overflow-y-auto shadow-2xl shadow-black/40
                lg:shadow-none transition-transform duration-200">

    {{-- Logo --}}
    <div class="px-[18px] pb-5">
      <a href="{{ route('dashboard') }}" class="block rounded-lg hover:opacity-90 transition-opacity">
        <img src="{{ asset('images/logos/vifx-logo.png') }}" alt="VIFFX logo" class="h-18 w-auto" />
      </a>
    </div>

    {{-- ── NAV ITEMS (urutan sesuai permintaan) ── --}}
    <nav class="flex flex-col gap-0.5 flex-1">

      {{-- 1. Dashboard --}}
      <a href="{{ Route::has('dashboard') ? route('dashboard') : '#' }}"
         class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="3" width="7" height="7" rx="1"/>
          <rect x="14" y="3" width="7" height="7" rx="1"/>
          <rect x="3" y="14" width="7" height="7" rx="1"/>
          <rect x="14" y="14" width="7" height="7" rx="1"/>
        </svg>
        Dashboard
      </a>

      {{-- 2. Company Website (eksternal) --}}
      <a href="https://viffx.com" target="_blank" rel="noopener noreferrer" class="nav-item">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <circle cx="12" cy="12" r="10"/>
          <line x1="2" y1="12" x2="22" y2="12"/>
          <path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/>
        </svg>
        Company Website
        <svg class="w-3 h-3 ml-auto text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
          <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
      </a>

      {{-- 3. Vimport (eksternal) --}}
      <a href="https://vimport.viffx.com" target="_blank" rel="noopener noreferrer" class="nav-item">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <polyline points="16 16 12 12 8 16"/>
          <line x1="12" y1="12" x2="12" y2="21"/>
          <path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"/>
        </svg>
        Vimport
        <svg class="w-3 h-3 ml-auto text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
          <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
      </a>

      {{-- 4. KPI Marketing (eksternal) --}}
      @if($hasKpiAccess ?? false)
      <a href="{{ Route::has('kpi.sso.login') ? route('kpi.sso.login') : '#' }}" class="nav-item">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        KPI Marketing
        <svg class="w-3 h-3 ml-auto text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
          <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
      </a>
      @endif

      {{-- 5. Recruitment (eksternal) --}}
      <a href="https://ro.viffx.com" target="_blank" rel="noopener noreferrer" class="nav-item">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        Recruitment
        <svg class="w-3 h-3 ml-auto text-gray-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/>
          <polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/>
        </svg>
      </a>

      {{-- 6. Nextcloud --}}
      <a href="{{ Route::has('nextcloud.index') ? route('nextcloud.index') : '#' }}"
         class="nav-item {{ request()->routeIs('nextcloud.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 20V10"/><path d="M12 20V4"/><path d="M6 20v-6"/>
        </svg>
        Nextcloud
      </a>

      {{-- 7. News Analisa Trading --}}
      <a href="{{ Route::has('news.index') ? route('news.index') : '#' }}"
         class="nav-item {{ request()->routeIs('news.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2"/>
          <path d="M18 14h-8"/><path d="M15 18h-5"/><path d="M10 6h8v4h-8V6Z"/>
        </svg>
        News Analisa Trading
      </a>

      {{-- 8. OHLC --}}
      <a href="{{ Route::has('ohlc.index') ? route('ohlc.index') : '#' }}"
         class="nav-item {{ request()->routeIs('ohlc.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <line x1="18" y1="20" x2="18" y2="10"/>
          <line x1="12" y1="20" x2="12" y2="4"/>
          <line x1="6" y1="20" x2="6" y2="14"/>
          <line x1="15" y1="10" x2="18" y2="10"/>
          <line x1="9" y1="4" x2="12" y2="4"/>
          <line x1="3" y1="14" x2="6" y2="14"/>
        </svg>
        OHLC
      </a>

      {{-- 9. Announcement --}}
      <a href="{{ Route::has('announcements.index') ? route('announcements.index') : '#' }}"
         class="nav-item {{ request()->routeIs('announcements.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
          <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
        </svg>
        Announcement
      </a>

      {{-- 10. User Management --}}
      <a href="{{ Route::has('users.index') ? route('users.index') : '#' }}"
         class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
          <circle cx="9" cy="7" r="4"/>
          <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
          <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
        </svg>
        User Management
      </a>

      {{-- 10. Calendar --}}
      <a href="{{ Route::has('calendar.index') ? route('calendar.index') : '#' }}"
         class="nav-item {{ request()->routeIs('calendar.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <rect x="3" y="4" width="18" height="18" rx="2"/>
          <line x1="16" y1="2" x2="16" y2="6"/>
          <line x1="8" y1="2" x2="8" y2="6"/>
          <line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        Calendar
      </a>

      {{-- 11. System Status --}}
      <a href="{{ Route::has('system.status') ? route('system.status') : '#' }}"
         class="nav-item {{ request()->routeIs('system.status') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/>
        </svg>
        System Status
      </a>

      {{-- 12. Profile Setting --}}
      <a href="{{ Route::has('profile.edit') ? route('profile.edit') : '#' }}"
         class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
          <circle cx="12" cy="7" r="4"/>
        </svg>
        Profile Setting
      </a>

    </nav>

    {{-- System Status (bawah sidebar) --}}
    <div class="mt-4 pt-4 px-3.5 border-t border-white/[0.06]">
      <h4 class="text-[11px] text-gray-400 mb-2.5 font-medium">System Status</h4>
      @foreach($systemStatuses ?? [] as $sys)
        @php
          $status = strtolower($sys['status'] ?? 'offline');
          if ($status === 'online') {
              $statusTone = 'text-emerald-300';
              $dotTone = 'bg-emerald-400';
          } elseif ($status === 'warning') {
              $statusTone = 'text-amber-300';
              $dotTone = 'bg-amber-400';
          } else {
              $statusTone = 'text-rose-300';
              $dotTone = 'bg-rose-400';
          }
        @endphp
        <div class="flex justify-between items-center mb-1.5 text-[11px]">
          <span class="text-gray-400">{{ $sys['name'] }}</span>
          <span class="flex items-center gap-1 {{ $statusTone }} font-medium">
            <span class="w-1.5 h-1.5 rounded-full {{ $dotTone }} inline-block animate-pulse"></span>
            {{ $sys['status'] }}
          </span>
        </div>
      @endforeach
      <a href="{{ Route::has('system.status') ? route('system.status') : '#' }}"
         class="block text-center text-gray-500 text-[11px] py-2 hover:text-gold transition-colors">
        View All Status
      </a>
    </div>

    <div class="px-[18px] text-[10px] text-gray-600 leading-relaxed pb-2">
      © 2026 VIFFX Group<br>All Rights Reserved.
    </div>
  </aside>

  {{-- ═══════════════════════════════════════════
       MAIN
  ═══════════════════════════════════════════ --}}
  <main class="flex-1 flex flex-col overflow-hidden min-w-0">

    {{-- TOPBAR --}}
    <header class="flex items-center px-5 py-3 border-b border-white/[0.06] bg-[#0d0d0d] flex-shrink-0 gap-3">

      {{-- Hamburger (mobile) --}}
      <button type="button"
              class="lg:hidden inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/[0.06] bg-[#1a1a1a] text-gray-200"
              @click="sidebarOpen = !sidebarOpen"
              aria-label="Toggle sidebar">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
      </button>

      {{-- Search --}}
      <div class="relative flex-1 max-w-md">
        <div class="flex items-center gap-2 bg-[#1a1a1a] border border-white/[0.06] rounded-lg px-3.5 py-2">
          <svg class="w-3.5 h-3.5 text-gray-500 flex-shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
          </svg>
          <input type="text" x-model="searchQuery"
                 @input="
                   const q = searchQuery.toLowerCase().trim();
                   filteredMenu = q
                     ? menuItems.filter(item => item.label.toLowerCase().includes(q) || item.keywords.some(k => k.includes(q)))
                     : menuItems
                 "
                 placeholder="Cari menu atau sistem..."
                 class="bg-transparent text-gray-200 text-[13px] outline-none w-full placeholder-gray-500">
        </div>

        {{-- Search dropdown --}}
        <div x-show="searchQuery.length > 0"
             x-transition
             @click.away="searchQuery = ''"
             class="absolute left-0 right-0 top-[calc(100%+6px)] z-50 rounded-2xl border border-white/10 bg-[#161616] p-2 shadow-2xl shadow-black/40"
             style="display:none;">
          <div class="mb-2 px-2 text-[11px] uppercase tracking-[0.25em] text-gold/80">Hasil pencarian</div>
          <template x-for="item in filteredMenu" :key="item.url">
            <a :href="item.url" class="block rounded-xl px-3 py-2 text-sm text-gray-200 hover:bg-white/5 transition-colors">
              <span x-text="item.label"></span>
            </a>
          </template>
          <div x-show="filteredMenu.length === 0" class="px-3 py-2 text-sm text-gray-400">
            Tidak ada hasil.
          </div>
        </div>
      </div>

      {{-- Icon actions --}}
      <div class="flex items-center gap-3.5 ml-auto">

        {{-- Notifikasi --}}
        <div class="relative">
          <button type="button"
                  @click="notificationOpen = !notificationOpen"
                  class="relative w-9 h-9 flex items-center justify-center bg-[#1a1a1a] border border-white/[0.06] rounded-lg text-gray-400 hover:text-white transition-colors"
                  aria-label="Notifications">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
              <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
            </svg>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[9px] w-4 h-4 rounded-full flex items-center justify-center font-bold">{{ $unreadNotificationCount }}</span>
          </button>

          <div x-show="notificationOpen"
               x-transition
               @click.away="notificationOpen = false"
               class="absolute right-0 mt-2 w-[320px] max-w-full rounded-3xl border border-white/10 bg-[#111] p-3 shadow-2xl shadow-black/40 z-50"
               style="display:none;">
            <div class="flex items-center justify-between px-2 mb-3">
              <div>
                <div class="text-sm font-semibold text-white">Notifikasi Terbaru</div>
                <div class="text-xs text-gray-400">{{ $unreadNotificationCount }} belum dibaca</div>
              </div>
              <a href="{{ Route::has('notifications.center') ? route('notifications.center') : '#' }}" class="text-xs text-gold hover:text-gold/80">Lihat semua</a>
            </div>

            @forelse($notifications as $item)
              <article class="rounded-2xl border border-white/[0.08] bg-black/20 p-3 mb-2 last:mb-0">
                <div class="flex items-start justify-between gap-3">
                  <div>
                    <div class="text-[12px] font-semibold text-white">{{ $item->title ?? 'Notifikasi' }}</div>
                    <p class="mt-1 text-[11px] text-gray-300 line-clamp-2">{{ $item->message ?? ($item->body ?? '') }}</p>
                    @if(!empty($item->url))
                      <div class="mt-2">
                        <a href="{{ $item->url }}" class="text-xs text-gold">Buka detail →</a>
                      </div>
                    @endif
                  </div>
                  <div class="flex flex-col items-end gap-2">
                    <span class="rounded-full px-2 py-1 text-[10px] flex-shrink-0
                      {{ ($item->tone ?? '') === 'warning' ? 'bg-amber-400/10 text-amber-300' :
                         (($item->tone ?? '') === 'success' ? 'bg-emerald-400/10 text-emerald-300' :
                         'bg-sky-400/10 text-sky-300') }}">
                      {{ optional($item->created_at)->diffForHumans() ?? 'Baru' }}
                    </span>
                    <form method="POST" action="{{ route('notifications.read', ['id' => $item->id]) }}">
                      @csrf
                      <button type="submit" class="text-xs text-gray-400 hover:text-white">Mark as read</button>
                    </form>
                  </div>
                </div>
              </article>
            @empty
              <div class="rounded-2xl border border-white/[0.08] bg-black/10 p-4 text-center text-gray-400">
                Tidak ada notifikasi terbaru.
              </div>
            @endforelse
          </div>
        </div>

        {{-- Dark / Light toggle --}}
        <button type="button"
                @click="theme = (theme === 'dark' ? 'light' : 'dark')"
                class="w-9 h-9 flex items-center justify-center bg-[#1a1a1a] border border-white/[0.06] rounded-lg text-gray-400 hover:text-white transition-colors"
                aria-label="Toggle theme">
          <svg x-show="theme === 'dark'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
          </svg>
          <svg x-show="theme === 'light'" class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" style="display:none;">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/>
          </svg>
        </button>

        {{-- User dropdown --}}
        <div class="relative">
          <button type="button"
                  @click="profileOpen = !profileOpen"
                  class="flex items-center gap-2 rounded-lg border border-white/10 bg-[#1a1a1a] px-2 py-1.5 hover:bg-white/5 focus:outline-none transition-colors">
            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-gray-500 to-gray-700 border-2 border-gold flex items-center justify-center text-[11px] font-bold overflow-hidden">
              @if(auth()->user()->avatar ?? false)
                <img src="{{ asset('storage/'.auth()->user()->avatar) }}" class="w-full h-full object-cover" alt="Avatar">
              @else
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
              @endif
            </div>
            <div class="hidden text-left md:block">
              <div class="text-[13px] font-semibold leading-none">{{ auth()->user()->name }}</div>
              <div class="text-[10px] text-gold mt-0.5">{{ auth()->user()->role ?? 'Administrator' }}</div>
            </div>
            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <polyline points="6 9 12 15 18 9"/>
            </svg>
          </button>

          <div x-show="profileOpen"
               x-transition
               @click.away="profileOpen = false"
               class="absolute right-0 top-12 z-50 w-56 rounded-2xl border border-white/10 bg-[#161616] p-2 shadow-2xl shadow-black/40"
               style="display:none;">
            <a href="{{ route('profile.edit') }}"
               class="block rounded-xl px-3 py-2 text-sm text-gray-200 hover:bg-white/5 transition-colors">
              Profile Setting
            </a>
            <a href="{{ Route::has('system.status') ? route('system.status') : '#' }}"
               class="block rounded-xl px-3 py-2 text-sm text-gray-200 hover:bg-white/5 transition-colors">
              System Status
            </a>
            <div class="border-t border-white/[0.06] mt-1 pt-1">
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full rounded-xl px-3 py-2 text-left text-sm text-rose-300 hover:bg-rose-400/10 transition-colors">
                  Logout
                </button>
              </form>
            </div>
          </div>
        </div>

      </div>
    </header>

    {{-- PAGE CONTENT --}}
    <div class="flex-1 overflow-y-auto">
      @yield('content')
    </div>

  </main>

</body>
</html>
