<?php

namespace App\Controller\Api\V1\Payment;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use App\Manager\Shift4Manager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Contracts\Service\Attribute\SubscribedService;

#[Route("/api/v1/payments", "api_")]
class Shift4Controller extends AbstractController
{

    /** @var Shift4Manager */
    private $shift4Manager;

    public function __construct(Shift4Manager $shift4Manager)
    {
        $this->shift4Manager = $shift4Manager;
    }

    #[Route('/shift4', methods: ["POST"], name: 'app_api_v1_post_payment_shift4')]
    public function payment(#[MapRequestPayload] PaymentDto $paymentDto): JsonResponse
    {
        $response = $this->shift4Manager->makePayment($paymentDto);
        return $this->json($response);
    }

}
