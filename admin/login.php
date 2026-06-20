<?php
session_start();
include 'includes/db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "❌ Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Bhau Poha Admin Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Tailwind Custom Animation -->
    <style>
        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }
    </style>

</head>

<body class="h-screen flex items-center justify-center bg-cover bg-center"
    style="background-image: url('https://images.unsplash.com/photo-1515003197210-e0cd71810b5f?q=80&w=1600&auto=format&fit=crop');">

    <!-- Dark Overlay -->
    <div class="absolute inset-0 bg-black/60"></div>

    <div class="relative w-full max-w-md p-8 bg-white/10 backdrop-blur-xl rounded-2xl shadow-2xl border border-white/20 animate-float">

        <div class="text-center mb-6">
            <img src="https://cdn-icons-png.flaticon.com/512/139/139899.png" class="w-16 mx-auto mb-3">
            <h2 class="text-3xl font-bold text-white">Login</h2>
            <p class="text-gray-200 text-sm">Welcome back, please login</p>
        </div>

        <!-- Error -->
        <?php if (isset($error)) { ?>
            <div class="bg-red-500/20 text-red-300 p-3 rounded mb-4 text-center font-semibold">
                <?php echo $error; ?>
            </div>
        <?php } ?>

        <!-- Login Form -->
        <form method="POST" class="space-y-4">

            <div>
                <input type="text" name="username" required
                    placeholder="👤 Username"
                    class="w-full p-3 rounded-lg bg-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <input type="password" name="password" required
                    placeholder="🔑 Password"
                    class="w-full p-3 rounded-lg bg-white/20 text-white placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400">
            </div>

            <button type="submit"
                class="w-full py-3 bg-gradient-to-r from-blue-500 to-purple-600 text-white font-bold rounded-lg shadow-lg hover:scale-105 transition transform duration-300">
                Login to Dashboard
            </button>
        </form>

        <!-- Footer -->
        <p class="text-center text-gray-300 text-xs mt-6">
            © <?php echo date('Y'); ?> Admin Panel
        </p>

    </div>

</body>

</html>