<?php

include 'admin/includes/db_config.php';
include 'admin/includes/function.php';

updateStatistics($pdo);

$stats = $pdo->query("
    SELECT * FROM statistics
")->fetchAll();

?>

<html lang="en" class="csstransforms csstransforms3d csstransitions">

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Bhau Poha – Healthy, Light & 100% Natural</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="author" content="">

    <!-- FAVICON -->
    <link rel="shortcut icon" href="images/favicon.ico">

    <!-- BOOTSTRAP -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- ICONS -->
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
        integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="css/ilmosys-icon.css">
    <!-- Slick Carousel CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    <!-- THEME / PLUGIN CSS -->
    <link rel="stylesheet" href="css/style.css">
</head>

<body id="home">
    <div class="body">
        <!-- HEADER -->
        <header>
            <nav class="navbar-inverse navbar-lg navbar-fixed-top" style="background:white; box-shadow: none;">
                <div class="container">
                    <div style="display:flex;justify-content:space-between;align-items:center;padding:10px;">
                        <div class="navbar-header">
                            <a href="#" class="navbar-brand brand" style="width:110px;"><img src="images/logo.png" alt="bhau poha" style="width:100%;HEIGHT:100%;"></a>
                        </div>

                        <button type="button" class="navbar-toggle collapsed" style="margin-top:9px;" data-toggle="collapse"
                            data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                            <ul class="nav navbar-nav navbar-right navbar-login">
                                <!-- <li>
                                <a href="tel:1800789123" style="color: rgb(168, 45, 73);"><span
                                        class="icon-call"></span> 1800 789 123</a>
                            </li> -->
                            </ul>
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown mm-menu">
                                    <a class="page-scroll" href="#home" style="color: rgb(168, 45, 73);">Home</a>
                                </li>

                                <li class="dropdown mm-menu">
                                    <a class="page-scroll" href="#about" style="color: rgb(168, 45, 73);">About Us</a>
                                </li>

                                <li class="dropdown mm-menu">
                                    <a class="page-scroll" href="#our_products" style="color: rgb(168, 45, 73);">Our products</a>
                                </li>

                                <li class="dropdown mm-menu">
                                    <a href="recipes.php" style="color: rgb(168, 45, 73);">Recipes</a>
                                </li>

                                <li class="dropdown mm-menu">
                                    <a class="page-scroll" href="#contact" style="color: rgb(168, 45, 73);">Contact Us</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>
        </header>


        <!-- Home -->
        <?php include('Home-banner.php') ?>

        <?php
        $icons = [
            'icon-world',
            'icon-rocket',
            'icon-photo',
            'icon-piggy'
        ];
        ?>

        <!-- Stats -->
        <div id="stats2" class="bg-primary">

            <div class="container">

                <div class="row">

                    <?php foreach ($stats as $index => $stat): ?>

                        <div class="col-md-3 col-sm-3">

                            <div class="stats2-info">

                                <!-- Dynamic Icon -->
                                <i class="<?= $icons[$index] ?? 'icon-star'; ?>"></i>

                                <!-- Dynamic Count -->
                                <p>

                                    <span class="count">

                                        <?= $stat['current_count']; ?>

                                    </span>+

                                </p>

                                <!-- Dynamic Title -->
                                <h2>

                                    <?= htmlspecialchars($stat['title']); ?>

                                </h2>

                            </div>

                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

        </div>


        <!-- About Us -->
        <div id="about">
            <?php include('About.php') ?>
        </div>
        <div class="space80"></div>

        <div id="our_products">
            <?php include('Home-products.php') ?>
        </div>

        <div id="our_recipes">
            <?php include('Home-recipes.php') ?>
        </div>

        <!-- contact us -->
        <div id="contact">
            <?php include('Contact-us.php') ?>
        </div>

        <!-- FOOTER -->
        <footer class="footer2" id="footer2">
            <?php include('Footer.php') ?>
        </footer>

        <!-- Copyright -->
        <div class="footer-copy">
            <!-- <div class="container">
                © 2021. Foodera. All rights reserved.
            </div> -->
        </div>


    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.4.1/dist/js/bootstrap.min.js"></script>
    <!-- Slick Slider -->
    <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
    <!-- jQuery Easing -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <!-- Stellar -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/stellar.js/0.6.2/jquery.stellar.min.js"></script>
    <!-- Isotope -->
    <script src="https://unpkg.com/isotope-layout@3/dist/isotope.pkgd.min.js"></script>
    <!-- Validation -->
    <script src="js/vendors/mc/jquery.ketchup.all.min.js"></script>
    <!-- Your Main JS -->
    <script src="js/main.js"></script>
    <!-- MC Main -->
    <script src="js/vendors/mc/main.js"></script>
</body>

</html>
