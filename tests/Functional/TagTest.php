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
}
