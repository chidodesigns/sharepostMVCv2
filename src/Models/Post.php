<?php

namespace App\Models;

use Core\DatabaseORM;
use ORM;

/**
 * Post Model
 */

 class Post extends DatabaseORM {

    private string $title;
    private string $textbox_content;
    private string $image;
    private int $user;

    public function __construct()
    {
        parent::__construct();
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title):self
    {
        $this->title = $title;

        return $this;
    }

    public function getTextboxContent()
    {
        return $this->textbox_content;
    }

    public function setTextboxContent($textboxContent):self
    {
        $this->textbox_content = $textboxContent;

        return $this;
    }

    public function getImage()
    {
        $this->image;
    }

    public function setImage($image):self
    {
        $this->image = $image;
        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(int $userId):self
    {
        $this->user = $userId;
        return $this;
    }

    public function createPost()
    {
        $post = ORM::for_table('posts')->create();
        $post->title = $this->title;
        $post->user_id = $this->user;
        $post->textbox_content = $this->textbox_content;
        $post->image = $this->image;
        $post->save();
    }


 }