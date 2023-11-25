<?php

declare(strict_types=1);

namespace App\Services;

use App\Entity\Client;
use App\Manager\ClientManager;

class ClientService
{
    private ClientManager $clientManager;

    public function __construct(ClientManager $clientManager)
    {
        $this->clientManager = $clientManager;
    }

    public function getClientConfiguration(int $clientId): array
    {
        $configuration = [];

        if (Client::TYPE_INSTAGRAM === $clientId) {
            $client = $this->clientManager->findOneById(Client::TYPE_INSTAGRAM);

            if (null === $client) {
                return $configuration;
            }

            $configuration = [
                Client::ACCESS_4_NAME_INSTAGRAM => $client->getAccess4(),
                Client::ACCESS_5_NAME_INSTAGRAM => $client->getAccess5(),
            ];
        }

        return $configuration;
    }
}
