<?php

namespace App\Command;

use App\Dto\PaymentDto;
use App\Dto\TransactionDTO;
use App\Manager\AciManager;
use App\Manager\MakePaymentInterface;
use App\Manager\Shift4Manager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

#[AsCommand(
    name: 'app:make-payment',
    description: 'Its about to make payment with one option and comma separated value in arguments',
)]
class MakePaymentCommand extends Command
{

    /** @var AciManager  */
    private $aciManager;

    /** @var Shift4Manager  */
    private $shift4Manager;

    /** @var  */
    private $response;

    private $serializer;

    public function __construct(MakePaymentInterface $aciManager,
                                Shift4Manager $shift4Manager,
                                SerializerInterface $serializer)
    {
        $this->aciManager = $aciManager;
        $this->shift4Manager = $shift4Manager;
        $this->serializer = $serializer;
        parent::__construct();
    }

    /**
     * Added individual argument to make a transaction
     * todo:Use one argument with is_array.
     */
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

        $io->info('Executing with '.$input->getOption('m'));

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
            $io->writeln($this->serializer->serialize($this->response, 'json'));
        } else {
            $io->error($this->response['error']);
        }

        return Command::SUCCESS;
    }
}
