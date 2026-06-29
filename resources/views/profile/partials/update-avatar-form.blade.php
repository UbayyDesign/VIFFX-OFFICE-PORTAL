<section>
    <header>
        <h2 class="text-lg font-medium text-white">Avatar</h2>
        <p class="mt-1 text-sm text-gray-300">Upload atau hapus foto profil Anda. Gambar akan disimpan secara publik di storage.</p>
    </header>

    <div class="mt-4">
        <div class="flex items-center gap-4">
            <div class="w-20 h-20 rounded-full bg-gray-700 overflow-hidden flex items-center justify-center">
                @if($user->avatar)
                    <img src="{{ asset('storage/'.$user->avatar) }}" alt="Avatar" class="w-full h-full object-cover">
                @else
                    <span class="text-white font-bold">{{ strtoupper(substr($user->name,0,2)) }}</span>
                @endif
            </div>

            <form method="post" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex items-center gap-2">
                @csrf
                @method('patch')
                <input type="file" name="avatar" accept="image/*" class="text-sm text-gray-200" />
                <x-primary-button>{{ __('Upload') }}</x-primary-button>
            </form>

            @if($user->avatar)
                <form method="post" action="{{ route('profile.avatar.destroy') }}">
                    @csrf
                    @method('delete')
                    <button type="submit" class="text-sm text-rose-400 hover:underline">Hapus</button>
                </form>
            @endif
        </div>
        <x-input-error class="mt-2" :messages="$errors->get('avatar')" />
    </div>
</section>
