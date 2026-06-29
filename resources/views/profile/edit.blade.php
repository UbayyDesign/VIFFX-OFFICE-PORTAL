@extends('layouts.app')

@section('title', 'Profile Setting')

@section('content')
<div class="p-4 md:p-6 space-y-6">
    <div class="rounded-3xl border border-white/10 bg-[#151515] p-6 shadow-2xl shadow-black/20">
        <p class="text-xs uppercase tracking-[0.35em] text-gold/80">Profile</p>
        <h1 class="mt-2 text-2xl font-semibold text-white md:text-3xl">Profile Setting</h1>
        <p class="mt-3 max-w-2xl text-sm text-gray-300">Atur informasi akun, password, dan penghapusan akun dengan tampilan yang konsisten dengan dashboard.</p>
    </div>

    <div class="grid gap-6 xl:grid-cols-2">
        <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
            @include('profile.partials.update-profile-information-form')
        </section>

        <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
            @include('profile.partials.update-password-form')
        </section>
    </div>

    <div class="mt-6">
        <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
            @include('profile.partials.update-avatar-form')
        </section>
    </div>

    <section class="rounded-3xl border border-white/10 bg-[#151515] p-5 shadow-2xl shadow-black/20">
        @include('profile.partials.delete-user-form')
    </section>
</div>
@endsection
