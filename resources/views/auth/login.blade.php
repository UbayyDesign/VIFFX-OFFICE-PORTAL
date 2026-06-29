<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>VIFFX Portal — Login</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0d0d0d] min-h-screen flex items-center justify-center">

  <div class="w-full max-w-sm">
    {{-- Logo --}}
    <div class="text-center mb-8">
      <img src="{{ asset('images/logos/viffx-logo.png') }}" alt="VIFFX logo" class="mx-auto h-28 w-auto" />
    </div>

    {{-- Card --}}
    <div class="bg-[#161616] border border-white/[0.06] rounded-2xl p-8">
      <h2 class="text-lg font-semibold mb-1">Selamat Datang</h2>
      <p class="text-sm text-gray-400 mb-6">Masuk ke akun Anda untuk melanjutkan</p>

      @if ($errors->any())
        <div class="bg-red-500/10 border border-red-500/30 rounded-lg p-3 mb-4 text-sm text-red-400">
          {{ $errors->first() }}
        </div>
      @endif

      <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="mb-4">
          <label class="block text-xs text-gray-400 mb-1.5 font-medium">Email</label>
          <input type="email" name="email" value="{{ old('email') }}" required autofocus
            class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-lg px-3.5 py-2.5 text-sm text-white placeholder-gray-600 outline-none focus:border-gold/50 transition-colors"
            placeholder="email@vif.com">
        </div>

        <div class="mb-6" x-data="{ showPassword: false }">
          <label class="block text-xs text-gray-400 mb-1.5 font-medium">Password</label>
          <div class="relative">
            <input :type="showPassword ? 'text' : 'password'" name="password" required
              class="w-full bg-[#1a1a1a] border border-white/[0.08] rounded-lg px-3.5 py-2.5 pr-11 text-sm text-white placeholder-gray-600 outline-none focus:border-gold/50 transition-colors"
              placeholder="••••••••">
            <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white transition-colors" aria-label="Toggle password visibility" aria-pressed="showPassword">
              <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12s3.75-6.75 9.75-6.75S21.75 12 21.75 12s-3.75 6.75-9.75 6.75S2.25 12 2.25 12Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.8" stroke="currentColor" class="h-4 w-4" style="display: none;">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.58 10.58A3 3 0 0 0 13.42 13.42M6.88 6.88C4.1 8.6 2.25 12 2.25 12s3.75 6.75 9.75 6.75c1.53 0 2.97-.3 4.27-.83M9.9 4.1c.9-.27 1.86-.4 2.85-.4 6 0 9.75 6.75 9.75 6.75a18.03 18.03 0 0 1-3.47 4.1" />
              </svg>
            </button>
          </div>
        </div>

        <div class="flex items-center justify-between mb-6">
          <label class="flex items-center gap-2 text-xs text-gray-400 cursor-pointer">
            <input type="checkbox" name="remember" class="accent-gold">
            Remember me
          </label>
          @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-xs text-gold hover:text-gold-light">Lupa password?</a>
          @endif
        </div>

        <button type="submit"
          class="w-full bg-gold hover:bg-gold-light text-black font-semibold py-2.5 rounded-lg text-sm transition-colors">
          Masuk
        </button>
      </form>
    </div>

    <p class="text-center text-xs text-gray-600 mt-6">
      © 2026 VIFFX Group. All Rights Reserved.
    </p>
  </div>

</body>
</html>
