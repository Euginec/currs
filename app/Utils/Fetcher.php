<?php

namespace App\Utils;

use App\Contracts\Fetchable;

class Fetcher implements Fetchable
{
    /**
     * Fetch data from third party service
     *
     * @param String $url
     *
     * @throw Exception
     *
     * @return array|false
     */
    public function fetch($url)
    {
        $curlVerify = curl_init();
        curl_setopt($curlVerify, CURLOPT_URL, $url);
        curl_setopt($curlVerify, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlVerify, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curlVerify, CURLOPT_SSL_VERIFYHOST, false);
        $contents = curl_exec($curlVerify);
        curl_close($curlVerify);

        $curlData = curl_init();
        curl_setopt($curlData, CURLOPT_URL, $url);
        curl_setopt($curlData, CURLOPT_RETURNTRANSFER, 1);
        $contents = curl_exec($curlData);
        curl_close($curlData);

        if ($contents === false) {
            throw new \Exception("CURL response has error. " . curl_error($curlData));
            return false;
        }

        $contents = json_decode($contents, true);

        if (is_null($contents)) {
            throw new \Exception("Data not received.");
            return false;
        }

        if (!is_array($contents)) {
            throw new \Exception("Data have an incorrect format. The format should be Array.");
            return false;
        }

        return $contents;
    }
}
