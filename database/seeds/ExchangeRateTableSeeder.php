<?php

use Illuminate\Database\Seeder;
use App\Services\ExchangeRates\ExchangeRate;

class ExchangeRateTableSeeder extends Seeder
{
    private $exchangeRate;
    /**
     * ExchangeRateTableSeeder constructor.
     */
    public function __construct()
    {
        $this->exchangeRate = new ExchangeRate();
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dates = [
            '2020-05-15',
            '2020-05-16',
            '2020-05-17',
            '2020-05-18',
            '2020-05-19',
            '2020-05-20',
            '2020-05-21',
            '2020-05-22',
            '2020-05-23',
            '2020-05-24',
            '2020-05-25',
            '2020-05-26',
            '2020-05-27',
        ];

        foreach ($dates as $date) {
            $this->exchangeRate->getRate('nbu', $date);
        }
    }
}
