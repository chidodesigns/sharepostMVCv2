<?php
namespace App\Controllers;

use Core\Controller;
use Core\View;

class Register extends Controller
{
    /**
     * Show Register Page
     * @return void
     */
    public function newAction()
    {
        View::renderTemplate('Register/register.html');
    }
}