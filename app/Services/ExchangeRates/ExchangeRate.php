<?php

namespace App\Services\ExchangeRates;

use App\Utils\Fetcher;
use App\Models\ExchangeRate as Rate;
use App\Services\ExchangeRates\ExchangeRateFactory;

class ExchangeRate
{
    /**
     * @param String $providerCode
     * @param string $onDate
     */
    public function fetchAndSave(String $providerCode, string $onDate)
    {
        $bankProvider = (new ExchangeRateFactory(new Fetcher()))
            ->resolveProvider($providerCode);

        $preparedData = $bankProvider->prepareData(
            $bankProvider->fetch($onDate),
            $onDate
        );

        $bankProvider->save($preparedData);
    }

    /**
     * @param string $onDate
     *
     * @return array
     */
    public function getCurrentRates(string $onDate)
    {
        return Rate::select('curr_name', 'buy', 'sale')
            ->where('curr_date', $onDate)
            ->get()->toArray();
    }

    /**
     * @param array $period
     *
     * @return Collection
     */
    public function getHistory(array $period)
    {
        return Rate::select('curr_name', 'buy', 'sale', 'curr_date')
            ->whereBetween('curr_date', [$period['start'], $period['end']])
            ->orderBy('curr_date', 'desc')
            ->orderBy('curr_name')
            ->get();
    }
}
