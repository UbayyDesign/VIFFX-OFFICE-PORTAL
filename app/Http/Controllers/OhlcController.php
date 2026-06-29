<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class OhlcController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display OHLC data index page
     */
    public function index(): View
    {
        // OHLC data would be fetched from external API or database
        $ohlcData = [
            ['symbol' => 'AAPL', 'open' => 150.25, 'high' => 152.80, 'low' => 149.50, 'close' => 151.45, 'date' => '2026-06-23'],
            ['symbol' => 'GOOGL', 'open' => 140.10, 'high' => 142.55, 'low' => 139.75, 'close' => 141.30, 'date' => '2026-06-23'],
            ['symbol' => 'MSFT', 'open' => 380.45, 'high' => 385.20, 'low' => 379.80, 'close' => 383.65, 'date' => '2026-06-23'],
        ];

        return view('ohlc.index', [
            'page' => [
                'title' => 'OHLC Data',
                'eyebrow' => 'Market Data',
                'description' => 'Open, High, Low, Close harga aset trading dan pasar modal.',
                'status_label' => 'Live Market Data',
                'status_color' => 'bg-pink-400',
            ],
            'ohlcData' => $ohlcData,
        ]);
    }

    /**
     * Show OHLC details for a specific symbol
     */
    public function show(string $id): View
    {
        $ohlcDetail = [
            'symbol' => strtoupper($id),
            'name' => 'Example Company',
            'sector' => 'Technology',
            'open' => 150.25,
            'high' => 152.80,
            'low' => 149.50,
            'close' => 151.45,
            'volume' => 45320000,
            'marketCap' => '$2.5T',
            'date' => '2026-06-23',
        ];

        return view('ohlc.show', [
            'page' => [
                'title' => "OHLC - {$id}",
                'eyebrow' => 'Market Detail',
                'description' => "Analisis OHLC untuk {$id}",
                'status_label' => 'Detail View',
                'status_color' => 'bg-pink-400',
            ],
            'ohlcDetail' => $ohlcDetail,
        ]);
    }
}
