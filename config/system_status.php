<?php

return [
    // Modules to monitor and their health-check endpoints.
    // Order must follow the sidebar order requirement.
    'modules' => [
        ['key' => 'company_website', 'name' => 'Company Website', 'url' => 'https://viffx.com'],
        ['key' => 'vimport', 'name' => 'Vimport', 'url' => 'https://vimport.viffx.com'],
        ['key' => 'kpi_marketing', 'name' => 'KPI Marketing', 'url' => 'https://report.viffx.com'],
        ['key' => 'recruitment', 'name' => 'Recruitment', 'url' => 'https://ro.viffx.com'],
        ['key' => 'nextcloud', 'name' => 'Nextcloud', 'url' => env('NEXTCLOUD_HEALTH_URL', 'https://nextcloud.example/health')],
        ['key' => 'news', 'name' => 'News Analisa Trading', 'url' => env('NEWS_HEALTH_URL', 'https://viffx.com/news/health')],
        ['key' => 'ohlc', 'name' => 'OHLC', 'url' => env('OHLC_HEALTH_URL', 'https://viffx.com/ohlc/health')],
    ],

    // Timeout when pinging external services (seconds)
    'timeout' => 5,

    // Cache TTL (seconds) for health check results
    'cache_ttl' => 10,
];
