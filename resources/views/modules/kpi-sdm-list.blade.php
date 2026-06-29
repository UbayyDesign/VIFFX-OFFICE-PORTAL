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
    </div>
  </div>

  <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between mb-4">
      <form method="get" class="grid gap-2 sm:grid-cols-[auto_auto_auto_auto_auto] items-end">
        <div>
          <label class="text-xs text-gray-400">From</label>
          <input type="date" name="from" value="{{ old('from', $from) }}" class="mt-1 w-full rounded border border-white/10 bg-black/20 px-3 py-2 text-sm text-white" />
        </div>
        <div>
          <label class="text-xs text-gray-400">To</label>
          <input type="date" name="to" value="{{ old('to', $to) }}" class="mt-1 w-full rounded border border-white/10 bg-black/20 px-3 py-2 text-sm text-white" />
        </div>
        <div>
          <label class="text-xs text-gray-400">Tipe</label>
          <select name="type" class="mt-1 w-full rounded border border-white/10 bg-black/20 px-3 py-2 text-sm text-white">
            <option value="">All</option>
            <option value="MGM" {{ $type === 'MGM' ? 'selected' : '' }}>MGM</option>
            <option value="RO" {{ $type === 'RO' ? 'selected' : '' }}>RO</option>
          </select>
        </div>
        <div class="flex items-end gap-2">
          <button type="submit" class="sys-btn">Filter</button>
          <a href="{{ route('kpi.sdm') }}" class="sys-btn bg-gray-700 hover:bg-gray-600">Reset</a>
        </div>
      </form>
      <div class="text-sm text-gray-400">Showing {{ $sdms->firstItem() ?? 0 }} - {{ $sdms->lastItem() ?? 0 }} of {{ $sdms->total() }}</div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full border-collapse text-xs text-gray-200">
        <thead>
          <tr class="text-gray-400 text-left">
            <th class="px-2 py-2">ID</th>
            <th class="px-2 py-2">Nama SDM</th>
            <th class="px-2 py-2">Tipe</th>
            <th class="px-2 py-2">Tanggal Masuk</th>
            <th class="px-2 py-2">User ID</th>
            <th class="px-2 py-2">Team ID</th>
            <th class="px-2 py-2">Created At</th>
          </tr>
        </thead>
        <tbody>
          @forelse($sdms as $sdm)
            <tr class="border-t border-white/6">
              <td class="px-2 py-3">{{ $sdm->id }}</td>
              <td class="px-2 py-3">{{ $sdm->nama }}</td>
              <td class="px-2 py-3">{{ $sdm->tipe }}</td>
              <td class="px-2 py-3">{{ $sdm->tanggal_masuk }}</td>
              <td class="px-2 py-3">{{ $sdm->user_id ?? '-' }}</td>
              <td class="px-2 py-3">{{ $sdm->team_id ?? '-' }}</td>
              <td class="px-2 py-3">{{ optional($sdm->created_at)->format('Y-m-d H:i:s') ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="px-2 py-4 text-center text-gray-400">No SDM records found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $sdms->links() }}</div>
  </section>
</div>
@endsection
