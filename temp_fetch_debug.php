<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;

function categoryMatches(string $category): bool
{
    $normalized = preg_replace('/[&\-_]+/', ' ', strtolower($category));
    $tokens = preg_split('/\s+/', trim($normalized));
    return in_array('berita', $tokens, true) || in_array('analisa', $tokens, true);
}

$response = Http::withOptions(['verify' => false])->timeout(10)->get('https://viffx.com/feed/');
echo "status=" . $response->status() . "\n";
echo "successful=" . ($response->successful() ? 'yes' : 'no') . "\n";
echo "body_len=" . strlen($response->body()) . "\n";

libxml_use_internal_errors(true);
$xml = @simplexml_load_string($response->body(), 'SimpleXMLElement', LIBXML_NOCDATA);
echo "xml_ok=" . ($xml ? 'yes' : 'no') . "\n";
if (! $xml || ! isset($xml->channel->item)) {
    echo "no items or parse issue\n";
    exit(0);
}

echo "rss_item_count=" . count($xml->channel->item) . "\n";
$result=[];
foreach ($xml->channel->item as $idx => $item) {
    $categories = [];
    foreach ($item->category as $category) {
        $value = trim((string) $category);
        if ($value !== '') {
            $categories[] = $value;
        }
    }
    echo "item" . ($idx+1) . " categories=" . implode('|', $categories) . "\n";
    $filteredCategories = collect($categories)
        ->filter(fn ($value) => categoryMatches($value))
        ->unique()
        ->values()
        ->all();
    echo "item" . ($idx+1) . " filtered=" . implode('|', $filteredCategories) . "\n";
    if (! empty($filteredCategories)) {
        $summary = trim((string) $item->description ?: $item->{'content:encoded'} ?: '');
        $summary = strip_tags($summary);
        $summary = preg_replace('/\s+/', ' ', $summary);
        $summary = Str::limit($summary, 220, '...');
        try {
            $publishedAt = Carbon::parse((string) $item->pubDate);
        } catch (\Throwable $e) {
            $publishedAt = Carbon::now();
        }
        $result[] = ['title' => trim((string)$item->title), 'categories' => $filteredCategories];
    }
    if (count($result) >= 12) break;
}
echo "result_count=" . count($result) . "\n";
if (count($result) > 0) {
    echo "first=" . $result[0]['title'] . " categories=" . implode('|', $result[0]['categories']) . "\n";
}
