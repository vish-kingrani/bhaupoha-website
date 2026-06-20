<?php
include '../includes/auth_check.php';
include '../includes/db_config.php';

// Fetch Recipes
$stmt = $pdo->prepare("SELECT * FROM recipes ORDER BY id DESC");
$stmt->execute();
$recipes = $stmt->fetchAll();

const DEFAULT_RECIPE_IMAGE = "https://images.unsplash.com/photo-1495147466023-ac5c588e2e94?q=80&w=500&auto=format&fit=crop";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recipe Gallery</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .recipe-card:hover .action-overlay { opacity: 1; }
        .line-clamp-1 { display: -webkit-box; -webkit-line-clamp: 1; -webkit-box-orient: vertical; overflow: hidden; }
    </style>
</head>

<body class="bg-[#f8fafc] min-h-screen">

    <div class="max-w-[1400px] mx-auto p-6 md:p-10">

        <!-- Header Section -->
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 gap-4">
            <div>
                <h1 class="text-4xl font-black text-slate-900 tracking-tight">My Cookbook</h1>
                <p class="text-slate-500 font-medium">You have <span class="text-orange-500"><?= count($recipes); ?></span> saved recipes</p>
            </div>

            <a href="recipes/add-recipes.php"
                class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-4 rounded-2xl shadow-lg shadow-orange-200 transition-all duration-300 flex items-center justify-center font-bold active:scale-95">
                <i class="fas fa-plus-circle mr-2 text-xl"></i>
                Create Recipe
            </a>
        </div>

        <!-- Card Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
            <?php if (count($recipes) > 0): ?>
                <?php foreach ($recipes as $recipe): ?>
                    <div class="recipe-card group bg-white rounded-md border border-slate-200 shadow-sm hover:shadow-xl hover:shadow-slate-200/50 transition-all duration-500 overflow-hidden relative">
                        
                        <!-- Image Container -->
                        <div class="relative h-64 overflow-hidden">
                            <?php 
                                $imgPath = "./recipes/uploads/recipes/" . $recipe['recipe_image'];
                                $finalImg = (!empty($recipe['recipe_image']) && file_exists($imgPath)) ? $imgPath : DEFAULT_RECIPE_IMAGE;
                            ?>
                            <img src="<?= $finalImg; ?>" 
                                 onerror="this.src='<?= DEFAULT_RECIPE_IMAGE ?>';"
                                 class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                 alt="<?= htmlspecialchars($recipe['recipe_name']); ?>">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-4 left-4">
                                <?php if ($recipe['status'] == 'Active'): ?>
                                    <span class="bg-white/90 backdrop-blur-md text-green-600 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Published
                                    </span>
                                <?php else: ?>
                                    <span class="bg-white/90 backdrop-blur-md text-slate-500 text-xs font-bold px-3 py-1.5 rounded-full shadow-sm flex items-center gap-1.5">
                                        <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Draft
                                    </span>
                                <?php endif; ?>
                            </div>

                            <!-- Action Overlay (Desktop Only Hover) -->
                            <div class="action-overlay opacity-0 absolute inset-0 bg-black/20 backdrop-blur-[2px] transition-opacity duration-300 flex items-center justify-center gap-3">
                                <a href="recipes/add-recipes.php?id=<?= $recipe['id']; ?>" class="bg-white text-slate-900 h-12 w-12 rounded-full flex items-center justify-center hover:bg-orange-500 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="recipes/delete-recipe.php?id=<?= $recipe['id']; ?>" onclick="return confirm('Delete this recipe?')" class="bg-white text-red-500 h-12 w-12 rounded-full flex items-center justify-center hover:bg-red-500 hover:text-white transition-colors duration-300">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Content Body -->
                        <div class="p-6">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-[10px] font-black uppercase tracking-[0.15em] text-orange-500 bg-orange-50 px-2 py-1 rounded-md">
                                    <?= htmlspecialchars($recipe['category']); ?>
                                </span>
                                <span class="text-slate-400 text-xs font-medium">
                                    <i class="far fa-calendar-alt mr-1"></i> <?= date('M j', strtotime($recipe['created_at'])); ?>
                                </span>
                            </div>

                            <h3 class="text-xl font-bold text-slate-800 mb-4 line-clamp-1 group-hover:text-orange-600 transition-colors">
                                <?= htmlspecialchars($recipe['recipe_name']); ?>
                            </h3>

                            <!-- Stats Footer -->
                            <div class="flex items-center justify-between pt-4 border-t border-slate-50">
                                <div class="flex items-center gap-4">
                                    <div class="text-center">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Time</p>
                                        <p class="text-sm font-bold text-slate-700"><?= htmlspecialchars($recipe['cooking_time']); ?></p>
                                    </div>
                                    <div class="w-[1px] h-6 bg-slate-100"></div>
                                    <div class="text-center">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Serves</p>
                                        <p class="text-sm font-bold text-slate-700"><?= htmlspecialchars($recipe['servings']); ?></p>
                                    </div>
                                </div>
                                
                                <!-- Mobile Actions (Visible when not hovering/small screens) -->
                                <div class="flex md:hidden gap-2">
                                     <a href="recipes/add-recipes.php?id=<?= $recipe['id']; ?>" class="text-blue-500 p-2"><i class="fas fa-edit"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-span-full py-20 text-center">
                    <div class="bg-white inline-block p-10 rounded-[3rem] shadow-sm border border-slate-100">
                        <i class="fas fa-utensils text-slate-200 text-6xl mb-4"></i>
                        <h2 class="text-xl font-bold text-slate-800">Your kitchen is empty</h2>
                        <p class="text-slate-400 mb-6">Start by adding your first delicious recipe!</p>
                        <a href="recipes/add-recipes.php" class="text-orange-500 font-bold hover:underline">Add Recipe Now &rarr;</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>