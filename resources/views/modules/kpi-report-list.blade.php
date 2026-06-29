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
    <div class="flex items-center justify-between mb-4">
      <div class="flex items-center gap-3">
        <form method="get" class="flex items-center gap-2">
          <label class="text-xs text-gray-300">From</label>
          <input type="date" name="from" value="{{ old('from', $from) }}" class="rounded px-2 py-1 bg-black/20 text-sm text-white" />
          <label class="text-xs text-gray-300">To</label>
          <input type="date" name="to" value="{{ old('to', $to) }}" class="rounded px-2 py-1 bg-black/20 text-sm text-white" />
          <button type="submit" class="sys-btn">Filter</button>
        </form>
      </div>
      <div class="text-sm text-gray-400">Showing {{ $reports->firstItem() ?? 0 }} - {{ $reports->lastItem() ?? 0 }} of {{ $reports->total() }}</div>
    </div>

    <div class="overflow-x-auto">
      <table class="min-w-full border-collapse text-xs text-gray-200">
        <thead>
          <tr class="text-gray-400 text-left">
            <th class="px-2 py-2">ID Report</th>
            <th class="px-2 py-2">User ID</th>
            <th class="px-2 py-2">Team ID</th>
            <th class="px-2 py-2">Report Date</th>
            <th class="px-2 py-2">Total New Data</th>
          </tr>
        </thead>
        <tbody>
          @forelse($reports as $r)
            <tr class="border-t border-white/6">
              <td class="px-2 py-3">{{ $r->id }}</td>
              <td class="px-2 py-3">{{ $r->user_id }}</td>
              <td class="px-2 py-3">{{ $r->team_id }}</td>
              <td class="px-2 py-3">{{ $r->report_date }}</td>
              <td class="px-2 py-3">{{ $r->total_new_data ?? '-' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="px-2 py-4 text-center text-gray-400">No reports found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">{{ $reports->links() }}</div>
  </section>
</div>
@endsection
