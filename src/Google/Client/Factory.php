<?php

namespace App\Google\Client;

use Google\Client;

class Factory
{
    private const GOOGLE_AUTH_URI = 'https://accounts.google.com/o/oauth2/auth';
    private const GOOGLE_TOKEN_URI = 'https://oauth2.googleapis.com/token';
    private const GOOGLE_CERT_URL = 'https://www.googleapis.com/oauth2/v1/certs';

    public function __construct(
        private readonly string $applicationName,
        private readonly array $scopes,
        private readonly string $clientId,
        private readonly string $clientSecret,
        private readonly string $projectId,
        private readonly string $redirectUrl
    )
    {
    }

    public function createClient(): Client
    {
        $client = new Client();
        $client->setApplicationName($this->applicationName);
        $client->setScopes($this->scopes);
        $client->setAuthConfig([
            'web' => [
                'client_id' => $this->clientId,
                'project_id' => $this->projectId,
                'auth_uri' => self::GOOGLE_AUTH_URI,
                'token_uri' => self::GOOGLE_TOKEN_URI,
                'auth_provider_x509_cert_url' => self::GOOGLE_CERT_URL,
                'client_secret' => $this->clientSecret,
                'redirect_uris' => [$this->redirectUrl],
            ],
        ]);
        $client->setAccessType('offline');
        $client->setPrompt('none');

        return $client;
    }
}
