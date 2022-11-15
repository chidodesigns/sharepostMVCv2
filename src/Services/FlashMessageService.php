<?php
namespace App\Services;

class FlashMessageService
{
    /**
     * Add A Flash Message
     *
     * @param [string] $message [The Message Content]
     * @return void
     */
    public static function addMessage(string $message)
    {
        if(!isset($_SESSION['flash_notifications']))
        {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = $message;

    }

}