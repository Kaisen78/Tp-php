<?php

namespace Models;

class Article{

    // Les mots clés d'accès sont : public, protected et private.
    protected static int $id;
    protected static string $title;
    protected static string $content;
    protected static string $author;
    protected static string $created_date;
    protected static string $modification_date;

    private static $bdd;

    public function __construct($bdd = null){
        if(!is_null(value: $bdd)){
            self::setBdd(bdd: $bdd);
        }
    }

    /**
     * Accesseur = Getter
     * Mutateur = Setter
     */
    public static function getId(): int{
        return self::$id;
    }

    public static function setId(int $id): void{
        self::$id = $id;
    }

    public static function setTitle(string $title): void{
        self::$title = $title;
    }

    public static function getAuthor(): string{
        return self::$author;
    }

    public static function setAuthor(string $author): void{
        self::$author = $author;
    }

    public static function getCreatedDate(): \DateTime{
        $date = new \DateTime(self:$created_date);
        return self::$created_date;
    }

    public static function setCreatedDate(string $created_date): void{
        self::$created_date = $created_date;
    }

    public static function getModifcationDate(): \DateTime{
        $date = new \DateTime(self:$modification_date);
        return $date;
    }

    public static function setModifcationDate(string $modification_date): void{
        self::$modification_date = $modification_date;
    }

    public static function setAllParams($params): void{
        [
            "id" => $id,
            "title" => $title,
            "content" => $content,
            "author" => $author,
            "created_date" => $created_date,
            "modification_date" => $modification_date,
        ] = get_object_vars(object: $params);
        self::setId(id: $id);
        self::setTitle(title: $title);
        self::setContent(content: $content);
        self::setAuthor(author: $author);
        self::setCreatedDate(created_date: $created_date);
        self::setModifcationDate(modification_date: $modification_date);
    }

    public static function add(
        string $title,
        string $content,
        string $author
    ): void{
        try{

            $req = self::$bdd->prepare("INSERT INTO articles(title, content, author) VALUES(:title, :content, :author)");
            $req->bindValue(":title", $title, \PDO::PARAM_STR);
            $req->bindValue(":content", $content, \PDO::PARAM_STR);
            $req->bindValue(":author", $author, \PDO::PARAM_STR);

            if(!$req->execute()){
                Utils::launchException(message: "Une erreur s'est produite lors de l'ajour d'un article.");
            }
        }catch(\Exception $e){
            Utils::readException(e: $e);
        }
    }

    public static function getList() {
        try{

            $req = self::$bdd->prepare("SELECT * FROM articles ORDER BY id ASC");

            if(!$req->execute()){
                Utils::launchException(message: "Une erreur s'est produite lors de la récupération de la liste des articles. ");
            }

            $articles = $req->fetchAll(\PDO::FETCH_OBJ);
            $req->closeCursor();

            if (!$articles){
                Utils::launchException(message: "La table articles est vide.");
            }

            return $articles;

        }catch(\Exception $e){
            Utils::readException(e: $e);
        }
    }

    public static function getById(int $id) {
        try{
            $req = self::$bdd->prepare("SELECT * FROM articles WHERE id = :id");
            $req->bindValue(":id", $id, \PDO::PARAM_INT);

            if(!$req->execute()){
                Utils::launchException(message: "Une erreur s'est produite lors de la récupération de l'article.");
            }

            $article = $req->fetch(\PDO::FETCH_OBJ);

            if(!$article){
                Utils::launchException(message: "L'article ciblé est introuvable.");
            }

            return $article;
        }catch(\Exception $e){
            Utils::readException(e: $e);
        }
    }

    public static function update(
        int $id,
        string $title,
        string $content,
        string $author
    ){

        try{

            $req = self::$bdd->prepare("UPDATE articles SET title=:title, content=:content, author=author, created_date=:created_date WHERE id=:id");
            $req->bindValue(":id", $id, \PDO::PARAM_INT);
            $req->bindValue(":title", $title, \PDO::PARAM_STR);
            $req->bindValue(":content", $content, \PDO::PARAM_STR);
            $req->bindValue(":author", $author, \PDO::PARAM_STR);
            $req->bindValue(":created_date", $created_date, \PDO::PARAM_STR);

            if(!$req->execute()){
                Utils::launchException(message: "Une erreur s'est produite lors de la mise à jour de l'article.");
            }

            return true;

        }catch(\Exception $e){
            Utils::readException(e: $e);
        }

    }

    public static function deleteAll(int $id): mixed{
        return self::$bdd->exec("DELETE FROM articles");
    }

    public static function deleteArticle(int $id): mixed{
        return self::$bdd->exec("DELETE FROM articles WHERE id=$id");
    }
    //Créer les méthodes BDD
    public static function setBdd($bdd): void{
        self::$bdd = $bdd;
    }
}
