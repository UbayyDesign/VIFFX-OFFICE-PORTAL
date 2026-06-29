<?php

namespace App\Models;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ModuleStatus
{
    public static function statuses(): array
    {
        $modules = config('system_status.modules', []);
        $timeout = config('system_status.timeout', 5);
        $cacheTtl = config('system_status.cache_ttl', 10);

        return Cache::remember('system_statuses', $cacheTtl, function () use ($modules, $timeout) {
            $results = [];

            foreach ($modules as $mod) {
                $name = $mod['name'] ?? ($mod['key'] ?? 'Unknown');
                $url = $mod['url'] ?? null;

                $status = 'Offline';
                $detail = 'No endpoint configured';

                if ($url) {
                    try {
                        $start = microtime(true);
                        $response = Http::withOptions(['verify' => false])->timeout($timeout)->get($url);
                        $duration = round((microtime(true) - $start) * 1000);

                        if ($response->successful()) {
                            $status = 'Online';
                            $detail = "HTTP {$response->status()} • {$duration} ms";
                        } elseif ($response->serverError()) {
                            $status = 'Warning';
                            $detail = "HTTP {$response->status()} • {$duration} ms";
                        } else {
                            $status = 'Offline';
                            $detail = "HTTP {$response->status()} • {$duration} ms";
                        }
                    } catch (\Throwable $e) {
                        $status = 'Offline';
                        $detail = $e->getMessage();
                        Log::warning('ModuleStatus check failed for '.$name.': '.$e->getMessage());
                    }
                }

                $results[] = [
                    'key' => $mod['key'] ?? null,
                    'name' => $name,
                    'status' => $status,
                    'detail' => $detail,
                ];
            }

            return $results;
        });
    }
}
