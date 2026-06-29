@extends('layouts.app')

@section('title', $page['title'])

@section('content')
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

  @if(($page['title'] ?? '') === 'Calendar')
  <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
    <div class="grid gap-4 md:grid-cols-[1fr_0.9fr]">
      <article class="rounded-2xl border border-white/8 bg-black/20 p-4">
        <div class="text-xs uppercase tracking-[0.25em] text-gold/80">{{ $page['live_label'] ?? 'Live clock' }}</div>
        <div id="liveClock" class="mt-3 text-3xl font-semibold text-white md:text-4xl">--:--:--</div>
        <p class="mt-2 text-sm text-gray-300">Jam server real-time dan tanggal aktif mengikuti browser Anda.</p>
      </article>
      <article class="rounded-2xl border border-white/8 bg-black/20 p-4">
        <div class="text-xs uppercase tracking-[0.25em] text-gold/80">Agenda berikutnya</div>
        <div class="mt-3 text-lg font-semibold text-white">Weekly Sync</div>
        <p class="mt-1 text-sm text-gray-300">Meeting internal berikutnya dimulai pada pukul 09.00 WIB.</p>
        <div class="mt-4 rounded-xl border border-emerald-400/20 bg-emerald-400/10 p-3 text-sm text-emerald-100">Status: Live update aktif • data dapat diperbarui oleh sistem.</div>
      </article>
    </div>

    <article class="mt-4 rounded-2xl border border-white/8 bg-black/20 p-4">
      <div class="flex flex-wrap items-end justify-between gap-3">
        <div>
          <div class="text-xs uppercase tracking-[0.25em] text-gold/80">Kalender real-time</div>
          <h2 id="calendarMonthLabel" class="mt-1 text-xl font-semibold text-white">Bulan</h2>
        </div>
        <div class="text-xs text-gray-300">Hari ini: <span id="calendarTodayLabel" class="font-semibold text-gold">Tanggal</span></div>
      </div>
      <div class="mt-4 overflow-x-auto">
        <table class="min-w-full border-collapse text-xs text-gray-200">
          <thead>
            <tr class="text-gray-400">
              <th class="px-2 py-2">Min</th>
              <th class="px-2 py-2">Sen</th>
              <th class="px-2 py-2">Sel</th>
              <th class="px-2 py-2">Rab</th>
              <th class="px-2 py-2">Kam</th>
              <th class="px-2 py-2">Jum</th>
              <th class="px-2 py-2">Sab</th>
            </tr>
          </thead>
          <tbody id="calendarGrid" class="text-center"></tbody>
        </table>
      </div>
    </article>
  </section>
  @endif

  <div class="grid gap-6 xl:grid-cols-[1.1fr_0.9fr]">
    <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
      <div class="mb-4 flex items-center justify-between">
        <div>
          <h2 class="text-lg font-semibold text-white">Ringkasan Modul</h2>
          <p class="text-xs text-gray-400">Rangkuman status modul dan fitur yang tersedia untuk halaman ini.</p>
        </div>
        <span class="rounded-full border border-emerald-400/30 bg-emerald-400/10 px-3 py-1 text-[11px] font-semibold text-emerald-300">Preview</span>
      </div>
      <div class="grid gap-4 md:grid-cols-2">
        @foreach($cards as $card)
          <article class="rounded-2xl border border-white/8 bg-black/20 p-4">
            <div class="text-xs uppercase tracking-[0.25em] text-gray-400">{{ $card['label'] }}</div>
            <div class="mt-2 text-2xl font-semibold text-white">{{ $card['value'] }}</div>
            <p class="mt-2 text-sm text-gray-300">{{ $card['detail'] }}</p>
          </article>
        @endforeach
      </div>
    </section>

    <aside class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
      <h2 class="text-lg font-semibold text-white">Aktivitas Terkini</h2>
      <div class="mt-4 space-y-3">
        @foreach($items as $item)
          @php
            $title = $item['title'] ?? $item['name'] ?? 'Item';
            $meta = $item['meta'] ?? $item['detail'] ?? 'Detail';
            $badge = $item['badge'] ?? $item['status'] ?? 'Ready';
            $description = $item['description'] ?? $item['detail'] ?? 'Tidak ada deskripsi.';
            $badgeClass = $item['badge_class'] ?? match (strtolower((string) $badge)) {
              'error' => 'bg-rose-400/10 text-rose-300',
              'online' => 'bg-emerald-400/10 text-emerald-300',
              default => 'bg-amber-400/10 text-amber-300',
            };
          @endphp
          <article class="rounded-2xl border border-white/8 bg-black/20 p-4">
            <div class="flex items-center justify-between gap-3">
              <div>
                <h3 class="text-sm font-semibold text-white">{{ $title }}</h3>
                <p class="text-xs text-gray-400">{{ $meta }}</p>
              </div>
              <span class="rounded-full px-2.5 py-1 text-[10px] font-semibold {{ $badgeClass }}">{{ $badge }}</span>
            </div>
            <p class="mt-2 text-sm text-gray-300">{{ $description }}</p>
          </article>
        @endforeach
      </div>
    </aside>
  </div>
</div>

@if(($page['title'] ?? '') === 'Calendar')
<script>
  (function () {
    const clock = document.getElementById('liveClock');
    const monthLabel = document.getElementById('calendarMonthLabel');
    const todayLabel = document.getElementById('calendarTodayLabel');
    const grid = document.getElementById('calendarGrid');

    function renderCalendar() {
      const now = new Date();
      const year = now.getFullYear();
      const month = now.getMonth();
      const firstDay = new Date(year, month, 1);
      const lastDay = new Date(year, month + 1, 0);
      const daysInMonth = lastDay.getDate();
      const startDay = firstDay.getDay();
      const today = now.getDate();

      monthLabel.textContent = now.toLocaleDateString('id-ID', { month: 'long', year: 'numeric' });
      todayLabel.textContent = now.toLocaleDateString('id-ID', { weekday: 'long', day: 'numeric', month: 'long', year: 'numeric' });

      let html = '';
      let day = 1;
      for (let week = 0; week < 6; week++) {
        html += '<tr>';
        for (let i = 0; i < 7; i++) {
          if ((week === 0 && i < startDay) || day > daysInMonth) {
            html += '<td class="px-2 py-2 text-gray-600">&nbsp;</td>';
          } else {
            const isToday = day === today;
            html += `<td class="px-2 py-2 ${isToday ? 'rounded-xl bg-gold text-black font-semibold' : 'text-gray-200'}">${day}</td>`;
            day++;
          }
        }
        html += '</tr>';
        if (day > daysInMonth) break;
      }
      grid.innerHTML = html;

      if (clock) {
        clock.textContent = now.toLocaleTimeString('id-ID', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
      }
    }

    renderCalendar();
    setInterval(renderCalendar, 1000);
  })();
</script>
@endif
@endsection
