<?php

namespace App\Controller\Api\V1\Payment;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use App\Manager\AciManager;
use App\Manager\MakePaymentInterface;
use http\Env\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\WithHttpStatus;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[Route("/api/v1/payments", "api_")]
class AciController extends AbstractController
{

    /** @var AciManager */
    private $aciManager;

    /**
     * AciController constructor.
     * @param MakePaymentInterface $aciManager
     */
    public function __construct(MakePaymentInterface $aciManager)
    {
        $this->aciManager = $aciManager;
    }

    #[Route('/aci', methods: ["POST"], name: 'app_api_v1_post_payment_aci')]
    public function payment(#[MapRequestPayload] PaymentDto $paymentDto): JsonResponse
    {
        $response = $this->aciManager->makePayment($paymentDto);
        if ($response instanceof TransactionDTO) {
            return $this->json($response,201);   //@fixme with enum constant
        }
        return $this->json($response,400);
    }
}
