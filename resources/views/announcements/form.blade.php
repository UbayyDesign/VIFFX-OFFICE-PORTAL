<div class="space-y-6">
  <div class="grid gap-6 md:grid-cols-2">
    <div>
      <label class="block text-sm font-medium text-gray-300">Judul</label>
      <input type="text" name="title" value="{{ old('title', $announcement->title) }}" required class="mt-2 w-full rounded-2xl border border-white/10 bg-[#111] px-4 py-3 text-white outline-none focus:border-gold" />
      @error('title')<p class="mt-2 text-xs text-rose-300">{{ $message }}</p>@enderror
    </div>
    <div>
      <label class="block text-sm font-medium text-gray-300">Icon</label>
      <input type="text" name="icon" value="{{ old('icon', $announcement->icon) }}" placeholder="📢" class="mt-2 w-full rounded-2xl border border-white/10 bg-[#111] px-4 py-3 text-white outline-none focus:border-gold" />
      @error('icon')<p class="mt-2 text-xs text-rose-300">{{ $message }}</p>@enderror
    </div>
  </div>

  <div class="grid gap-6 md:grid-cols-2">
    <div>
      <label class="block text-sm font-medium text-gray-300">Background Icon</label>
      <input type="text" name="icon_bg" value="{{ old('icon_bg', $announcement->icon_bg ?? 'bg-yellow-500/15') }}" placeholder="bg-yellow-500/15" class="mt-2 w-full rounded-2xl border border-white/10 bg-[#111] px-4 py-3 text-white outline-none focus:border-gold" />
      @error('icon_bg')<p class="mt-2 text-xs text-rose-300">{{ $message }}</p>@enderror
    </div>
    <div class="flex items-end">
      <label class="inline-flex items-center gap-2 text-sm text-gray-300">
        <input type="hidden" name="is_new" value="0" />
        <input type="checkbox" name="is_new" value="1" {{ old('is_new', $announcement->is_new) ? 'checked' : '' }} class="h-4 w-4 rounded border-gray-600 text-gold focus:ring-gold" />
        <span>Mark as new</span>
      </label>
      @error('is_new')<p class="mt-2 text-xs text-rose-300">{{ $message }}</p>@enderror
    </div>
  </div>

  <div>
    <label class="block text-sm font-medium text-gray-300">Deskripsi</label>
    <textarea name="description" rows="8" required class="mt-2 w-full rounded-2xl border border-white/10 bg-[#111] px-4 py-3 text-white outline-none focus:border-gold">{{ old('description', $announcement->description) }}</textarea>
    @error('description')<p class="mt-2 text-xs text-rose-300">{{ $message }}</p>@enderror
  </div>

  <div class="flex flex-wrap gap-3">
    <button type="submit" class="sys-btn">Simpan Pengumuman</button>
    <a href="{{ route('announcements.index') }}" class="sys-btn bg-slate-700 hover:bg-slate-600">Kembali</a>
  </div>
</div>
