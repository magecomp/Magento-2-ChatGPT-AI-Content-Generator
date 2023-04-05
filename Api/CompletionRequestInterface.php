<?php
namespace Magecomp\Chatgptaicontent\Api;

use Psr\Http\Message\StreamInterface;

interface CompletionRequestInterface
{
    public function getApiPayload(string $text): array;
    public function convertToResponse(StreamInterface $stream): string;
    public function getJsConfig(): ?array;
    public function query(string $prompt): string;
    public function getType(): string;
    public function getQuery(array $params): string;
}
