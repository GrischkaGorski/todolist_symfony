<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Todo;
use App\Kernel;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class TodoTest extends ApiTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/todos');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Todo',
            '@id' => '/api/todos',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 10
        ]);

        $this->assertCount(10, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Todo::class);
    }

    public function testCreateTodo(): void {
        $response = static::createClient()->request('POST', '/api/todos', ['json' => [
            'title' => 'Test',
            'description' => 'Test Description',
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Todo',
            '@type' => 'Todo',
            'title' => 'Test',
            'description' => 'Test Description',
            'done' => false,
            'tags' => [],
        ]);
        $this->assertMatchesRegularExpression('~^/api/todos/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Todo::class);
    }

    public function testCreateInvalidTodo(): void
    {
        $response = static::createClient()->request('POST', '/api/todos', ['json' => [
            'title' => true
        ]]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@type' => 'hydra:Error',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'The type of the "title" attribute must be "string", "boolean" given.',
        ]);
    }

    public function testUpdateTodo(): void {
        $client = static::createClient();
        $iri = $this->findIriBy(Todo::class, ['title' => 'Consequatur quisquam recusandae asperiores accusamus nihil.']);

        $client->request("PUT", $iri, ['json' => [
            'title' => "TestUpdateTodo new title"
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'title' => 'TestUpdateTodo new title',
        ]);
    }

    public function testDeleteTodo(): void {
        $client = static::createClient();
        $iri = $this->findIriBy(Todo::class, ['title' => 'Sint dolorem delectus enim ipsum inventore sed.']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);
        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Todo::class)->findOneBy(['title' => 'Sint dolorem delectus enim ipsum inventore sed.'])
        );
    }
}
