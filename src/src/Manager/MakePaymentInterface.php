<?php


namespace App\Manager;


use App\Dto\PaymentDto;

interface MakePaymentInterface
{
    /**
     * @param PaymentDto $paymentDto
     * @return mixed
     */
    public function makePayment(PaymentDto $paymentDto);

}