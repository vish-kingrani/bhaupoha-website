<?php
include 'includes/db_config.php';

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $target_user = trim($_POST['target_username']);
    $new_pass = trim($_POST['new_password']);

    // Validation
    if (empty($target_user) || empty($new_pass)) {
        $message = "<div class='alert alert-warning'>⚠️ All fields are required.</div>";
    } elseif (strlen($new_pass) < 6) {
        $message = "<div class='alert alert-warning'>⚠️ Password must be at least 6 characters.</div>";
    } else {

        $hashed_password = password_hash($new_pass, PASSWORD_DEFAULT);

        try {
            $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $stmt->execute([$hashed_password, $target_user]);

            if ($stmt->rowCount() > 0) {
                $message = "<div class='alert alert-success'>
                                ✅ Password for <b>$target_user</b> updated successfully!
                            </div>";
            } else {
                $message = "<div class='alert alert-danger'>
                                ❌ User not found or password already same.
                            </div>";
            }

        } catch (PDOException $e) {
            $message = "<div class='alert alert-danger'>
                            ❌ Error: " . $e->getMessage() . "
                        </div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Reset Password</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
    body {
        background: linear-gradient(135deg, #667eea, #764ba2);
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 15px;
        backdrop-filter: blur(10px);
    }
</style>
</head>

<body>

<div class="card shadow p-4" style="width: 350px;">
    <h4 class="text-center mb-3">🔐 Reset Admin Password</h4>

    <div class="alert alert-warning small">
        ⚠️ Delete this file after use for security!
    </div>

    <!-- Message -->
    <?php echo $message; ?>

    <form method="POST">
        <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="target_username" class="form-control" placeholder="admin" required>
        </div>

        <div class="mb-3">
            <label class="form-label">New Password</label>
            <input type="password" name="new_password" class="form-control" placeholder="Enter new password" required>
        </div>

        <button type="submit" class="btn btn-success w-100">
            Update Password
        </button>
    </form>

    <div class="text-center mt-3">
        <a href="login.php" class="text-decoration-none">← Back to Login</a>
    </div>
</div>

</body>
</html>