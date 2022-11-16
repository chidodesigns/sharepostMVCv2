<?php

namespace Tests\Models;

use App\Models\Post;
use PHPUnit\Framework\TestCase;

class PostTest extends TestCase
{
    private $post;

    protected function setUp(): void
    {
        $this->post = new Post;
    }

    public function testTitleGetterSetterFn()
    {
        $this->post->setTitle('Test Title');
        $this->assertEquals('Test Title', $this->post->getTitle());
    }

    public function testTextBoxContentGetterSetterFn()
    {
        $this->post->setTextboxContent('Test Textbox Content');
        $this->assertEquals('Test Textbox Content', $this->post->getTextboxContent());
    }

    public function testImageGetterSetterFn()
    {
        $this->post->setImage('sharepost.jpg');
        $this->assertEquals('sharepost.jpg', $this->post->getImage());
    }

    public function createPost()
    {
        $postMockModel = $this->createMock(\App\Models\Post::class);
        $post = new $postMockModel;
        $post->setTitle('Test Title');
        $post->setTextboxContent('Test Textbox Content');
        $post->setImage('sharepost.jpg');
        $post ->createPost();

        $post
        ->expects($this->once())
        ->method('createPost')
        ->willReturn($post);

        $this->assertEquals($post, $post->create());
    }
}
