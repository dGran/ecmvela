<?php

declare(strict_types=1);

namespace App\Command\Client;

use App\Entity\Client;
use App\Manager\ClientManager;
use App\Services\ClientAccountDetailsService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:client:account-details',
    description: 'Check/update account details',
)]
class ClientAccountDetailsCommand extends Command
{
    private ClientManager $clientManager;

    private ClientAccountDetailsService $clientAccountDetailsService;


    public function __construct(ClientManager $clientManager, ClientAccountDetailsService $clientAccountDetailsService)
    {
        parent::__construct();

        $this->clientManager = $clientManager;
        $this->clientAccountDetailsService = $clientAccountDetailsService;
    }

    protected function configure(): void
    {
        $this
            ->addOption('clientId', null, InputOption::VALUE_OPTIONAL, 'Client ID')
            ->setHelp('This command checks the client account details')
        ;
    }

    /**
     * @throws \Exception
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $clientId = (int)$input->getOption('clientId');
        $clients = [$clientId] ? $this->clientManager->findBy(['id' => $clientId]) : $this->clientManager->findAll();

        $output->writeln(\date(\DATE_W3C).' - Started process');

        /** @var Client $client */
        foreach ($clients as $client) {
            $output->writeln(\date(\DATE_W3C).' - Started process for Client: '.$client->getName());
            $this->clientAccountDetailsService->process($client);
            $output->writeln(\date(\DATE_W3C).' - End process for Client: '.$client->getName());
        }

        $output->writeln(\date(\DATE_W3C).' - End process');

        return Command::SUCCESS;
    }
}
