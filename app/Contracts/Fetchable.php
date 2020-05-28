<?php

namespace App\Contracts;

interface Fetchable
{
    /**
     * Fetch data from third party service
     *
     * @param String $url
     *
     * @return array|false
     */
    public function fetch(String $url);
}
