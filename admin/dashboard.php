<?php
include 'includes/auth_check.php'; // Protect the page
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <div class="flex flex-col md:flex-row">
        <div class="bg-slate-900 shadow-xl h-16 fixed bottom-0 md:relative md:h-screen z-10 w-full md:w-64">
            <div class="md:mt-12 md:w-64 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                <div class="p-5 text-white hidden md:block">
                    <h2 class="font-bold text-xl">Admin Panel</h2>
                    <p class="text-xs text-gray-400">Bhau Poha</p>
                </div>

                <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                    <li class="mr-3 flex-1">
                        <a href="dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                            <i class="fas fa-chart-line pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Dashboard</span>
                        </a>
                    </li>
                    <!-- <li class="mr-3 flex-1">
                        <a href="manages/manage-gallery.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-white border-b-2 border-transparent hover:border-pink-500">
                            <i class="fas fa-images pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Gallery</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <a href="manages/manage-tour-packages.php" class="block py-1 md:py-3 pl-1 align-middle text-gray-400 no-underline hover:text-white border-b-2 border-transparent hover:border-purple-500">
                            <i class="fa fa-route pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base block md:inline-block">Properties</span>
                        </a>
                    </li> -->
                </ul>
            </div>
        </div>

        <div class="main-content flex-1 bg-gray-100 pb-24 md:pb-5">

            <div class="bg-white border-b border-gray-200 p-4 flex justify-between items-center shadow-sm">
                <h1 class="font-bold text-gray-700 uppercase">System Overview</h1>
                <div>
                    <span class="text-gray-600 mr-4 hidden md:inline">Welcome, Admin</span>
                    <a href="logout.php" onclick="return confirmLogout()" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-sm transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </a>
                </div>
            </div>

            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-pink-500 hover:shadow-lg transition">
                        <div class="flex items-center">
                            <div class="p-3 bg-pink-100 rounded-full text-pink-500 mr-4">
                                <i class="fas fa-images fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Image Gallery</h3>
                                <a href="manages/manage-gallery.php" class="text-pink-500 text-sm hover:underline">Manage Photos &rarr;</a>
                            </div>
                        </div>
                    </div> -->

                    <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-purple-500 hover:shadow-lg transition">
                        <div class="flex items-center">
                            <div class="p-3 bg-purple-100 rounded-full text-purple-500 mr-4">
                                <i class="fas fa-map-marked-alt fa-2x"></i>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold">Recipe</h3>
                                <a href="manages/manage-recipes.php" class="text-purple-500 text-sm hover:underline">Manage Recipes &rarr;</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function confirmLogout() {
            return confirm("Are you sure you want to log out of your admin session?");
        }
    </script>
</body>

</html>