<?php

namespace App\Controllers;

use Core\Controller;
use \Core\View;

use App\Models\Post;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Services\FlashMessageService;
use App\Services\PostValidationService;

/**
 * Posts controller
 * 
 */

class Posts extends Authenticated
{

    /**
     * Show the index page
     * 
     * @return void 
     */
    public function indexAction()
    {
        $postRepo = new PostRepository();
        $posts = $postRepo->getAllPosts();
        View::renderTemplate('Posts/index.html', [
            'posts' => $posts
        ]);
    }

    /**
     * Show the index page
     * 
     * @return void 
     */
    public function newAction()
    {

        View::renderTemplate('Posts/create.html');
    }


    /** 
     * Show the add new page
     * 
     * @return void 
     */
    public function createAction()
    {
  
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            View::renderTemplate('500.html');
        }
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $data = [
            'title' => htmlspecialchars(trim($_POST['title'])),
            'textbox_content' => htmlspecialchars(trim($_POST['textbox_content']))
        ];

        $postValidService = new PostValidationService();

        $isPostValid = $postValidService->validatePost($data);

        if (!$isPostValid) {
            View::renderTemplate('Posts/create.html', [
                'errors' => $postValidService->getValidationErrors()
            ]);
        }

        $userRepo = new UserRepository();
        $user = $userRepo->getId($_POST['user_id']);

        if(!$user){
            View::renderTemplate('forbidden.html');
        }

        if ($isPostValid) {

            $filename = $_FILES['image']['name'];

            $tempname = $_FILES['image']['tmp_name'];

            //  Docker Container
            $folder = '/var/www/html/sharepostapp/public/images/' . $filename;

            $post = new Post;
            $post->setTitle($data['title']);
            $post->setTextboxContent($data['textbox_content']);
            $post->setImage($filename);
            $post->setUser($user->id);
            $post->createPost();

            if (move_uploaded_file($tempname, $folder)) {
                FlashMessageService::addMessage('Post Creation Successful');
                $this->redirect('/posts/index');
            } else {
                FlashMessageService::addMessage('There was an error creating your post', FlashMessageService::DANGER);
                View::renderTemplate('500.html');
            }
        }
    }
}
