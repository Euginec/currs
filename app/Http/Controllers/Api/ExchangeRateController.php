<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\ExchangeRates\ExchangeRate;

class ExchangeRateController extends Controller
{
    /**
     * @param ExchangeRate $exchangeRate
     */
    public function getCurrentRate(ExchangeRate $exchangeRate)
    {
        $currentDate = \Carbon\Carbon::now()->format('Y-m-d');

        $rates = $exchangeRate->getCurrentRates($currentDate);

        if (empty($rates)) {
            $exchangeRate->fetchAndSave('nbu', $currentDate);
            $rates = $exchangeRate->getCurrentRates($currentDate);
        }

        return response()->json([
                'current_date' => $currentDate,
                'rates' => $rates
            ]);
    }

    /**
     * @param Request $request
     * @param ExchangeRate $exchangeRate
     */
    public function getHistory(Request $request, ExchangeRate $exchangeRate)
    {
        $period = $request->only(['start', 'end']);
        $history = $exchangeRate->getHistory($period);

        return response()->json([
            'rates' => $history
        ]);
    }
}
