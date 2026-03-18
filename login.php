<?php
require_once 'db.php';
session_start(); // Starting the session to keep the user logged in

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!empty($email) && !empty($password)) {
        // Preparing statement to find the user by email
        $stmt = $pdo->prepare("SELECT * FROM cvs WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        // Security Measure: Verifying the hashed password
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header("Location: dashboard.php"); // Send them to their private update page
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - CV System</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #f4f7f6; }
        form { max-width: 350px; margin: auto; background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        input { width: 100%; padding: 10px; margin: 10px 0; border: 1px solid #ddd; box-sizing: border-box; }
        .btn { width: 100%; padding: 10px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; text-align: center; margin-bottom: 10px; }
    </style>
</head>
<body>

    <form method="POST">
        <h2 style="text-align:center;">Login</h2>
        <?php if ($message): ?>
            <p class="error"><?= $message ?></p>
        <?php endif; ?>
        
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit" class="btn">Login</button>
        <p style="text-align:center;">No account? <a href="register.php">Register here</a></p>
    </form>

</body>
</html>