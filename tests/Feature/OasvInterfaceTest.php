<?php

namespace Tests\Feature;

use Yiegle\Oasv\Oasv;
use Nyholm\Psr7\Request;
use Nyholm\Psr7\Response;
use PHPUnit\Framework\TestCase;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use Yiegle\Oasv\OasvInterface;

class OasvInterfaceTest extends TestCase
{
    private OasvInterface $oasValidator;
    private string $oasYamlFilePath = __DIR__ . '/test.yml';

    protected function setUp(): void
    {
        // use the actual implementation, but test are against the interface
        // so we can easily replace the implementation in the future
        $this->oasValidator = new Oasv($this->oasYamlFilePath);
    }

    public function testAssertResponseIsCompliantForOas()
    {
        $body = json_encode([
            'data' => [
                'status' => 'ok'
            ]
        ]);
        $response = new Response(200, ['Content-Type' => 'application/json'], $body);
        $httpMethod = 'GET';
        $pathInOas = '/v1/healthcheck';

        $this->oasValidator->assertResponseIsCompliantForOas($response, $httpMethod, $pathInOas);
        $this->assertTrue(true); // did not throw any exceptions
    }

    public function testAssertResponseIsCompliantForOasThrowsException()
    {
        $body = json_encode(['invalid_key' => 'value']);
        $response = new Response(200, ['Content-Type' => 'application/json'], $body);
        $httpMethod = 'GET';
        $pathInOas = '/v1/healthcheck';

        $this->expectException(ValidationFailed::class);

        $this->oasValidator->assertResponseIsCompliantForOas($response, $httpMethod, $pathInOas);
    }

    public function testAssertRequestIsCompliantForOas()
    {
        $body = json_encode([
            'data' => [
                'content' => 'test',
            ]
        ]);
        $request = new Request('POST', '/v1/healthcheck', ['Content-Type' => 'application/json'], $body);
        $httpMethod = 'POST';
        $contentType = 'application/json';
        $pathInOas = '/test/path';

        $this->oasValidator->assertRequestIsCompliantForOas($request, $httpMethod, $contentType, $pathInOas);
        $this->assertTrue(true); // did not throw any exceptions
    }

    public function testAssertRequestIsCompliantForOasThrowsException()
    {
        $body = json_encode(['invalid_key' => 'value']);
        $request = new Request('POST', '/v1/healthcheck/', ['Content-Type' => 'application/json'], $body);
        $httpMethod = 'POST';
        $contentType = 'application/json';
        $pathInOas = '/test/path';

        $this->expectException(ValidationFailed::class);

        $this->oasValidator->assertRequestIsCompliantForOas($request, $httpMethod, $contentType, $pathInOas);
    }
}
