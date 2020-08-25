<?php


namespace App\Services;


use App\Currency;
use GuzzleHttp\Client;

class CurrenciesService
{

    private $curl;

    public function __construct(Client $curl) {
        $this->curl = $curl;
    }

    protected function loadRates() {

        $response = $this->curl->get('http://www.cbr.ru/scripts/XML_daily.asp');

        if ($response->getStatusCode() == 200) {
            if ($data = simplexml_load_string($response->getBody())) {
                if (!empty($data->Valute)) {
                    $result = [];
                    foreach($data->Valute as $item) {
                        $result[(string)$item['ID']] = [
                            'NumCode' => (string)$item->NumCode,
                            'CharCode' => (string)$item->CharCode,
                            'Nominal' => (string)$item->Nominal,
                            'Name' => (string)$item->Name,
                            'Value' => (string)$item->Value,
                        ];
                    }
                    return $result;
                }
            }
        }
        throw new \Exception('CBR api error');
    }

    protected function loadCurrenciesNames() {
        $response = $this->curl->get('http://www.cbr.ru/scripts/XML_val.asp');
        if ($response->getStatusCode() == 200) {
            if ($data = simplexml_load_string($response->getBody())) {
                if (!empty($data->Item)) {
                    $result = [];
                    foreach($data->Item as $item) {
                        $result[(string)$item['ID']] = [
                            'ru' => (string)$item->Name,
                            'en' => (string)$item->EngName,
                        ];
                    }
                    return $result;
                }
            }
        }
        throw new \Exception('CBR api error');
    }

    public function updateRates() {
        $names = $this->loadCurrenciesNames();
        $rates = $this->loadRates();

        app('db')->beginTransaction();
        foreach ($rates as $currency_id => $rate) {

            $currency = Currency::firstOrNew(['alphabetic_code' => $rate['CharCode']]);

            $currency->name = $rate['Name'];
            $currency->english_name = $names[$currency_id]['en'] ?? $rate['Name'];
            $currency->alphabetic_code = $rate['CharCode'];
            $currency->digit_code = $rate['NumCode'];
            $currency->rate = str_replace(',', '.', $rate['Value']) / $rate['Nominal'];

            $currency->save();

        }
        app('db')->commit();
    }

}
