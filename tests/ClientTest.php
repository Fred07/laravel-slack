<?php

use Fred\SlackService\Message;
use PHPUnit\Framework\TestCase;

class ClientTest extends TestCase
{
    /**
     * @test
     */
    public function it_should_send_correct_message_to_slack(): void
    {
        $expected = [
            'text' => 'hello',
            'channel' => 't-ch',
            'mrkdwn' => true,
            'username' => 't-name',
        ];

        $container = [];
        $history = GuzzleHttp\Middleware::history($container);
        $mock = new GuzzleHttp\Handler\MockHandler([
            new GuzzleHttp\Psr7\Response(200, ['test' => true]),
        ]);
        $handler = GuzzleHttp\HandlerStack::create($mock);
        $handler->push($history);
        $client = new GuzzleHttp\Client(['handler' => $handler]);

        $slackClient = new Fred\SlackService\Client('/mock-server', 't-ch', 't-name', $client);
        $slackClient->compose(function (Message $message) {
            $message->setText('hello');
            return $message;
        })->send();

        $transaction = $container[0];
        /** @var \GuzzleHttp\Psr7\Request $request */
        $request = $transaction['request'];

        $actual = $request->getBody()->getContents();

        $this->assertEquals($expected, json_decode($actual, true));
    }
}