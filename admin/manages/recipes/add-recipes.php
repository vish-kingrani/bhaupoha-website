<?php
include '../../includes/auth_check.php';
include '../../includes/db_config.php';

$isEdit = false;
$recipe = null;

$errors = [];
$success = "";

/*
|--------------------------------------------------------------------------
| UPLOAD SETTINGS
|--------------------------------------------------------------------------
*/

$upload_dir = "./uploads/recipes/";
$max_file_size = 4 * 1024 * 1024; // 4MB

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

/*
|--------------------------------------------------------------------------
| EDIT FETCH
|--------------------------------------------------------------------------
*/

if (isset($_GET['id'])) {
    $isEdit = true;

    $id = (int)$_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
    $stmt->execute([$id]);

    $recipe = $stmt->fetch();

    if (!$recipe) {
        die("Recipe not found");
    }
}

/*
|--------------------------------------------------------------------------
| ADD / UPDATE
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recipe_name   = trim($_POST['recipe_name']);
    $category      = trim($_POST['category']);
    $ingredients   = trim($_POST['ingredients']);
    $instructions  = trim($_POST['instructions']);
    $cooking_time  = trim($_POST['cooking_time']);
    $servings      = trim($_POST['servings']);
    $status        = trim($_POST['status']);

    $imageName = $recipe['recipe_image'] ?? '';

    /*
    |--------------------------------------------------------------------------
    | VALIDATION
    |--------------------------------------------------------------------------
    */

    if (empty($recipe_name)) {
        $errors[] = "Recipe name is required.";
    }

    /*
    |--------------------------------------------------------------------------
    | IMAGE VALIDATION & UPLOAD
    |--------------------------------------------------------------------------
    */

    if (isset($_FILES['recipe_image']) && !empty($_FILES['recipe_image']['name'])) {
        $file = $_FILES['recipe_image'];

        $name       = $file['name'];
        $tmp_name   = $file['tmp_name'];
        $size       = $file['size'];
        $error_code = $file['error'];

        // System Error Check
        if ($error_code !== UPLOAD_ERR_OK) {
            $errors[] = "System error while uploading image.";
        }

        // Check Real Image
        $check = @getimagesize($tmp_name);

        if ($check === false) {
            $errors[] = "Uploaded file is not a valid image.";
        }

        // File Size Check
        if ($size > $max_file_size) {
            $errors[] = "Image size must be less than 4MB.";
        }

        // Allowed Extensions
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];

        $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            $errors[] = "Only JPG, PNG, JPEG & WEBP allowed.";
        }

        /*
        |--------------------------------------------------------------------------
        | UPLOAD IMAGE
        |--------------------------------------------------------------------------
        */

        if (empty($errors)) {
            $imageName = "RECIPE_" . uniqid() . "." . $ext;

            $target_file = $upload_dir . $imageName;

            if (move_uploaded_file($tmp_name, $target_file)) {
                // Delete old image during edit
                if ($isEdit && !empty($recipe['recipe_image'])) {
                    $oldImage = $upload_dir . $recipe['recipe_image'];

                    if (file_exists($oldImage)) {
                        unlink($oldImage);
                    }
                }
            } else {
                $errors[] = "Failed to upload image.";
            }
        }
    }

    /*
    |--------------------------------------------------------------------------
    | SAVE DATA
    |--------------------------------------------------------------------------
    */

    if (empty($errors)) {

        try {

            /*
            |--------------------------------------------------------------------------
            | UPDATE
            |--------------------------------------------------------------------------
            */

            if ($isEdit) {
                $query = "UPDATE recipes SET
                            recipe_name=?,
                            category=?,
                            recipe_image=?,
                            ingredients=?,
                            instructions=?,
                            cooking_time=?,
                            servings=?,
                            status=?
                            WHERE id=?";

                $stmt = $pdo->prepare($query);

                $stmt->execute([
                    $recipe_name,
                    $category,
                    $imageName,
                    $ingredients,
                    $instructions,
                    $cooking_time,
                    $servings,
                    $status,
                    $id
                ]);

                $success = "Recipe updated successfully!";

            /*
            |--------------------------------------------------------------------------
            | INSERT
            |--------------------------------------------------------------------------
            */
            } else {
                $query = "INSERT INTO recipes
                (
                    recipe_name,
                    category,
                    recipe_image,
                    ingredients,
                    instructions,
                    cooking_time,
                    servings,
                    status
                )
                VALUES (?,?,?,?,?,?,?,?)";

                $stmt = $pdo->prepare($query);

                $stmt->execute([
                    $recipe_name,
                    $category,
                    $imageName,
                    $ingredients,
                    $instructions,
                    $cooking_time,
                    $servings,
                    $status
                ]);

                $success = "Recipe added successfully!";
            }

            header("Refresh:1; url=../manage-recipes.php");

        } catch (\PDOException $e) {
            $errors[] = "Database error: " . $e->getMessage();
        }

    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $isEdit ? 'Edit Recipe' : 'Add Recipe'; ?></title>
    
    <!-- Tailwind for Layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- CKEditor for the "MS Word" experience -->
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>

    <style>
        /* Ensuring the editor feels like a document */
        .ck-editor__editable_inline {
            min-height: 250px;
            border-bottom-left-radius: 0.75rem !important;
            border-bottom-right-radius: 0.75rem !important;
        }
        .ck-toolbar {
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            background-color: #f9fafb !important;
        }
    </style>
</head>

<body class="bg-[#f3f4f6] min-h-screen">

<div class="max-w-[1400px] mx-auto px-6 py-8">

    <?php if (!empty($errors)): ?>
        <div style="background:#fef2f2;border:1px solid #fca5a5;color:#b91c1c;padding:16px 20px;border-radius:12px;margin-bottom:24px;">
            <strong style="display:block;margin-bottom:6px;">⚠️ Please fix the following errors:</strong>
            <ul style="margin:0;padding-left:20px;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err); ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (!empty($success)): ?>
        <div style="background:#f0fdf4;border:1px solid #86efac;color:#166534;padding:16px 20px;border-radius:12px;margin-bottom:24px;">
            ✅ <?= htmlspecialchars($success); ?> Redirecting…
        </div>
    <?php endif; ?>

    <!-- Desktop Header -->
    <div class="flex justify-between items-end mb-8 border-b border-gray-200 pb-6">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight">
                <?= $isEdit ? 'Edit Recipe' : 'Create New Recipe'; ?>
            </h1>
            <p class="text-gray-500 text-lg">Draft and format your culinary masterpieces.</p>
        </div>
        <div class="flex gap-3">
            <a href="../manage-recipes.php" class="px-6 py-3 text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 transition font-medium">
                Cancel
            </a>
            <button type="submit" form="recipeForm" class="bg-orange-500 hover:bg-orange-600 text-white px-8 py-3 rounded-xl shadow-lg transition font-bold">
                <?= $isEdit ? 'Save Changes' : 'Publish Recipe'; ?>
            </button>
        </div>
    </div>

    <form id="recipeForm" method="POST" enctype="multipart/form-data" class="grid grid-cols-12 gap-8">
        
        <!-- Left Column: Main Editor (The "Word" Area) -->
        <div class="col-span-12 lg:col-span-8 space-y-6">
            
            <!-- Recipe Name Large Input -->
            <div class="bg-white p-2 rounded-2xl shadow-sm border border-gray-200">
                <input type="text" name="recipe_name" placeholder="Enter Recipe Title..." required
                       value="<?= htmlspecialchars($recipe['recipe_name'] ?? ''); ?>"
                       class="w-full text-2xl font-bold px-6 py-4 rounded-xl focus:outline-none focus:ring-2 focus:ring-orange-500/20">
            </div>

            <!-- Ingredients Editor -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <label class="font-bold text-gray-700 uppercase text-xs tracking-wider">Ingredients List</label>
                </div>
                <textarea name="ingredients" id="ingredients_editor"><?= htmlspecialchars($recipe['ingredients'] ?? ''); ?></textarea>
            </div>

            <!-- Instructions Editor -->
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                    <label class="font-bold text-gray-700 uppercase text-xs tracking-wider">Preparation Steps</label>
                </div>
                <textarea name="instructions" id="instructions_editor"><?= htmlspecialchars($recipe['instructions'] ?? ''); ?></textarea>
            </div>
        </div>

        <!-- Right Column: Sidebar (Metadata & Image) -->
        <div class="col-span-12 lg:col-span-4 space-y-6">
            
            <!-- Status & Category Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4 flex items-center gap-2">
                    <span class="w-2 h-2 bg-orange-500 rounded-full"></span> Details
                </h3>
                
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Category</label>
                        <input type="text" name="category" placeholder="e.g. Italian, Dessert"
                               value="<?= htmlspecialchars($recipe['category'] ?? ''); ?>"
                               class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-500/20 outline-none">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Time (Mins)</label>
                            <input type="text" name="cooking_time" placeholder="45"
                                   value="<?= htmlspecialchars($recipe['cooking_time'] ?? ''); ?>"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-500/20 outline-none">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-600 mb-1">Servings</label>
                            <input type="number" name="servings"
                                   value="<?= htmlspecialchars($recipe['servings'] ?? ''); ?>"
                                   class="w-full border border-gray-200 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-orange-500/20 outline-none">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-1">Visibility</label>
                        <select name="status" class="w-full border border-gray-200 rounded-lg px-4 py-2.5 outline-none">
                            <option value="Active" <?= (($recipe['status'] ?? '') == 'Active') ? 'selected' : ''; ?>>Public</option>
                            <option value="Inactive" <?= (($recipe['status'] ?? '') == 'Inactive') ? 'selected' : ''; ?>>Draft</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Featured Image Card -->
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-gray-800 mb-4">Recipe Image</h3>
                
                <div id="previewContainer" class="mb-4">
                    <?php if($isEdit && !empty($recipe['recipe_image'])): ?>
                        <img src="./uploads/recipes/<?= $recipe['recipe_image']; ?>" class="w-full h-48 object-cover rounded-xl border">
                    <?php else: ?>
                        <div class="w-full h-48 bg-gray-100 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-400">
                            No image selected
                        </div>
                    <?php endif; ?>
                </div>

                <label class="block">
                    <span class="sr-only">Choose photo</span>
                    <input type="file" name="recipe_image" id="imageInput" accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100 cursor-pointer">
                </label>
            </div>

        </div>
    </form>
</div>

<script>
    // Initialize MS Word-style editors
    const editorConfig = {
        toolbar: [ 'heading', '|', 'bold', 'italic', 'bulletedList', 'numberedList', 'blockQuote', 'undo', 'redo' ],
    };

    ClassicEditor.create(document.querySelector('#ingredients_editor'), editorConfig).catch(error => console.error(error));
    ClassicEditor.create(document.querySelector('#instructions_editor'), editorConfig).catch(error => console.error(error));

    // Image Preview Logic
    const imageInput = document.getElementById('imageInput');
    const previewContainer = document.getElementById('previewContainer');

    imageInput.addEventListener('change', function() {
        const file = this.files[0];
        if(file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewContainer.innerHTML = `<img src="${e.target.result}" class="w-full h-48 object-cover rounded-xl border shadow-sm">`;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</body>
</html>