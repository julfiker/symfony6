<?php
namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;


/**
 * Class PaymentDto
 * @package App\Dto
 */
class PaymentDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('float')]
        public readonly float $amount,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $currency,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $cardNumber,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $cardExpYear,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $cardExpMonth,

        #[Assert\NotBlank]
        #[Assert\Type('string')]
        public readonly string $cardCvv
    ) {}
}