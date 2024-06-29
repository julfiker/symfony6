<?php

namespace App\Controller\Api\V1\Payment;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use App\Manager\AciManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route("/api/v1/payments", "api_")]
class AciController extends AbstractController
{

    /** @var AciManager */
    private $aciManager;

    public function __construct(AciManager $aciManager)
    {
        $this->aciManager = $aciManager;
    }

    #[Route('/aci', methods: ["POST"], name: 'app_api_v1_post_payment_aci')]
    public function payment(#[MapRequestPayload] PaymentDto $paymentDto): JsonResponse
    {
        $response = $this->aciManager->makePayment($paymentDto);
        return $this->json($response);
    }
}
