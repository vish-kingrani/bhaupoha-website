<?php

include 'admin/includes/db_config.php';

$stmt = $pdo->prepare("
    SELECT *
    FROM recipes
    WHERE status = 'Active'
    ORDER BY id DESC
");

$stmt->execute();
$recipes = $stmt->fetchAll();

const DEFAULT_RECIPE_IMAGE =
    "https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop";

$uploadPathBase = "admin/manages/recipes/uploads/recipes/";

?>

<html lang="en">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Poha Recipes – Healthy & Traditional | Bhau Poha</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Explore our collection of healthy, natural and traditional Poha recipes. Quick, delicious meals made with Bhau Poha products.">
    <meta name="keywords" content="poha recipes, healthy poha, traditional poha, bhau poha recipes">
    <meta name="author" content="Bhau Poha">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- ICONS -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ilmosys-icon.css">

    <!-- THEME CSS -->
    <link rel="stylesheet" href="css/style.css">

    <style>

        /* PAGE HEADER */

        .recipes-page-header {
            background: linear-gradient(135deg, #b0284b 0%, #7a1a32 100%);
            padding: 120px 0 60px;
            text-align: center;
            color: #fff;
        }

        .recipes-page-header h1 {
            font-size: 48px;
            font-weight: 800;
            margin-bottom: 12px;
        }

        .recipes-page-header p {
            font-size: 18px;
            opacity: 0.9;
        }

        /* GRID */

        .recipes-grid-section {
            padding: 70px 0 80px;
        }

        .recipes-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
        }

        @media (max-width: 991px) {
            .recipes-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .recipes-grid {
                grid-template-columns: 1fr;
            }

            .recipes-page-header h1 {
                font-size: 32px;
            }
        }

        /* CARD — reused from Home-recipes.php */

        .recipe-grid-item {
            display: block;
            text-decoration: none !important;
            color: inherit !important;
        }

        .recipe-grid-item:hover {
            text-decoration: none;
            color: inherit;
        }

        .modern-recipe-card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            box-shadow: 0 5px 25px rgba(0,0,0,0.06);
            transition: 0.4s ease;
            height: 100%;
        }

        .modern-recipe-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 45px rgba(0,0,0,0.12);
        }

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
            background: linear-gradient(to top, rgba(0,0,0,0.4), rgba(0,0,0,0));
        }

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

        .modern-recipe-content {
            padding: 28px;
        }

        .recipe-title {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 12px;
            color: #222;
        }

        .recipe-description {
            color: #717171;
            line-height: 1.7;
            font-size: 14px;
        }

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

        .recipe-footer {
            display: flex;
            justify-content: flex-end;
        }

        .modern-btn {
            color: blue;
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

        @media (max-width: 768px) {
            .modern-meta {
                flex-direction: column;
            }

            .modern-recipe-image {
                height: 220px;
            }
        }

        /* EMPTY STATE */

        .empty-recipes-state {
            grid-column: 1 / -1;
            padding: 60px 0;
            color: #999;
            font-size: 18px;
        }

        .empty-recipes-state i {
            font-size: 48px;
            display: block;
            margin-bottom: 16px;
            color: #b0284b;
        }

    </style>
</head>

<body>
    <div class="body">

        <!-- HEADER -->
        <header>
            <nav class="navbar-inverse navbar-lg navbar-fixed-top" style="background:white; box-shadow: none;">
                <div class="container">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;">
                        <div class="navbar-header">
                            <a href="index.php" class="navbar-brand brand" style="width:110px;">
                                <img src="images/logo.png" alt="bhau poha" style="width:100%;height:100%;">
                            </a>
                        </div>

                        <button type="button" class="navbar-toggle collapsed" style="margin-top:9px;" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown mm-menu">
                                    <a href="index.php" style="color: rgb(168, 45, 73);">Home</a>
                                </li>
                                <li class="dropdown mm-menu">
                                    <a href="index.php#about" style="color: rgb(168, 45, 73);">About Us</a>
                                </li>
                                <li class="dropdown mm-menu">
                                    <a href="index.php#our_products" style="color: rgb(168, 45, 73);">Our Products</a>
                                </li>
                                <li class="dropdown mm-menu active">
                                    <a href="recipes.php" style="color: rgb(168, 45, 73);">Recipes</a>
                                </li>
                                <li class="dropdown mm-menu">
                                    <a href="index.php#contact" style="color: rgb(168, 45, 73);">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>

        <!-- PAGE HEADER -->
        <div class="recipes-page-header">
            <h1>Our Delicious Recipes</h1>
            <p>Healthy &bull; Natural &bull; Traditional Taste</p>
        </div>

        <!-- RECIPES GRID -->
        <section class="recipes-grid-section">
            <div class="container">

                <div class="recipes-grid">

                    <?php if (count($recipes) > 0): ?>

                        <?php foreach ($recipes as $recipe): ?>

                            <?php
                                $imgPath = $uploadPathBase . $recipe['recipe_image'];
                                $finalImg = (!empty($recipe['recipe_image']) && file_exists($imgPath))
                                    ? $imgPath
                                    : DEFAULT_RECIPE_IMAGE;
                            ?>

                            <a href="recipe-details.php?id=<?= $recipe['id']; ?>" class="recipe-grid-item">
                                <div class="modern-recipe-card">

                                    <div class="modern-recipe-image">
                                        <img src="<?= $finalImg; ?>"
                                             onerror="this.src='<?= DEFAULT_RECIPE_IMAGE ?>';"
                                             alt="<?= htmlspecialchars($recipe['recipe_name']); ?>">
                                        <div class="recipe-overlay"></div>
                                        <div class="recipe-badge">
                                            <?= htmlspecialchars($recipe['category']); ?>
                                        </div>
                                    </div>

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
                                                    <strong><?= htmlspecialchars($recipe['cooking_time']); ?></strong>
                                                </div>
                                            </div>

                                            <div class="meta-box">
                                                <div class="meta-icon">
                                                    <i class="fa fa-users"></i>
                                                </div>
                                                <div>
                                                    <span class="meta-label">Servings</span>
                                                    <strong><?= htmlspecialchars($recipe['servings']); ?></strong>
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
                            <i class="fa fa-cutlery"></i>
                            <p>No active recipes found.</p>
                        </div>

                    <?php endif; ?>

                </div>
            </div>
        </section>

        <!-- FOOTER -->
        <footer class="footer2" id="footer2">
            <?php include('Footer.php') ?>
        </footer>

        <div class="footer-copy"></div>

    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
</body>

</html>
