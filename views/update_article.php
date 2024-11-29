<?php
$headTitle = "Mise à jour d'un article";

if(!isset($article) || $article){
    header(header: "Location: /418");
    exit;
}
ob_start();
?>

<section class="main-sections">
    <article class="main-articles">
        <h1 class="main-article-main">
        </h1>

        <form action="/articles/update" method="POST">
            <label for="title">
                Titre
            </label>
            <input type="text" name="title" id="title"/>

            <label for="author">
                Auteur
            </label>
            <input type="text" name="author" id="author"/>

            <label for="content">
                Contenu de l'article
            </label>
            <textarea name="content" id="content"></textarea>

            <input type="hidden" value="<?= $article->id ?>" name="id" required/>

            <button type="submit" class="cta-btns">
                Modifier
            </button>
        </form>
    </article>
</section>

<?php
$mainContent = ob_get_clean();