<?php

declare(strict_types=1);

namespace App\Infrastructure\OpenAI;

use App\Util\UrlUtil;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;

final readonly class OpenAiApiClient implements HttpClientInterface {
    private HttpClientInterface $httpClient;

    public function __construct(
        private string $openAiUrl,
        private string $openAiApiKey,
        //logger
    ) {
        $this->httpClient = HttpClient::create([
            'base_uri' => $this->openAiUrl,
        ]);
    }

    public function request(string $method, string $url, array $options = []): ResponseInterface {
        return $this->httpClient->request(
            $method,
            $this->createUrl($url),
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

    private function createUrl(string $path): string {
        return UrlUtil::createUrl(
            isHttps: true,
            host: $this->openAiUrl,
            path: $path,
            query: [
                '_access_token' => $this->openAiApiKey,
            ],
        );
    }
}