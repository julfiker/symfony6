<?php
namespace App\Manager;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class Shift4Manager implements MakePaymentInterface
{
    /** @var Client  */
    private $client;

    /** @var TransactionDTO  */
    private $transaction;

    /**
     * Configuration with const with api base url and auth token
     */
    const API_BASE_URI = 'https://api.shift4.com';
    const AUTH_TOKEN = 'pr_test_tXHm9qV9qV9bjIRHcQr9PLPa';

    /**
     * Shift4Manager constructor.
     * @param TransactionDTO $transaction
     */
    public function __construct(TransactionDTO $transaction)
    {
        $this->client = new Client([
            'base_uri' => self::API_BASE_URI,
            'auth' => [self::AUTH_TOKEN, '']
        ]);
        $this->transaction = $transaction;
    }

    /**
     * Api request to make a charge entry or payment entry
     *
     * @param PaymentDto $paymentDto
     * @return array
     */
    public function makePayment(PaymentDto $paymentDto)
    {
        try {
            $response = $this->client->post('/charges', [
                "form_params" => [
                    'amount' => $paymentDto->amount,
                    'currency' => $paymentDto->currency,
                    'customerId' => "cust_AoR0wvgntQWRUYMdZNLYMz5R",
                    'card' => $paymentDto->cardNumber,
                    'description' => "Example Charge"
                ]
            ]);
            $result = json_decode($response->getBody()->getContents());
            return $this->transaction
                    ->setTransactionId($result->id)
                    ->setCreatedAt($result->created)
                    ->setCurrency($result->currency)
                    ->setAmount($result->amount)
                    ->setCardBin($result->card);

        } catch (RequestException $e) {
            return [
                'error' => $e->getMessage(),
                'response' => json_decode($e->getResponse()->getBody()->getContents())
            ];
        }
    }
}
