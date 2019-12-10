<?php
declare(strict_types=1);

namespace Braddle;

use GuzzleHttp\Client;

class PersonConsumer
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getPersonById(string $id) : Person
    {
        $response = $this->client->get(
            "/person/" . $id,
            [
                "headers" => [
                    "Accept" => "application/json"
                ]
            ]
        );

        $body = json_decode($response->getBody()->getContents(), true);

        return new Person(
            $body["first_name"],
            $body["last_name"],
            $body["alias"]
        );
    }
}