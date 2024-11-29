<?php

namespace Models;
use Exception;

class Utils{

    public static function launchExeption(string $message): never{
        throw new Exception(message: $message);
    }

    public static function readException(Exception $e): never{
        die("Erreur : ".$e->getMessage());
    }
}