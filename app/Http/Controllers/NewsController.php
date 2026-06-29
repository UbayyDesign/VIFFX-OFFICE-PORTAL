<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $cacheKey = 'news.rss_items';
        $items = Cache::get($cacheKey);
        $feedFailed = false;

        if (is_array($items) && count($items) === 0) {
            $items = null;
        }

        if ($items === null) {
            $fetchResult = $this->fetchRssItems($cacheKey);
            $items = $fetchResult['items'];
            $feedFailed = $fetchResult['failed'];
        }

        Log::info('NewsController index payload', [
            'feed_failed' => $feedFailed,
            'items_count' => is_countable($items) ? count($items) : 0,
            'first_item_title' => is_array($items) && count($items) > 0 ? $items[0]['title'] : null,
            'cache_key' => $cacheKey,
        ]);

        return view('modules.news', [
            'page' => [
                'title' => 'News',
                'eyebrow' => 'Berita & Analisa VIF',
                'description' => 'Berita pasar dan ringkasan analisa dari feed resmi VIFFX.',
                'status_label' => $feedFailed ? 'Terputus' : 'Terhubung',
                'status_color' => $feedFailed ? 'bg-red-500' : 'bg-emerald-400',
            ],
            'items' => $items,
            'feedFailed' => $feedFailed,
        ]);
    }

    private function fetchRssItems(string $cacheKey): array
    {
        $cachedItems = Cache::get($cacheKey);
        if (is_array($cachedItems) && count($cachedItems) === 0) {
            $cachedItems = null;
        }

        try {
            $response = Http::withOptions(['verify' => false])->timeout(10)->get('https://viffx.com/feed/');
            $body = $response->body();

            Log::info('News RSS fetch attempt start', [
                'status' => $response->status(),
                'successful' => $response->successful(),
                'body_len' => strlen($body),
                'cache_available' => is_array($cachedItems) ? 'yes' : 'no',
            ]);

            if (! $response->successful() || empty($body)) {
                Log::warning('News RSS fetch failed', [
                    'status' => $response->status(),
                    'successful' => $response->successful(),
                    'body_len' => strlen($body),
                ]);

                return [
                    'items' => $cachedItems ?? [],
                    'failed' => true,
                ];
            }

            libxml_use_internal_errors(true);
            $xml = simplexml_load_string($body, 'SimpleXMLElement', LIBXML_NOCDATA);
            $parseSuccess = (bool) $xml && isset($xml->channel->item);
            Log::info('News RSS XML parse result start', [
                'parse_success' => $parseSuccess,
                'item_nodes_present' => $parseSuccess ? 'yes' : 'no',
                'body_len' => strlen($body),
            ]);

            if (! $parseSuccess) {
                Log::warning('News RSS parse failed: invalid XML structure', [
                    'body_len' => strlen($body),
                ]);

                return [
                    'items' => $cachedItems ?? [],
                    'failed' => true,
                ];
            }

            $result = [];
            $allCategories = [];
            $rssItemCount = count($xml->channel->item);

            foreach ($xml->channel->item as $item) {
                $categories = [];
                if (isset($item->category)) {
                    foreach ($item->category as $category) {
                        $value = trim((string) $category);
                        if ($value !== '') {
                            $categories[] = $value;
                            $allCategories[] = $value;
                        }
                    }
                }

                $filteredCategories = collect($categories)
                    ->filter(fn ($value) => $this->categoryMatches($value))
                    ->unique()
                    ->values()
                    ->all();

                if (empty($filteredCategories)) {
                    continue;
                }

                $summary = trim((string) $item->description ?: $item->{'content:encoded'} ?: '');
                $summary = strip_tags($summary);
                $summary = preg_replace('/\s+/', ' ', $summary);
                Log::info('Str::limit start', [
                    'summary_length' => strlen($summary),
                    'item_title' => trim((string) $item->title),
                ]);
                try {
                    $summary = Str::limit($summary, 220, '...');
                    Log::info('Str::limit success', [
                        'summary_after_length' => strlen($summary),
                        'item_title' => trim((string) $item->title),
                    ]);
                } catch (\Throwable $e) {
                    Log::error('Str::limit exception', [
                        'exception_class' => get_class($e),
                        'message' => $e->getMessage(),
                        'file' => $e->getFile(),
                        'line' => $e->getLine(),
                        'item_title' => trim((string) $item->title),
                    ]);
                    throw $e;
                }

                try {
                    $publishedAt = Carbon::parse((string) $item->pubDate);
                } catch (\Throwable $e) {
                    $publishedAt = Carbon::now();
                }

                $result[] = [
                    'title' => trim((string) $item->title) ?: 'Tanpa judul',
                    'link' => trim((string) $item->link) ?: '#',
                    'summary' => $summary ?: 'Ringkasan tidak tersedia.',
                    'categories' => $filteredCategories,
                    'published_at' => $publishedAt->translatedFormat('d M Y H:i'),
                ];

                if (count($result) >= 12) {
                    break;
                }
            }

            $filteredItemCount = count($result);
            $distinctCategories = array_values(array_unique($allCategories));

            Log::info('News RSS filter complete', [
                'rss_item_count' => $rssItemCount,
                'filtered_item_count' => $filteredItemCount,
                'distinct_categories' => $distinctCategories,
            ]);

            if ($filteredItemCount > 0) {
                Cache::put($cacheKey, $result, 900);
            } else {
                Log::warning('News RSS parsed successfully but no matching Berita / Analisa items found', [
                    'rss_item_count' => $rssItemCount,
                    'distinct_categories' => $distinctCategories,
                ]);
            }

            Log::info('News RSS final result', [
                'rss_item_count' => $rssItemCount,
                'filtered_item_count' => $filteredItemCount,
                'return_item_count' => count($result),
                'cache_key' => $cacheKey,
            ]);

            return [
                'items' => $result,
                'failed' => false,
            ];
        } catch (\Throwable $e) {
            Log::error('News RSS fetch error', ['message' => $e->getMessage()]);

            return [
                'items' => $cachedItems ?? [],
                'failed' => true,
            ];
        }
    }

    private function categoryMatches(string $category): bool
    {
        $normalized = preg_replace('/[^a-z0-9]+/', ' ', strtolower($category));
        $tokens = preg_split('/\s+/', trim($normalized), -1, PREG_SPLIT_NO_EMPTY);

        return in_array('berita', $tokens, true) || in_array('analisa', $tokens, true);
    }
}
