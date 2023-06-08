<?php

namespace App\Tests\Unit;

use App\Entity\Tag;
use App\Entity\Todo;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{
    public function testSetName() {
        $tag = new Tag();
        $tagName = "Test Name";

        $tag->setName($tagName);

        $this->assertEquals($tagName, $tag->getName());
    }

    public function testAddTodo() {
        $tag = new Tag();
        $todo = new Todo();
        $todo2 = new Todo();

        $tag->addTodo($todo);
        $tag->addTodo($todo2);

        $this->assertTrue($tag->getTodos()->contains($todo));
        $this->assertTrue($tag->getTodos()->contains($todo2));
        $this->assertTrue($todo->getTags()->contains($tag));
        $this->assertTrue($todo2->getTags()->contains($tag));
    }

    public function testAddTodoDoesNotDuplicate() {
        $tag = new Tag();
        $todo = new Todo();

        $tag->addTodo($todo);
        $tag->addTodo($todo);

        $this->assertCount(1, $tag->getTodos());
    }

    public function testRemoveTodo() {
        $tag = new Tag();
        $todo = new Todo();
        $todo2 = new Todo();

        $tag->addTodo($todo);
        $tag->addTodo($todo2);

        $this->assertTrue($tag->getTodos()->contains($todo));
        $this->assertTrue($tag->getTodos()->contains($todo2));

        $tag->removeTodo($todo2);

        $this->assertFalse($tag->getTodos()->contains($todo2));
    }
}
