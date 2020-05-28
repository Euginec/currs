<?php

namespace App\Services\ExchangeRates\Providers;

use App\Contracts\Fetchable;
use App\Models\ExchangeRate;
use Illuminate\Support\Facades\DB;

class Nbu
{
    protected $apiUrl = "https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?date=<CURR_DATE>&json";
    private $sourceName = 'nbu';

    /** @var App\Contracts\Fetchable */
    private $fetcher;

    /**
     * @param Fetchable $fetcher
     */
    public function __construct(Fetchable $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * Fetch data from service
     *
     * @param string $onDate
     *
     * @return json
     */
    public function fetch(string $onDate)
    {
        $onDate = str_replace('-', '', $onDate);
        $this->apiUrl = str_replace('<CURR_DATE>', $onDate, $this->apiUrl);
        return $this->fetcher->fetch($this->apiUrl);
    }

    /**
     * @param Array $data
     * @param String $onDate
     *
     * @return array
     */
    public function prepareData(Array $data, String $onDate = null) : Array
    {
        $result = [];

        foreach ($data as $d) {
            if (!in_array($d['cc'], config('rates.rate_types'))) continue;

            $result[] = [
                'curr_name' => $d['cc'],
                'base_curr_name' => 'UAH',
                'buy' => $d['rate'],
                'sale' => $d['rate'],
                'provider' => $this->sourceName,
                'curr_date' => $onDate === null ? \Carbon\Carbon::now()->format('Y-m-d') : $onDate,
            ];
        }

        return $result;
    }

    /**
     * @param Array $data
     *
     * @return boolean
     */
    public function save(Array $data)
    {
        try {
            DB::beginTransaction();
            foreach ($data as $d) {
                ExchangeRate::updateOrCreate(
                    ['curr_date' => $d['curr_date'], 'curr_name' => $d['curr_name']],
                    $d
                );
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }

        return true;
    }
}
