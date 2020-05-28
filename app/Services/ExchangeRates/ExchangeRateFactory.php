<?php

namespace App\Services\ExchangeRates;

use App\Contracts\Fetchable;

class ExchangeRateFactory
{
    private $providers = [
        'nbu' => 'App\Services\ExchangeRates\Providers\Nbu',
    ];

    /** @var Fetchable $fetcher */
    private $fetcher;

    /**
     * @param Fetchable $fetcher
     */
    public function __construct(Fetchable $fetcher)
    {
        $this->fetcher = $fetcher;
    }

    /**
     * @param String $providerCode
     */
    public function resolveProvider(String $providerCode)
    {
        if (isset($this->providers[$providerCode])) {
            return new $this->providers[$providerCode]($this->fetcher);
        }

        throw new \Exception("Exchange rate's provider ($providerCode) not found");
    }
}
