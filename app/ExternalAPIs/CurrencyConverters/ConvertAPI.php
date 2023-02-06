<?php

namespace App\ExternalAPIs\CurrencyConverters;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ConvertAPI
{
    private const CONVERT_CURRENCY = '/convert';

    /**
     * @return string
     */
    protected function baseUrl(): string
    {
        return "https://community-neutrino-currency-conversion.p.rapidapi.com";
    }

    /**
     * @return string[]
     */
    protected function getCredentials(): array
    {
        return [
            'apiKey' => '300d93db91mshc298994e5ee8ccap1df2b5jsne40e281ebb22',
            'host' => 'community-neutrino-currency-conversion.p.rapidapi.com'
        ];
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'content-type' => 'application/json',
            'X-RapidAPI-Key' => $this->getCredentials()['apiKey'],
            'X-RapidAPI-Host' => $this->getCredentials()['host']
        ];
    }

    /**
     * @param $currencyValue
     * @param $currencyFrom
     * @param $currencyTo
     * @return array
     */
    public function convertCurrency($currencyValue, $currencyFrom, $currencyTo): array
    {

        $apiKey = $this->getCredentials()['apiKey'];
        $url = sprintf("%s%s?=%s", $this->baseUrl(), self::CONVERT_CURRENCY, $apiKey);
        return $this->post($url, [
            'from-value' => $currencyValue,
            'from-type' => $currencyFrom,
            'to-type' => $currencyTo
        ]);


    }

    /**
     * @param string $url
     * @param array $payload
     * @return array
     */
    protected function post(string $url, array $payload): array
    {
        $res = Http::withHeaders($this->headers())->post($url, $payload);
        return $this->response($res);
    }

    /**
     * @param string $url
     * @param array $payload
     * @return array
     */
    protected function get(string $url, array $payload): array
    {
        $res = Http::withHeaders($this->headers())->get($url, $payload);
        return $this->response($res);
    }

    protected function response(Response $response)
    {
        
        return $response->ok() && $response->json()
            ? $response->json()
            : [];
    }


}
