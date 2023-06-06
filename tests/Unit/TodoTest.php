<?php

namespace App\Tests\Unit;

use App\Entity\Tag;
use App\Entity\Todo;
use PHPUnit\Framework\TestCase;

class TodoTest extends TestCase
{
    public function testSetTitle()
    {
        $todo = new Todo();
        $title = 'Test Title';

        $todo->setTitle($title);

        $this->assertEquals($title, $todo->getTitle());
    }

    public function testSetDescription()
    {
        $todo = new Todo();
        $description = 'Test Description';

        $todo->setDescription($description);

        $this->assertEquals($description, $todo->getDescription());
    }

    public function testSetDone()
    {
        $todo = new Todo();
        $done = true;

        $todo->setDone($done);

        $this->assertEquals($done, $todo->isDone());
    }

    public function testAddTag()
    {
        $todo = new Todo();
        $tag = new Tag();
        $tag2 = new Tag();

        $todo->addTag($tag);
        $todo->addTag($tag2);

        $this->assertTrue($todo->getTags()->contains($tag));
        $this->assertTrue($todo->getTags()->contains($tag2));
        $this->assertTrue($tag->getTodos()->contains($todo));
        $this->assertTrue($tag2->getTodos()->contains($todo));
    }

    public function testRemoveTag()
    {
        $todo = new Todo();
        $tag = new Tag();

        $todo->addTag($tag);
        $todo->removeTag($tag);

        $this->assertFalse($todo->getTags()->contains($tag));
        $this->assertFalse($tag->getTodos()->contains($todo));
    }

    public function testAddTagTwiceDoesNotDuplicate() {
        $todo = new Todo();
        $tag = new Tag();

        $todo->addTag($tag);
        $todo->addTag($tag);

        $this->assertCount(1, $todo->getTags());
    }
}
