<?php
$headTitle = "Accueil";
ob_start();
?>

<section class="main-sections">
    <article class="main-articles">
        <h1 class="main-articles-title">
            Bienvenue sur le meilleur site internet !!
        </h1>
        <p>
            Le meilleur joueur de tout les temps.
        </p>
    </article>
</section>

<?php
$mainContent = ob_get_clean();