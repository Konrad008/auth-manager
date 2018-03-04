<?php
namespace Manager\Controllers;

class AuthManager
{
    private $test;

    public function show(){

        return [
            'template' => 'main.html.php',
            'title' => 'MainPage',
            ];
    }
}