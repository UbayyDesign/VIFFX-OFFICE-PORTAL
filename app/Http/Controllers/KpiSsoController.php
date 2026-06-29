<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class KpiSsoController extends Controller
{
    public function login(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $kpiUser = DB::connection('kpi')
            ->table('users')
            ->where('email', $user->email)
            ->first();

        if (! $kpiUser) {
            abort(403, 'Akun KPI untuk email Anda tidak ditemukan. Pastikan email portal dan KPI sama.');
        }

        $email = $user->email;
        $timestamp = now()->timestamp;
        $payload = json_encode([
            'email' => $email,
            'timestamp' => $timestamp,
        ]);

        $signature = hash_hmac('sha256', $payload, config('kpi.secret'));

        $redirectUrl = config('kpi.url') . '?' . http_build_query([
            'email' => $email,
            'timestamp' => $timestamp,
            'signature' => $signature,
        ]);

        return redirect()->away($redirectUrl);
    }
}
