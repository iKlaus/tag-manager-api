<?php

namespace App\Http\Client;

use App\Google\Client\Factory;
use Google\Service\TagManager;

class GoogleTagManagerClient
{
    public function __construct(private readonly Factory $factory)
    {
    }

    private function getClient(array $rawToken)
    {
        $client = $this->factory->createClient();
        $client->setAccessToken($rawToken);

        return new TagManager($client);
    }

    public function getAccounts(array $rawToken): array
    {
        $client = $this->getClient($rawToken);

        return $client->accounts->listAccounts()->getAccount();
    }
}
