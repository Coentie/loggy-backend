<?php

namespace DeepDigital\Loggy\Client;

use Psr\Http\Message\ResponseInterface;

interface ClientInterface
{
    /**
     * @param string $uri
     * @param array  $body
     * @param array  $headers
     *
     * @return mixed
     */
    public function post(string $uri, array $body = [], $headers = []): mixed;
}
