<?php

namespace App\Services;

class FlashMessageService
{
    /**
     * Success Message Type
     * @var string
     */
    const SUCCESS = 'success';

    /**
     * Info Message Type
     * @var string
     */
    const INFO = 'info';

    /**
     * Danger Message Type
     * @var string
     */
    const DANGER = 'danger';




    /**
     * Add A Flash Message
     *
     * @param [string] $message [The Message Content]
     * @return void
     */
    public static function addMessage(string $message, $type = 'success')
    {
        if (!isset($_SESSION['flash_notifications'])) {
            $_SESSION['flash_notifications'] = [];
        }

        $_SESSION['flash_notifications'][] = [
            'body' => $message,
            'type' => $type
        ];
    }

    /**
     * Get All Messages
     *
     * @return mixed [An array with all the messages or null if none set]
     */
    public static function getMessages()
    {
        if (isset($_SESSION['flash_notifications'])) {
            $messages =  $_SESSION['flash_notifications'];
            unset($_SESSION['flash_notifications']);

            return $messages;
        }
    }
}
