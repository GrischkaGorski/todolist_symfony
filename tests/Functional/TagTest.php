<?php

namespace App\Tests\Functional;

use ApiPlatform\Symfony\Bundle\Test\ApiTestCase;
use App\Entity\Tag;
use App\Kernel;
use Hautelook\AliceBundle\PhpUnit\RefreshDatabaseTrait;

class TagTest extends ApiTestCase
{
    protected static function getKernelClass(): string
    {
        return Kernel::class;
    }

    use RefreshDatabaseTrait;

    public function testGetCollection(): void
    {
        $response = static::createClient()->request('GET', '/api/tags');

        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');

        $this->assertJsonContains([
            '@context' => '/api/contexts/Tag',
            '@id' => '/api/tags',
            '@type' => 'hydra:Collection',
            'hydra:totalItems' => 15
        ]);

        $this->assertCount(15, $response->toArray()['hydra:member']);
        $this->assertMatchesResourceCollectionJsonSchema(Tag::class);
    }

    public function testCreateTag(): void {
        $response = static::createClient()->request('POST', '/api/tags', ['json' => [
            'name' => 'TestCreateTag Name'
        ]]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Tag',
            '@type' => 'Tag',
            'name' => 'TestCreateTag Name',
            'todos' => [],
        ]);
        $this->assertMatchesRegularExpression('~^/api/tags/\d+$~', $response->toArray()['@id']);
        $this->assertMatchesResourceItemJsonSchema(Tag::class);
    }

    public function testCreateTagWithoutName(): void {
        $response = static::createClient()->request('POST', '/api/tags', ['json' => [
        ]]);

        $this->assertResponseStatusCodeSame(422);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/ConstraintViolationList',
            '@type' => 'ConstraintViolationList',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'name: This value should not be blank.'
        ]);
    }

    public function testCreateInvalidTag(): void
    {
        $response = static::createClient()->request('POST', '/api/tags', ['json' => [
            'name' => 1
        ]]);
        $this->assertResponseStatusCodeSame(400);
        $this->assertResponseHeaderSame('content-type', 'application/ld+json; charset=utf-8');
        $this->assertJsonContains([
            '@context' => '/api/contexts/Error',
            '@type' => 'hydra:Error',
            'hydra:title' => 'An error occurred',
            'hydra:description' => 'The type of the "name" attribute must be "string", "integer" given.',
        ]);
    }

    public function testUpdateTag(): void {
        $client = static::createClient();
        $iri = $this->findIriBy(Tag::class, ['name' => 'fuga']);

        $client->request("PUT", $iri, ['json' => [
            'name' => "TestUpdateTag new name"
        ]]);

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@id' => $iri,
            'name' => 'TestUpdateTag new name',
        ]);
    }

    public function testDeleteTag(): void {
        $client = static::createClient();
        $iri = $this->findIriBy(Tag::class, ['name' => 'reiciendis']);

        $client->request('DELETE', $iri);

        $this->assertResponseStatusCodeSame(204);

        $this->assertNull(
            static::getContainer()->get('doctrine')->getRepository(Tag::class)->findOneBy(['name' => 'reiciendis'])
        );
    }
}
