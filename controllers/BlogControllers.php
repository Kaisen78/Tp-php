<?php
namespace Controllers;

class BlogController{

    public static function index(): void{
        require_once ROOT."/views/home.php";
        require_once ROOT."/templates/global.php";
    }
}