<?php

declare(strict_types=1);

namespace ApiTest\Functional\User;

use ApiTest\Functional\TestCase;
use Laminas\Diactoros\ServerRequest;
use Laminas\Diactoros\Stream;
use Laminas\Diactoros\Uri;

class ClientRegistrationTest extends TestCase
{
    public function testClientRegistrationSuccess(): void
    {
        $request = new ServerRequest([], [], new Uri('/api/v1/client/register'), 'POST');
        $request = $request->withHeader('Content-Type', 'application/json');
        
        $requestBody = [
            'identity' => 'testclient',
            'password' => 'TestPassword123',
            'cabinetName' => 'Тестовый кабинет'
        ];
        
        $stream = new Stream('php://temp', 'wb+');
        $stream->write(json_encode($requestBody));
        $stream->rewind();
        
        $request = $request->withBody($stream);
        
        $response = $this->app->handle($request);
        
        $this->assertEquals(201, $response->getStatusCode());
        
        $responseBody = json_decode((string) $response->getBody(), true);
        
        $this->assertEquals('success', $responseBody['status']);
        $this->assertArrayHasKey('data', $responseBody);
        $this->assertArrayHasKey('user', $responseBody['data']);
        $this->assertArrayHasKey('cabinet', $responseBody['data']);
        $this->assertArrayHasKey('warehouse', $responseBody['data']);
        
        $this->assertEquals('testclient', $responseBody['data']['user']['identity']);
        $this->assertEquals('active', $responseBody['data']['user']['status']);
        
        $this->assertEquals('Тестовый кабинет', $responseBody['data']['cabinet']['name']);
        $this->assertEquals('active', $responseBody['data']['cabinet']['status']);
        
        $this->assertEquals('Основной склад', $responseBody['data']['warehouse']['name']);
        $this->assertEquals('main', $responseBody['data']['warehouse']['type']);
    }
    
    public function testClientRegistrationValidationError(): void
    {
        $request = new ServerRequest([], [], new Uri('/api/v1/client/register'), 'POST');
        $request = $request->withHeader('Content-Type', 'application/json');
        
        $requestBody = [
            'identity' => 'te', // Слишком короткий идентификатор
            'password' => '123', // Слишком короткий пароль
            'cabinetName' => 'Те' // Слишком короткое имя кабинета
        ];
        
        $stream = new Stream('php://temp', 'wb+');
        $stream->write(json_encode($requestBody));
        $stream->rewind();
        
        $request = $request->withBody($stream);
        
        $response = $this->app->handle($request);
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $responseBody = json_decode((string) $response->getBody(), true);
        
        $this->assertEquals('error', $responseBody['status']);
        $this->assertArrayHasKey('messages', $responseBody);
    }
    
    public function testClientRegistrationMissingFields(): void
    {
        $request = new ServerRequest([], [], new Uri('/api/v1/client/register'), 'POST');
        $request = $request->withHeader('Content-Type', 'application/json');
        
        $requestBody = [
            'identity' => 'testclient'
            // Отсутствуют обязательные поля password и cabinetName
        ];
        
        $stream = new Stream('php://temp', 'wb+');
        $stream->write(json_encode($requestBody));
        $stream->rewind();
        
        $request = $request->withBody($stream);
        
        $response = $this->app->handle($request);
        
        $this->assertEquals(400, $response->getStatusCode());
        
        $responseBody = json_decode((string) $response->getBody(), true);
        
        $this->assertEquals('error', $responseBody['status']);
        $this->assertArrayHasKey('messages', $responseBody);
    }
} 