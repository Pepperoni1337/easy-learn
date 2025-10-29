<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final readonly class OpenAiApiClient implements HttpClientInterface
{
    private HttpClientInterface $httpClient;

    public function __construct(
        private string $openAiUrl,
        private string $openAiApiKey,
        //logger
    ) {
        $this->httpClient = HttpClient::create([
            'base_uri' => $this->openAiUrl,
            'timeout' => 120.0,
            'max_duration' => 300.0,
        ]);
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        $options = array_merge($options, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->openAiApiKey,
                'Content-Type'  => 'application/json',
            ],
        ]);

        return $this->httpClient->request(
            $method,
            $url,
            $options,
        );
    }

    public function stream(iterable|ResponseInterface $responses, ?float $timeout = null): ResponseStreamInterface
    {
        return $this->httpClient->stream($responses, $timeout);
    }

    public function withOptions(array $options): static
    {
        $this->httpClient->withOptions($options);

        return $this;
    }
}
