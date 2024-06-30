<?php

namespace App\Manager;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

class AciManager implements MakePaymentInterface
{
    private $client;
    private $url;
    private $entityId;
    private $authorization;

    /** @var TransactionDTO  */
    private $transaction;

    public function __construct(TransactionDTO $transactionDTO)
    {
        $this->transaction = $transactionDTO;
        $this->client = new Client();
        $this->url = 'https://eu-test.oppwa.com/v1/payments';
        $this->entityId = '8a8294174b7ecb28014b9699220015ca';
        $this->authorization = 'OGE4Mjk0MTc0YjdlY2IyODAxNGI5Njk5MjIwMDE1Y2N8c3k2S0pzVDg=';
    }

    public function makePayment(PaymentDto $paymentDto)
    {
        $data = [
            'entityId' => $this->entityId,
            'amount' => $paymentDto->amount,
            'currency' => $paymentDto->currency,
            'paymentBrand' => "VISA",
            'paymentType' => "PA",
            'card.number' => $paymentDto->cardNumber,
            'card.holder' => 'Jane Jones',
            'card.expiryMonth' => $paymentDto->cardExpMonth,
            'card.expiryYear' => $paymentDto->cardExpYear,
            'card.cvv' => $paymentDto->cardCvv
        ];

        try {
            $response = $this->client->post($this->url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->authorization,
                ],
                'form_params' => $data
            ]);
            $result = json_decode($response->getBody()->getContents());
            return $this->transaction
                ->setTransactionId($result->id)
                ->setCreatedAt($result->timestamp)
                ->setCurrency($result->currency)
                ->setAmount($result->amount)
                ->setCardBin($result->card);
        } catch (GuzzleException $e) {
            return [
                'error' => $e->getMessage(),
                'response' => json_decode($e->getResponse()->getBody()->getContents())
            ];
        }
    }
}
