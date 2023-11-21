<?php

declare(strict_types=1);

namespace App\Services;

use App\Client\Instagram\System\Service\SystemService as InstagramSystemService;
use App\Entity\Client;
use App\Manager\ClientManager;

class ClientAccountDetailsService
{
    private ClientManager $clientManager;

    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    /**
     * @throws \Exception
     */
    public function process(Client $client): void
    {
        if ($client->getId() === Client::TYPE_INSTAGRAM) {
            $this->processInstagramClient($client);
        }
    }

    /**
     * @throws \Exception
     */
    private function processInstagramClient(Client $client): void
    {
        $configuration = [
            Client::ACCESS_4_NAME_INSTAGRAM => $client->getAccess4(),
            Client::ACCESS_5_NAME_INSTAGRAM => $client->getAccess5(),
        ];
        $systemService = new InstagramSystemService($configuration);
        $accountInfo = $systemService->getAccountDetails();

        if ($accountInfo->token !== null) {
            $client->setAccess4($accountInfo->token->token);
            $client->setAccess5($accountInfo->token->dateExpirationToken->format('Y-m-d H:i:s'));
            $client->setDateExpiration($accountInfo->token->dateExpirationToken);
        }

        $client->setValid($accountInfo->valid);
        $this->clientManager->save($client);
    }
}