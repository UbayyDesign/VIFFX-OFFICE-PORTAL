@extends('layouts.app')

@section('content')
<div class="px-5 py-8 max-w-6xl mx-auto">
  {{-- Header Section --}}
  <div class="mb-8">
    <div class="flex items-start justify-between gap-6 mb-4">
      <div>
        <div class="text-[11px] tracking-[0.2em] uppercase text-gold/60 mb-2">
          {{ $page['eyebrow'] ?? 'Notifikasi' }}
        </div>
        <h1 class="text-3xl md:text-4xl font-bold text-white mb-3">
          {{ $page['title'] ?? 'Pusat Notifikasi' }}
        </h1>
        <p class="text-gray-300 text-sm leading-relaxed max-w-2xl">
          {{ $page['description'] ?? 'Kelola semua notifikasi sistem Anda.' }}
        </p>
      </div>
      <div class="flex items-center gap-2 px-3 py-1.5 rounded-full border border-white/10 bg-white/5 flex-shrink-0">
        <span class="w-2.5 h-2.5 rounded-full animate-pulse" :style="`background: linear-gradient(90deg, #fbbf24, #60a5fa)`"></span>
        <span class="text-[11px] text-gray-300">{{ $page['status_label'] ?? 'Live' }}</span>
      </div>
    </div>
  </div>

  {{-- Notifications Grid --}}
  <div class="grid grid-cols-1 gap-3">
    @forelse($notifications ?? [] as $notification)
      @php
        $tone = $notification->tone ?? 'info';
        $toneBg = match($tone) {
          'success' => 'border-emerald-400/20 bg-emerald-400/5 hover:bg-emerald-400/10',
          'warning' => 'border-amber-400/20 bg-amber-400/5 hover:bg-amber-400/10',
          'info'    => 'border-sky-400/20 bg-sky-400/5 hover:bg-sky-400/10',
          default   => 'border-gray-400/20 bg-gray-400/5 hover:bg-gray-400/10',
        };
        
        $toneBadge = match($tone) {
          'success' => 'bg-emerald-400/10 text-emerald-300',
          'warning' => 'bg-amber-400/10 text-amber-300',
          'info'    => 'bg-sky-400/10 text-sky-300',
          default   => 'bg-gray-400/10 text-gray-300',
        };

        $iconColor = match($tone) {
          'success' => 'text-emerald-400',
          'warning' => 'text-amber-400',
          'info'    => 'text-sky-400',
          default   => 'text-gray-400',
        };
      @endphp
      
      <article class="rounded-xl border {{ $toneBg }} p-4 transition-colors duration-200 group">
        <div class="flex items-start gap-4">
          {{-- Icon --}}
          <div class="w-10 h-10 rounded-lg bg-white/5 border border-white/10 flex items-center justify-center flex-shrink-0 {{ $iconColor }}">
            @if(($notification->icon ?? '') === 'server')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="2" y="3" width="20" height="8" rx="2"/><rect x="2" y="13" width="20" height="8" rx="2"/>
                <line x1="6" y1="7" x2="6.01" y2="7"/><line x1="6" y1="17" x2="6.01" y2="17"/>
              </svg>
            @elseif(($notification->icon ?? '') === 'alert')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M12 9v2m0 4v2m9-15a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
            @elseif(($notification->icon ?? '') === 'calendar')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/>
                <line x1="3" y1="10" x2="21" y2="10"/>
              </svg>
            @elseif(($notification->icon ?? '') === 'check')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <polyline points="20 6 9 17 4 12"/>
              </svg>
            @elseif(($notification->icon ?? '') === 'package')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <line x1="16.5" y1="9.4" x2="7.5" y2="4.21"/><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
              </svg>
            @elseif(($notification->icon ?? '') === 'user')
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
              </svg>
            @else
              <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
              </svg>
            @endif
          </div>

          {{-- Content --}}
          <div class="flex-1 min-w-0">
            <div class="flex items-start justify-between gap-3 mb-1">
              <div class="flex-1">
                <h3 class="text-sm font-semibold text-white group-hover:text-gold transition-colors">
                  {{ $notification->title ?? 'Notifikasi' }}
                </h3>
              </div>
              <span class="rounded-full px-2 py-1 text-[10px] {{ $toneBadge }} whitespace-nowrap flex-shrink-0">
                {{ optional($notification->created_at)->diffForHumans() ?? 'Baru' }}
              </span>
            </div>
            <p class="text-[12px] text-gray-300 leading-relaxed">
              {{ $notification->message ?? '' }}
            </p>
            <div class="mt-3 flex items-center justify-between gap-2 text-[11px] text-gray-400">
              <span class="rounded-full border border-white/10 px-2 py-1 {{ $notification->read_at ? 'bg-white/5 text-gray-300' : 'bg-gold/10 text-gold' }}">
                {{ $notification->read_at ? 'Read' : 'Unread' }}
              </span>
              @unless($notification->read_at)
                <form action="{{ route('notifications.read', $notification) }}" method="POST">
                  @csrf
                  <button type="submit" class="text-xs text-gold hover:text-gold/80">Mark as read</button>
                </form>
              @endunless
            </div>
          </div>
        </div>
      </article>
    @empty
      <div class="rounded-xl border border-white/10 bg-white/5 p-8 text-center">
        <div class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center mx-auto mb-3">
          <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
          </svg>
        </div>
        <p class="text-gray-400 text-sm">Tidak ada notifikasi saat ini</p>
      </div>
    @endforelse
  </div>

</div>
@endsection
