<?php

$stmt = $pdo->prepare("
    SELECT *
    FROM recipes
    WHERE status = 'Active'
    ORDER BY id DESC
");

$stmt->execute();

$recipes = $stmt->fetchAll();

/*
|--------------------------------------------------------------------------
| DEFAULT IMAGE & PATH CONFIG
|--------------------------------------------------------------------------
*/

const DEFAULT_RECIPE_IMAGE =
"https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop";

$uploadPathBase = "admin/manages/recipes/uploads/recipes/";

?>

<!-- RECIPES SECTION -->
<section id="recipes-section" class="padding80">

    <div class="container">

        <!-- Section Title -->
        <div class="text-center space-bottom-70">

            <h2 class="section-title">
                Our Delicious Recipes
            </h2>

            <p class="section-subtitle">
                Healthy • Natural • Traditional Taste
            </p>

            <div class="title-separator"></div>

        </div>

        <!-- CAROUSEL -->
        <div class="recipe-carousel" data-recipe-count="<?= count($recipes); ?>">

            <?php if(count($recipes) > 0): ?>

                <?php foreach($recipes as $recipe): ?>

                    <?php

                        $imgPath = $uploadPathBase . $recipe['recipe_image'];

                        $finalImg =
                        (!empty($recipe['recipe_image']) && file_exists($imgPath))
                        ? $imgPath
                        : DEFAULT_RECIPE_IMAGE;

                    ?>

                    <!-- CARD -->
                   <a href="recipe-details.php?id=<?= $recipe['id']; ?>" class="recipe-grid-item">

    <div class="modern-recipe-card">

        <!-- IMAGE -->
        <div class="modern-recipe-image">

            <img src="<?= $finalImg; ?>"
                 onerror="this.src='<?= DEFAULT_RECIPE_IMAGE ?>';"
                 alt="<?= htmlspecialchars($recipe['recipe_name']); ?>">

            <div class="recipe-overlay"></div>

            <div class="recipe-badge">
                <?= htmlspecialchars($recipe['category']); ?>
            </div>

        </div>

        <!-- CONTENT -->
        <div class="modern-recipe-content">

            <h3 class="recipe-title">
                <?= htmlspecialchars($recipe['recipe_name']); ?>
            </h3>

            <p class="recipe-description">
                <?= strip_tags(substr($recipe['instructions'], 0, 110)); ?>...
            </p>

            <div class="modern-meta">

                <div class="meta-box">

                    <div class="meta-icon">
                        <i class="fa fa-clock-o"></i>
                    </div>

                    <div>
                        <span class="meta-label">Time</span>

                        <strong>
                            <?= htmlspecialchars($recipe['cooking_time']); ?>
                        </strong>
                    </div>

                </div>

                <div class="meta-box">

                    <div class="meta-icon">
                        <i class="fa fa-users"></i>
                    </div>

                    <div>

                        <span class="meta-label">
                            Servings
                        </span>

                        <strong>
                            <?= htmlspecialchars($recipe['servings']); ?>
                        </strong>

                    </div>

                </div>

            </div>

            <div class="recipe-footer">

                <span class="modern-btn">
                    View Recipe
                    <i class="fa fa-arrow-right"></i>
                </span>

            </div>

        </div>

    </div>

</a>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="empty-recipes-state text-center">

                    <i class="fa fa-cutlery mb-3"></i>

                    <p>
                        No active recipes found.
                    </p>

                </div>

            <?php endif; ?>

        </div>

    </div>

</section>

<style>

/* =========================================
   SECTION
========================================= */

#recipes-section {
    margin-top:100px;
}

.space-bottom-70 {
    margin-bottom: 70px;
}

.section-title {
    font-size: 48px;
    font-weight: 800;
    margin-bottom: 15px;
    color: #2c2c2c;
}

.section-subtitle {
    color: #666;
    font-size: 19px;
    margin-bottom: 20px;
}

.title-separator {
    width: 60px;
    height: 4px;
    background: #b0284b;
    margin: 0 auto;
    border-radius: 2px;
}

/* =========================================
   CAROUSEL
========================================= */

/* =========================================
   FIX SINGLE CARD FULL WIDTH ISSUE
========================================= */

.recipe-carousel {
    margin-left: 0;
    margin-right: 0;
}

.recipe-carousel .slick-track {
    margin-left: 0;
    margin-right: 0;
}

.recipe-carousel .slick-slide {
    height: auto;
}

.recipe-carousel .slick-slide > div {
    height: 100%;
}

/* LIMIT CARD WIDTH */

.recipe-grid-item{
    display:block !important;
    width:100%;
    max-width:420px;
    padding:0 15px;
    text-decoration:none !important;
    color:inherit !important;
    box-sizing:border-box;
}

.recipe-grid-item:hover{
    text-decoration:none;
    color:inherit;
}

/* FIX IMAGE HEIGHT */

.modern-recipe-image {
    height: 260px;
    overflow: hidden;
    position: relative;
}

.modern-recipe-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.recipe-carousel.recipe-carousel--few {
    display: flex;
    justify-content: flex-start;
    gap: 30px;
}

.recipe-carousel.recipe-carousel--few .recipe-grid-item {
    flex: 0 0 420px;
    max-width: 420px;
    padding: 0;
}

/* MOBILE */

@media(max-width:768px)
{
    .recipe-grid-item {
        max-width: 100%;
        padding: 0;
    }

    .recipe-carousel.recipe-carousel--few {
        display: block;
    }

    .recipe-carousel.recipe-carousel--few .recipe-grid-item {
        max-width: 100%;
        margin-bottom: 25px;
    }

    .modern-recipe-image {
        height: 220px;
    }
}

/* =========================================
   CARD
========================================= */

.modern-recipe-card {
    background: #fff;
    border-radius: 24px;
    overflow: hidden;
    box-shadow: 0 5px 25px rgba(0,0,0,0.06);
    transition: 0.4s ease;
    height: fit-content !important;
}

.modern-recipe-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 15px 45px rgba(0,0,0,0.12);
}

/* IMAGE */

.modern-recipe-image {
    position: relative;
    overflow: hidden;
    height: 260px;
}

.modern-recipe-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: 0.7s ease;
}

.modern-recipe-card:hover img {
    transform: scale(1.06);
}

.recipe-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(
        to top,
        rgba(0,0,0,0.4),
        rgba(0,0,0,0)
    );
}

/* BADGE */

.recipe-badge {
    position: absolute;
    top: 20px;
    left: 20px;
    background: #b0284b;
    color: #fff;
    padding: 9px 18px;
    border-radius: 40px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1px;
    text-transform: uppercase;
}

/* CONTENT */

.modern-recipe-content {
    padding: 28px;
}

.recipe-title {
    font-size: 26px;
    font-weight: 800;
    margin-bottom: 12px;
    color: #222;
}

.recipe-description {
    color: #717171;
    line-height: 1.7;
    font-size: 14px;
}

/* META */

.modern-meta {
    display: flex;
    gap: 12px;
    margin-bottom: 28px;
}

.meta-box {
    display: flex;
    align-items: center;
    gap: 12px;
    background: #f9f9f9;
    border-radius: 16px;
    padding: 12px 14px;
    flex: 1;
}

.meta-icon {
    width: 44px;
    height: 44px;
    background: #b0284b;
    border-radius: 12px;
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
}

.meta-label {
    display: block;
    color: #999;
    font-size: 11px;
    margin-bottom: 1px;
}

.meta-box strong {
    font-size: 14px;
    color: #333;
}

/* BUTTON */

.recipe-footer {
    display: flex;
    justify-content: flex-end;
}

.modern-btn {
    color:blue;
    text-decoration: none;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 9px;
    transition: 0.3s;
}

.modern-btn:hover {
    color: black;
    transform: translateX(4px);
}

/* =========================================
   SLICK
========================================= */

.slick-prev,
.slick-next {
    width: 50px;
    height: 50px;
    background: #fff !important;
    border-radius: 50%;
    z-index: 20;
    box-shadow: 0 5px 20px rgba(0,0,0,0.12);
}

.slick-prev:hover,
.slick-next:hover {
    background: #b0284b !important;
}

.slick-prev:before,
.slick-next:before {
    color: #222;
    font-size: 20px;
}

.slick-prev:hover:before,
.slick-next:hover:before {
    color: #fff;
}

.slick-prev {
    left: -20px;
}

.slick-next {
    right: -20px;
}

/* DOTS */

.slick-dots {
        text-align: center;
    width: fit-content;
}

.slick-dots li button:before {
    font-size: 12px;
    color: #b0284b;
    opacity: 0.3;
}

.slick-dots li.slick-active button:before {
    opacity: 1;
}

/* MOBILE */

@media(max-width:768px)
{
    .section-title {
        font-size: 34px;
    }

    .modern-meta {
        flex-direction: column;
    }

    .slick-prev {
        left: -5px;
    }

    .slick-next {
        right: -5px;
    }
}

</style>

<script>

(function() {
    function initRecipeCarousel() {
        var carousel = document.querySelector('.recipe-carousel');

        if (!carousel) {
            return true;
        }

        var totalRecipes = carousel.querySelectorAll('.recipe-grid-item').length;

        if (!totalRecipes) {
            return true;
        }

        if (totalRecipes < 3) {
            carousel.classList.add('recipe-carousel--few');
            return true;
        }

        if (!window.jQuery || !jQuery.fn || !jQuery.fn.slick) {
            return false;
        }

        var $carousel = jQuery(carousel);

        if ($carousel.hasClass('slick-initialized')) {
            return true;
        }

        $carousel.slick({
            slidesToShow: 3,
            slidesToScroll: 1,

            autoplay: true,
            autoplaySpeed: 3000,

            speed: 700,

            dots: true,
            arrows: true,

            infinite: totalRecipes > 3,

            pauseOnHover: true,

            centerMode: false,
            variableWidth: false,

            responsive: [
                {
                    breakpoint: 992,
                    settings: {
                        slidesToShow: 2
                    }
                },
                {
                    breakpoint: 768,
                    settings: {
                        slidesToShow: 1
                    }
                }
            ]
        });

        return true;
    }

    function ready(fn) {
        if (document.readyState !== 'loading') {
            fn();
        } else {
            document.addEventListener('DOMContentLoaded', fn);
        }
    }

    ready(function() {
        if (initRecipeCarousel()) {
            return;
        }

        var attempts = 0;
        var timer = window.setInterval(function() {
            attempts++;

            if (initRecipeCarousel() || attempts >= 20) {
                window.clearInterval(timer);
            }
        }, 150);
    });
})();

</script>