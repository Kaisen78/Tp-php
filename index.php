<?php

use Models\Autoloader;

ini_set("date.timezone", "Europe/Paris");
require_once "./utils/Defines.php";
require_once "./models/Autoloader.php";

/**
 * Use autoloader to import all models
 */
Autoloader::register();
use Models\BDD;
use Models\Article;
use Models\Router;
use Controllers\ErrorsController;
use Controllers\ArticlesController;
use Controllers\BlogController;
$article = new Article(bdd: BDD::connect());

$article_test = [
    "title" => "Test",
    "content" => "Contenu de test",
    "author" => "CR7"
];

/**
 * Utilisation classique de la méthode add(), de la classe Article
 */
// $article->add(
//     title: $article_test["title"],
//     content: $article_test["content"],
//     author: $article_test["author"],
// );

// var_dump(value: $article::getList());
// echo "<hr/>";
// var_dump(value: $article::getById(id: 1));

// $article_updated = [
//     "id" => 1,
//     "title" => "Test modifié",
//     "content" => "Contenu modifié",
//     "author" => "CR7Updated",
//     "created_date" => new DateTime(datetime: "now")
// ];

// $article::update(
//     id: $article_updated["id"],
//     title: $article_updated["title"],
//     content: $article_updated["content"],
//     author: $article_updated["author"],
//     created_date: $article_updated["created_date"]->sub(interval: \DateInterval::createFromDateString(datetime: "1 hour"))->format(format: "Y/m/d H:i:s"),
// );

$router = new Router();

$uri = $_SERVER["REQUEST_URI"];
$idParam = (int) preg_replace(pattern: "/[\D]+/", replacement: "", subject: $uri);

switch (true) {
    case ($uri === "/"):
      $router->get("/", BlogController::index());
      break;
    case (str_contains(haystack: $uri, needle: "/articles")):
      if($idParam){
        $router->get(uri: "/articles/$idParam", callback: ArticlesController::getById(id: $idParam));
        exit;
      }
      else if($idParam && str_contains($uri, "/update")){
        $router->get("/articles/update/$idParam", ArticlesController::update($idParam));
        exit;
      }

      else if(!$idParam && str_contains($uri, "/update")){
        $router->post("/articles/update", ArticlesController::updateArticle());
        exit;
      }

      else if
        (!$idParam && str_contains(haystack: $uri, needle: "/delete")){
          $router->post(uri: "/articles/delete", callback: ArticlesController::deleteArticle());
        }
      $router->get(uri: "/articles", callback: ArticlesController::getList());
      break;
      default:
        ErrorsController::launchError(code: 404);
        break;
  }
$router->run();