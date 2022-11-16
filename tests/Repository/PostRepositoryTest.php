<?php
namespace Tests\Repository;

use PHPUnit\Framework\TestCase;

class PostRepositoryTest extends TestCase
{

    public function testgetAllPosts()
    {

        $postMockModel = $this->createMock(\App\Models\Post::class);
        $post = new $postMockModel;
        $post->setTitle('Test Title');
        $post->setTextboxContent('Test Textbox Content');
        $post->setImage('sharepost.jpg');
        $post ->createPost();

        $postRepoMockModel = $this->createMock(\App\Repository\PostRepository::class);

        $post = new $postRepoMockModel;
        $post->getAllPosts();

        $post
        ->expects($this->once())
        ->method('getAllPosts')
        ->willReturn([
            ['id' => 1, 'title' => 'Test Title', 'textbox_content' => 'Test Texbox Content', 'image' => 'sharepost.jpg']
        ]);

        $this->assertCount(1, $post->getAllPosts());

    }

}