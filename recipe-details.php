<?php

include 'admin/includes/db_config.php';

/*
|--------------------------------------------------------------------------
| GET RECIPE
|--------------------------------------------------------------------------
*/

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location:index.php");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $pdo->prepare("
    SELECT *
    FROM recipes
    WHERE id = ?
    AND status = 'Active'
");

$stmt->execute([$id]);

$recipe = $stmt->fetch();

if (!$recipe) {
    header("Location:index.php");
    exit();
}

/*
|--------------------------------------------------------------------------
| IMAGE
|--------------------------------------------------------------------------
*/

const DEFAULT_RECIPE_IMAGE =
"https://images.unsplash.com/photo-1546069901-ba9599a7e63c?q=80&w=1200&auto=format&fit=crop";

$imgPath = "admin/manages/recipes/uploads/recipes/" . $recipe['recipe_image'];

$finalImg =
    (!empty($recipe['recipe_image']) && file_exists($imgPath))
    ? $imgPath
    : DEFAULT_RECIPE_IMAGE;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">
    <title>
        <?= htmlspecialchars($recipe['recipe_name']); ?>
    </title>

    <!-- BOOTSTRAP -->
    <link rel="stylesheet"
        href="css/bootstrap.min.css">
    <!-- FONT AWESOME -->
    <link rel="stylesheet"
        href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">

    <style>
        a {
            transition: .3s;
        }

        .container {
            width: 100%;
            max-width: 1200px;
        }

        .custom-navbar {
            background: #fff !important;
            border: none !important;
            padding: 12px 0;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        }

        .custom-navbar .navbar-brand {
            padding-inline: 10px;
            padding-block: 0;
            height: auto;
        }

        .custom-navbar .navbar-nav>li {
            margin-left: 8px;
        }

        .custom-navbar .navbar-nav>li>a {
            color: #a82d49 !important;
            font-weight: 600;
            font-size: 14px;
            letter-spacing: .5px;
            padding: 16px 18px;
            transition: .3s;
        }

        .custom-navbar .navbar-nav>li>a:hover {
            color: #000 !important;
        }

        .navbar-toggle {
            background: #a82d49 !important;
            border: none;
        }

        .navbar-toggle .icon-bar {
            background: #fff !important;
        }

        .navbar-collapse {
            border: none !important;
        }

        .recipe-hero {
            position: relative;
            height: 720px;
            overflow: hidden;
        }

        .recipe-hero img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .recipe-hero .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top,
                    rgba(0, 0, 0, 0.82),
                    rgba(0, 0, 0, 0.25));
        }

        .hero-content {
            position: absolute;
            bottom: 100px;
            left: 0;
            width: 100%;
            z-index: 5;
            color: #fff;
        }

        .recipe-breadcrumb {
            margin-bottom: 25px;
            font-size: 14px;
        }

        .recipe-breadcrumb a {
            color: #fff;
            opacity: .85;
            text-decoration: none;
        }

        .recipe-breadcrumb a:hover {
            opacity: 1;
        }

        .recipe-breadcrumb span {
            margin: 0 10px;
            opacity: .5;
        }

        .recipe-category {
            display: inline-block;
            background: #b0284b;
            color: #fff;
            padding: 12px 24px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 25px;
            box-shadow: 0 6px 20px rgba(176, 40, 75, 0.35);
        }

        .hero-content h1 {
            font-size: 68px;
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 30px;
            max-width: 900px;
        }

        .hero-meta {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .meta-item {
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 15px 25px;
            border-radius: 18px;
            font-size: 15px;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .meta-item i {
            margin-right: 10px;
            font-size: 18px;
        }

        .recipe-details-section {
            padding: 0 0 90px;
            position: relative;
        }

        .main-wrapper {
            margin-top: -90px;
            position: relative;
            z-index: 50;
        }

        .details-card {
            background: #fff;
            border-radius: 30px;
            padding: 40px;
            margin-bottom: 35px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f1f1;
            transition: .35s;
        }

        .details-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.08);
        }


        .section-heading {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 35px;
            color: #222;
        }

        .section-heading i {
            color: #b0284b;
        }

        .recipe-content-area {
            font-size: 16px;
            line-height: 2;
            color: #555;
        }

        .recipe-content-area p {
            margin-bottom: 20px;
        }

        .recipe-content-area ul {
            padding-left: 20px;
            margin-bottom: 25px;
        }

        .recipe-content-area li {
            margin-bottom: 12px;
        }

        .recipe-content-area img {
            max-width: 100%;
            border-radius: 20px;
            margin: 25px 0;
        }


        .instructions h1,
        .instructions h2,
        .instructions h3,
        .instructions h4,
        .instructions h5 {
            margin-top: 35px;
            margin-bottom: 20px;
            color: #222;
            font-weight: 700;
        }

        .instructions strong {
            color: #111;
        }

        .sidebar-card {
            background: #fff;
            border-radius: 30px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f1f1;
            transition: .35s;
        }

        .sidebar-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 18px 50px rgba(0, 0, 0, 0.08);
        }

        .sidebar-card h3 {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 30px;
            color: #222;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-row span {
            color: #777;
            font-size: 15px;
        }

        .info-row strong {
            color: #222;
            font-weight: 700;
        }

        .social-share {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .social-share a {
            width: 55px;
            height: 55px;
            border-radius: 16px;
            background: #f5f5f5;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #222;
            font-size: 18px;
            transition: .3s;
        }

        .social-share a:hover {
            background: #b0284b;
            color: #fff;
            transform: translateY(-4px);
            box-shadow: 0 10px 20px rgba(176, 40, 75, .25);
        }


        .back-recipe-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            background: linear-gradient(135deg,
                    #b0284b,
                    #d43b65);
            color: #fff !important;
            text-decoration: none !important;
            padding: 16px 32px;
            border-radius: 50px;
            font-weight: 700;
            letter-spacing: .3px;
            box-shadow: 0 10px 25px rgba(176, 40, 75, .25);
        }

        .back-recipe-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(176, 40, 75, .35);
        }

        .footer2 {
            margin-top: 30px;
        }

        @media(max-width:991px) {

            .hero-content h1 {
                font-size: 52px;
            }

            .main-wrapper {
                margin-top: -60px;
            }

        }

        @media(max-width:768px) {

            .recipe-hero {
                height: 560px;
            }

            .hero-content {
                bottom: 50px;
            }

            .hero-content h1 {
                font-size: 38px;
                line-height: 1.25;
            }

            .hero-meta {
                flex-direction: column;
                gap: 12px;
            }

            .meta-item {
                width: fit-content;
            }

            .recipe-breadcrumb {
                display: none;
            }

            .details-card,
            .sidebar-card {
                padding: 25px;
                border-radius: 22px;
            }

            .section-heading {
                font-size: 24px;
            }

            .sidebar-card h3 {
                font-size: 22px;
            }

        }

        @media(max-width:480px) {

            .recipe-hero {
                height: 500px;
            }

            .hero-content h1 {
                font-size: 30px;
            }

            .recipe-category {
                padding: 10px 18px;
                font-size: 11px;
            }

            .meta-item {
                font-size: 13px;
                padding: 12px 18px;
            }

            .details-card,
            .sidebar-card {
                padding: 20px;
            }

            .section-heading {
                font-size: 22px;
            }

        }
    </style>
</head>

<body>
    <!-- HEADER -->
    <header>

        <nav class="navbar navbar-inverse navbar-fixed-top custom-navbar">

            <div class="container">

                <div class="navbar-header">

                    <button type="button"
                        class="navbar-toggle collapsed"
                        data-toggle="collapse"
                        data-target="#mainNav">

                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>

                    </button>

                    <a class="navbar-brand"
                        href="index.php">

                        <img src="images/logo.png"
                            alt="Logo"
                            style="height:55px;">

                    </a>

                </div>

                <div class="collapse navbar-collapse"
                    id="mainNav">

                    <ul class="nav navbar-nav navbar-right">

                        <li>
                            <a href="index.php">Home</a>
                        </li>

                        <li>
                            <a href="index.php#about">About Us</a>
                        </li>

                        <li>
                            <a href="index.php#our_products">Our Products</a>
                        </li>

                        <li>
                            <a href="index.php#our_recipes">Recipes</a>
                        </li>

                        <li>
                            <a href="index.php#contact">Contact Us</a>
                        </li>

                    </ul>

                </div>

            </div>

        </nav>

    </header>

    <!-- HERO -->
    <section class="recipe-hero">

        <div class="overlay"></div>

        <img src="<?= $finalImg; ?>"
            alt="<?= htmlspecialchars($recipe['recipe_name']); ?>">

        <div class="hero-content">

            <div class="container">

                <!-- Breadcrumb -->
                <div class="recipe-breadcrumb">

                    <a href="index.php">
                        Home
                    </a>

                    <span>/</span>

                    <a href="index.php#our_recipes">
                        Recipes
                    </a>

                    <span>/</span>

                    <strong>
                        <?= htmlspecialchars($recipe['recipe_name']); ?>
                    </strong>

                </div>

                <!-- Category -->
                <span class="recipe-category">
                    <?= htmlspecialchars($recipe['category']); ?>
                </span>

                <!-- Title -->
                <h1 style="color:#fff;">
                    <?= htmlspecialchars($recipe['recipe_name']); ?>
                </h1>

                <!-- Meta -->
                <div class="hero-meta">

                    <div class="meta-item">

                        <i class="fa fa-clock-o"></i>

                        <?= htmlspecialchars($recipe['cooking_time']); ?>

                    </div>

                    <div class="meta-item">

                        <i class="fa fa-users"></i>

                        <?= htmlspecialchars($recipe['servings']); ?>

                        Servings

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- MAIN CONTENT -->
    <section class="recipe-details-section">

        <div class="container">

            <div class="main-wrapper">

                <div class="row">

                    <!-- LEFT CONTENT -->
                    <div class="col-md-8">

                        <!-- Ingredients -->
                        <div class="details-card">

                            <div class="section-heading">

                                <i class="fa fa-shopping-basket"></i>

                                Ingredients

                            </div>

                            <div class="recipe-content-area">

                                <?= nl2br($recipe['ingredients']); ?>

                            </div>

                        </div>

                        <!-- Instructions -->
                        <div class="details-card">

                            <div class="section-heading">

                                <i class="fa fa-cutlery"></i>

                                Cooking Instructions

                            </div>

                            <div class="recipe-content-area instructions">

                                <?= $recipe['instructions']; ?>

                            </div>

                        </div>

                    </div>

                    <!-- SIDEBAR -->
                    <div class="col-md-4">

                        <!-- Quick Info -->
                        <div class="sidebar-card">

                            <h3>
                                Recipe Information
                            </h3>

                            <div class="info-box">

                                <div class="info-row">

                                    <span>
                                        Cooking Time
                                    </span>

                                    <strong>

                                        <?= htmlspecialchars($recipe['cooking_time']); ?>

                                    </strong>

                                </div>

                                <div class="info-row">

                                    <span>
                                        Servings
                                    </span>

                                    <strong>

                                        <?= htmlspecialchars($recipe['servings']); ?>

                                    </strong>

                                </div>

                                <div class="info-row">

                                    <span>
                                        Category
                                    </span>

                                    <strong>

                                        <?= htmlspecialchars($recipe['category']); ?>

                                    </strong>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer2">
        <?php include('Footer.php'); ?>
    </footer>


    <!-- Copyright -->
    <div class="footer-copy">
        <!-- <div class="container">
                © 2021. Foodera. All rights reserved.
            </div> -->
    </div>

    <!-- JS -->
    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>

</body>

</html>