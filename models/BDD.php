<?php

namespace Models;
use PDO;
use Exception;

class BDD{

    public static function connect(): PDO{
        $database = parse_ini_file(filename: ROOT."/config/bdd.ini");
        $host = $database["host"];
        $dbname = $database["dbname"];
        $username = $database["username"];
        $password = $database["password"];

        try{

            $bdd = new PDO(
                dsn:"mysql:host=$host;dbname=$dbname;charset=utf8",
                username: $username,
                password: $password,
                options: [PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]
            );

            return $bdd;

        }catch(Exception $e){
            die("Erreur : ". $e->getMessage());
        }
    }
}