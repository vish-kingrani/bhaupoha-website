<?php
include '../includes/auth_check.php';
include '../includes/db_config.php';

$errors = [];
$success = "";
$max_total_images = 100;
$max_file_size = 4 * 1024 * 1024; // 4MB

// 1. Path Setup
$upload_dir = "../uploads/gallery/";

if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// 2. Check current image count
$countStmt = $pdo->query("SELECT COUNT(id) FROM gallery");
$current_count = $countStmt->fetchColumn();

// 3. Handle Multi-Upload
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['images'])) {
    $files = $_FILES['images'];
    
    // Filter out any empty entries in the array
    $file_names = array_filter($files['name']);
    $uploaded_count = count($file_names); 

    if ($uploaded_count === 0) {
        $errors[] = "Please select at least one image.";
    } elseif (($current_count + $uploaded_count) > $max_total_images) {
        $errors[] = "Limit exceeded! You can only upload " . ($max_total_images - $current_count) . " more images.";
    } else {
        foreach ($files['name'] as $key => $name) {
            if (empty($name)) continue;

            $tmp_name = $files['tmp_name'][$key];
            $size = $files['size'][$key];
            $error_code = $files['error'][$key];
            
            // Check for PHP system upload errors
            if ($error_code !== UPLOAD_ERR_OK) {
                $errors[] = "System error uploading '$name'. Error Code: $error_code";
                continue;
            }

            // Validate it's actually an image
            $check = @getimagesize($tmp_name);
            if($check === false) {
                $errors[] = "File '$name' is not a valid image.";
                continue;
            }

            if ($size > $max_file_size) {
                $errors[] = "File '$name' is too large (Max 4MB).";
                continue;
            }

            $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $new_name = "IMG_" . uniqid() . "." . $ext;
            $target_file = $upload_dir . $new_name;

            if (move_uploaded_file($tmp_name, $target_file)) {
                $stmt = $pdo->prepare("INSERT INTO gallery (image_name) VALUES (?)");
                $stmt->execute([$new_name]);
            } else {
                $errors[] = "Could not save '$name'. Check folder permissions.";
            }
        }
        
        if (empty($errors)) {
            $success = "Images uploaded successfully!";
            // Redirect to prevent form resubmission on refresh
            header("Refresh:1; url=manage-gallery.php"); 
        }
    }
}

// 4. Handle Delete
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("SELECT image_name FROM gallery WHERE id = ?");
    $stmt->execute([$id]);
    $img = $stmt->fetch();

    if ($img) {
        $file_path = $upload_dir . $img['image_name'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
        $pdo->prepare("DELETE FROM gallery WHERE id = ?")->execute([$id]);
        header("Location: manage-gallery.php");
        exit();
    }
}

// 5. Handle Delete All
if (isset($_POST['delete_all'])) {
    $stmt = $pdo->query("SELECT image_name FROM gallery");
    while ($img = $stmt->fetch()) {
        $file_path = $upload_dir . $img['image_name'];
        if (file_exists($file_path)) unlink($file_path);
    }
    $pdo->query("TRUNCATE TABLE gallery");
    header("Location: manage-gallery.php");
    exit();
}

$images = $pdo->query("SELECT * FROM gallery ORDER BY id DESC")->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Construction Gallery Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .preview-img { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.9); } to { opacity: 1; transform: scale(1); } }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 min-h-screen p-6">

    <div class="max-w-7xl mx-auto">
        <div class="flex justify-between items-center mb-6 gap-3">
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Gallery Management</h2>
            <a href="../dashboard.php" class="bg-black text-white px-4 py-2 rounded shadow hover:bg-gray-800">⬅ Dashboard</a>
        </div>

        <?php
        $total = count($images);
        $percent = ($max_total_images > 0) ? ($total / $max_total_images) * 100 : 0;
        ?>
        <div class="mb-4">
            <div class="flex justify-between text-sm font-semibold">
                <span>Storage: <?php echo $total; ?>/<?php echo $max_total_images; ?> Images</span>
                <span><?php echo round($percent); ?>%</span>
            </div>
            <div class="w-full bg-gray-300 rounded h-3 mt-1">
                <div class="bg-green-500 h-3 rounded transition-all duration-500" style="width: <?php echo $percent; ?>%"></div>
            </div>
        </div>

        <?php if (!empty($errors)): ?>
            <div class="bg-red-100 border-l-4 border-red-600 text-red-700 p-4 mb-4 rounded">
                <?php foreach ($errors as $error) echo "<p>⚠ $error</p>"; ?>
            </div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="bg-green-100 border-l-4 border-green-600 text-green-700 p-4 mb-4 rounded">
                ✅ <?php echo $success; ?>
            </div>
        <?php endif; ?>

        <div class="bg-white p-6 rounded-xl shadow-lg mb-8">
            <h3 class="text-xl font-bold mb-3">📤 Upload Photos</h3>
            <form method="POST" enctype="multipart/form-data">
                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-blue-400 rounded-xl cursor-pointer bg-blue-50 hover:bg-blue-100 transition">
                    <i class="fa fa-cloud-upload-alt text-4xl text-blue-500 mb-2"></i>
                    <p class="text-gray-600 font-semibold">Click or Drag Images (Hold Ctrl to select multiple)</p>
                    <input type="file" name="images[]" id="imageInput" multiple class="hidden">
                </label>

                <div id="previewContainer" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mt-4"></div>

                <button type="submit" class="mt-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2 rounded-lg shadow hover:scale-105 transition">
                    Start Upload
                </button>
            </form>
        </div>

        <div class="flex justify-between mb-4">
            <h3 class="text-xl font-bold mb-3">🖼 Gallery (<?php echo $total; ?>)</h3>
            <?php if ($total > 0): ?>
                <form method="POST" onsubmit="return confirm('Delete everything?')">
                    <button type="submit" name="delete_all" class="bg-red-50 text-red-600 px-4 py-2 rounded border border-red-200 hover:bg-red-600 hover:text-white transition text-sm font-semibold">
                        <i class="fas fa-trash-sweep mr-2"></i> Delete All
                    </button>
                </form>
            <?php endif; ?>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-5">
            <?php foreach ($images as $index => $img): ?>
                <div class="relative group bg-white rounded-xl shadow-lg overflow-hidden hover:scale-105 transition">
                    <img src="../uploads/gallery/<?php echo htmlspecialchars($img['image_name']); ?>"
                        onclick="openLightbox(<?php echo $index; ?>)"
                        class="h-40 w-full object-cover cursor-pointer">
                    <a href="?delete=<?php echo $img['id']; ?>"
                        onclick="event.stopPropagation(); return confirm('Delete this image?')"
                        class="absolute top-2 right-2 bg-red-600 text-white px-3 py-1 rounded-full text-sm opacity-0 group-hover:opacity-100 transition">
                        <i class="fa fa-trash"></i>
                    </a>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div id="lightbox" class="fixed inset-0 z-50 hidden bg-black bg-opacity-90 flex items-center justify-center p-4">
        <button onclick="closeLightbox()" class="absolute top-5 right-5 text-white text-4xl">&times;</button>
        <button onclick="prevImage()" class="absolute left-5 text-white text-5xl"><i class="fas fa-chevron-left"></i></button>
        <img id="lightboxImg" src="" class="max-h-full max-w-full rounded shadow-2xl transition-all duration-300">
        <button onclick="nextImage()" class="absolute right-5 text-white text-5xl"><i class="fas fa-chevron-right"></i></button>
    </div>

    <script>
        const imagesData = <?php echo json_encode(array_values($images)); ?>;
        let currentIndex = 0;
        const lightbox = document.getElementById('lightbox');
        const lightboxImg = document.getElementById('lightboxImg');

        function openLightbox(index) {
            currentIndex = index;
            updateLightbox();
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeLightbox() {
            lightbox.classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function updateLightbox() {
            if(imagesData[currentIndex]) {
                lightboxImg.src = "../uploads/gallery/" + imagesData[currentIndex].image_name;
            }
        }

        function nextImage() { currentIndex = (currentIndex + 1) % imagesData.length; updateLightbox(); }
        function prevImage() { currentIndex = (currentIndex - 1 + imagesData.length) % imagesData.length; updateLightbox(); }

        const imageInput = document.getElementById('imageInput');
        const previewContainer = document.getElementById('previewContainer');

        imageInput.addEventListener('change', function() {
            previewContainer.innerHTML = '';
            Array.from(this.files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = "relative group rounded-lg overflow-hidden border-2 border-blue-200 preview-img";
                    div.innerHTML = `<img src="${e.target.result}" class="h-24 w-full object-cover">`;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        });

        document.addEventListener('keydown', (e) => {
            if (lightbox.classList.contains('hidden')) return;
            if (e.key === "ArrowRight") nextImage();
            if (e.key === "ArrowLeft") prevImage();
            if (e.key === "Escape") closeLightbox();
        });
    </script>
</body>
</html>