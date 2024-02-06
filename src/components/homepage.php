<?php
    require_once(__DIR__."/../variable_utils.php");
    require_once(VarUtils::getDocumentRoot()."session.php");
    
    Session::startSession();
?>
<main>
    <section class="title column flex-center">
        <div class="container">
            <h1 class="title__name text-large">TOTALITARIAN</h1>
            <h2 class="title__slogan text-medium">Your World, Your Rules</h2>
        </div>
    </section>

    <hr class="divider">

    <section class="presentation column flex-center">
        <div class="container">
            <h1 class="presentation__title text-large">Rule Over The World</h1>
            <p class="presentation__description text-medium">Totalitarian is the most prestigious market for aspyring absolute rulers</p>
            <div class="presentation__imgs column flex-center">
                <img class="presentation__imgs__product product" src="/Totalitarian/src/assets/img/un_paper.svg" alt="Example Product 1">
                <img class="presentation__imgs__product product" src="/Totalitarian/src/assets/img/saddam.svg" alt="Example Product 2">
                <img class="presentation__imgs__product product" src="/Totalitarian/src/assets/img/un_paper.svg" alt="Example Product 3">
            </div>
        </div>
    </section>

    <hr class="divider divider--presentation">

    <section class="features column flex-center">
        <div class="features__list container column flex-center">
            <article class="features__list__feature">
                <h2 class="text-large">Premium</h2>
                <p class="text-medium">Only state-of-the-art products from the best distributors</p>
            </article>
            <article class="features__list__feature">
                <h2 class="text-large">Reliable</h2>
                <p class="text-medium">Our service is trustworthy and certified by nearly all major rulers in the market</p>
            </article>
            <article class="features__list__feature">
                <h2 class="text-large">Powerful</h2>
                <p class="text-medium">All products are tested and proven to be effective, with excellent results</p>
            </article>
        </div>
    </section>

    <hr class="divider divider--features">

    <section class="cta column flex-center">
        <div class="cta__list container column flex-center">
            <div class="cta__list__article">
                <p class="cta__list__article__title text-small"><em>Join The Winners</em></p>
                <a href="/Totalitarian/src/auth/register.php" class="cta__list__article__btn text-large">REGISTER</a>
            </div>
            <div class="cta__list__article">
                <p class="cta__list__article__title text-small"><em>Already Joined Us?</em></p>
                <a href="/Totalitarian/src/auth/login.php" class="cta__list__article__btn text-large">LOGIN</a>
            </div>
        </div>
    </section>
    
    <a href="#" class="top-btn btn"><i class="fa-solid fa-arrow-up"></i></a>
</main>