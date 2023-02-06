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
        return "https://api.apilayer.com/fixer";
    }

    /**
     * @return string[]
     */
    protected function getCredentials(): array
    {
        return [
            'apiKey' => '5pMoXBjT0ksmAjy57WD9ja1ynqKNTIqR',
        ];
    }

    /**
     * @return array
     */
    protected function headers(): array
    {
        return [
            'content-type' => 'application/json',
            'apiKey' => $this->getCredentials()['apiKey'],
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

        $url = sprintf("%s%s", $this->baseUrl(),
            self::CONVERT_CURRENCY);
        return $this->get($url, [
            'from' => $currencyFrom,
            'to' => $currencyTo,
            'amount' => $currencyValue
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
    protected function get(string $url, array $payload = []): array
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
