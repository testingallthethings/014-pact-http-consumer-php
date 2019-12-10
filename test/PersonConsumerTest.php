<?php
declare(strict_types=1);

namespace Braddle;

use GuzzleHttp\Client;
use PhpPact\Consumer\InteractionBuilder;
use PhpPact\Consumer\Model\ConsumerRequest;
use PhpPact\Consumer\Model\ProviderResponse;
use PhpPact\Standalone\MockService\MockServerEnvConfig;
use PHPUnit\Framework\TestCase;

class PersonConsumerTest extends TestCase
{
    public function testGetPersonById()
    {
        $id = "abc-123-def-456";
        $firstName = "Dade";
        $lastName = "Murphy";
        $alias = "Zero Cool";

        $request = new ConsumerRequest();
        $request->setMethod("GET")
            ->setPath("/person/" . $id)
            ->addHeader("Accept", "application/json");

        $response = new ProviderResponse();
        $response->setStatus(200)
            ->addHeader("Content-Type", "application/json")
            ->setBody(
                [
                    "first_name" => $firstName,
                    "last_name" => $lastName,
                    "alias" => $alias,
                ]
            );

        $config = new MockServerEnvConfig();

        $builder = new InteractionBuilder($config);
        $builder->given("Person Dade Murphy (Zero Cool) exists")
            ->uponReceiving("GET person for id: " . $id)
            ->with($request)
            ->willRespondWith($response);

        $client = new Client(["base_uri" => $config->getBaseUri()]);

        $consumer = new PersonConsumer($client);

        $person = $consumer->getPersonById($id);

        $this->assertTrue($builder->verify());

        $this->assertEquals($firstName, $person->getFirstName());
        $this->assertEquals($lastName, $person->getLastName());
        $this->assertEquals($alias, $person->getAlias());
    }

}