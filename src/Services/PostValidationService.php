<?php
namespace App\Services;

class PostValidationService 
{
    public array $validationErrors = [];

    public function validatePost(array $postData)
    {
        if(empty($postData['title']))
        {
            $this->validationErrors['title_err'] = 'Please enter a title for your post';
        }

        if(empty($postData['textbox_content'])) 
        {
            $this->validationErrors['content_err'] = 'please enter a body content for your post';
        }

        if(empty($this->validationErrors['title_err'] && empty($this->validationErrors['content_err']))){
            return true;
        }else{
            return false;
        }

    }

    public function getValidationErrors()
    {
        return $this->validationErrors;
    }
}