<?php
$headTitle = "Roulette";

ob_start();
?>

<section class="main-sections">
    <article class="main-articles">
     <div class="container">
        <h1 class="main-articles-title">
            Bienvenue sur la roulette 🚀
        </h1>
        <article class="slot-machines">
            <div class="reel" id="reel1">🍒</div>
            <div class="reel" id="reel2">🍒</div>
            <div class="reel" id="reel3">🍒</div>
        </article>
        <button id="spinButton">Lancer les dés 🎲🎲</button>
        <div id="result"></div>
     </div>
     <script src="sources/js/roulette.js"></script>
    </article>
</section>


<?php
$mainContent = ob_get_clean();