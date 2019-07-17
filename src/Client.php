<?php

namespace Fred\SlackService;

use GuzzleHttp\Client as Guzzle;

class Client
{
    /**
     * @var Guzzle
     */
    private $http;

    /**
     * @var string
     */
    private $channel;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $endpoint;

    /**
     * @var Message
     */
    private $message;

    /**
     * Client constructor.
     * @param Guzzle|null $client
     * @param string $endpoint
     * @param string|null $channel
     * @param string $username
     */
    public function __construct(string $endpoint, string $channel = null, $username = '', Guzzle $client = null)
    {
        if ($client === null) {
            $this->http = $this->makeHttpClient();
        } else {
            $this->http = $client;
        }

        $this->channel = $channel;
        $this->username = $username;
        $this->endpoint = $endpoint;
    }

    /**
     * @param array $headers
     * @return Guzzle
     */
    private function makeHttpClient(array $headers = []): Guzzle
    {
        return new Guzzle([
            'headers' => !empty($headers) ? $headers : ['Content-type: application/json'],
        ]);
    }

    /**
     * @param callable $callback
     *
     * @return $this
     */
    public function compose(callable $callback): self
    {
        $newMessage = (new Message())
            ->from($this->username)
            ->to($this->channel);

        $this->message = $callback($newMessage);

        return $this;
    }

    public function send(): void
    {
        $payload = $this->message->createPayload();

        $this->http->post($this->endpoint, [ 'body' => $payload ]);
    }
}
