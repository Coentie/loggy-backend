<?php

namespace DeepDigital\Loggy\Client;

use GuzzleHttp\Client as GuzzleClient;
use DeepDigital\Loggy\Server;
use Psr\Http\Message\ResponseInterface;
use DeepDigital\Loggy\Client\Exceptions\ClientRequestFailedException;

final class Client implements ClientInterface
{
    /**
     * Holds the client.
     *
     * @var \GuzzleHttp\Client
     */
    private GuzzleClient $client;

    /**
     * Client constructor.
     */
    public function __construct(GuzzleClient $client) {
        $this->client = $client;
    }

    /**
     * Creates a post request.
     *
     * @param string $uri
     * @param array  $body
     * @param array  $headers
     *
     * @throws \DeepDigital\Loggy\Client\Exceptions\ClientRequestFailedException
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function post(string $uri, array $body = [], $headers = []): mixed
    {
        $res = $this->request('POST', $uri, $body, $headers);

        if(! in_array($res->getStatusCode(), Server::SUCCESSFUL_RESPONSES)) {
            throw new ClientRequestFailedException("Request failed");
        }

        return self::decodeLaravelResource($res->getBody()->getContents());
    }

    /**
     * Makes a request.
     *
     * @param string $method
     * @param string $uri
     * @param array  $body
     * @param        $headers
     *
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return \Psr\Http\Message\ResponseInterface
     */
    private function request(string $method, string $uri, array $body = [], $headers = []) {
        return $this->client->request($method, $uri, $body, array_merge(
            $headers,
            Server::DEFAULT_HEADERS
        ));
    }

    /**
     * Decodes laravel data into a multi assoc array.
     *
     * @param string $jsonData
     *
     * @return mixed
     */
    private static function decodeLaravelResource(string $jsonData) {
        $data = json_decode($jsonData, true);

        return $data['data'];
    }
}
