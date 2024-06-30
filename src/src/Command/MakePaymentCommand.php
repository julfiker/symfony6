<?php

namespace App\Command;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use App\Manager\AciManager;
use App\Manager\Shift4Manager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[AsCommand(
    name: 'app:make-payment',
    description: 'Add a short description for your command',
)]
class MakePaymentCommand extends Command
{

    private $aciManager;
    private $shift4Manager;
    private $response;

    public function __construct(AciManager $aciManager,Shift4Manager $shift4Manager)
    {
        $this->aciManager = $aciManager;
        $this->shift4Manager = $shift4Manager;
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption('m', null, InputOption::VALUE_REQUIRED, 'aci|shift4')
            ->addArgument('amount', InputArgument::REQUIRED, 'Amount')
            ->addArgument('currency', InputArgument::REQUIRED, 'Currency usd|euro')
            ->addArgument('cardNumber', InputArgument::REQUIRED, 'Card number')
            ->addArgument('cardExpYear', InputArgument::REQUIRED, 'Card Expire Year')
            ->addArgument('cardExpMonth', InputArgument::REQUIRED, 'Card Expire Year')
            ->addArgument('cardCvv', InputArgument::REQUIRED, 'Card cvv')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $amount = $input->getArgument('amount');
        $currency = $input->getArgument('currency');
        $cardNumber = $input->getArgument('cardNumber');
        $cardExpYear = $input->getArgument('cardExpYear');
        $cardExpMonth = $input->getArgument('cardExpMonth');
        $cardCvv = $input->getArgument('cardCvv');
        $paymentDto = new PaymentDto(
            (float)$amount,
            $currency,
            $cardNumber,
            $cardExpYear,
            $cardExpMonth,
            $cardCvv
        );

        if ($input->getOption('m') == 'aci') {
            $this->response = $this->aciManager->makePayment($paymentDto);
        }
        elseif ($input->getOption('m') == 'shift4') {
            $this->response = $this->shift4Manager->makePayment($paymentDto);
        }
        else {
            $io->error($this->response['Payment method not found, that must be input by option like --m=aci']);
        }

        if ($this->response instanceof TransactionDTO) {
            $io->success('Transaction was success with following response');
            $io->writeln(json_decode(json_encode($this->response), true));
        } else {
            $io->error($this->response['error']);
        }

        return Command::SUCCESS;
    }
}
