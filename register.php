<?php
require_once 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $keyprog = $_POST['keyprogramming'] ?? '';

    // Basic Form Validation (Security Measure1)
    if (empty($name) || empty($email) || empty($password)) {
        $message = "Please fill in all required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } else {
        // Hashing the password (Security Measure2)
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        try {
            // Using Prepared Statements (Security Measure3)
            $sql = "INSERT INTO cvs (name, email, password, keyprogramming) VALUES (?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$name, $email, $hashedPassword, $keyprog]);
            
            $message = "Registration successful! <a href='login.php'>Login here</a>";
        } catch (PDOException $e) {
            if ($e->getCode() == 23000) { // Duplicating entry error code
                $message = "Error: That email is already registered.";
            } else {
                $message = "Error: " . $e->getMessage();
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CV System</title>
    <style>
        body { font-family: sans-serif; padding: 40px; }
        form { max-width: 400px; margin: auto; display: flex; flex-direction: column; gap: 10px; }
        input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        .btn { background: #28a745; color: white; border: none; cursor: pointer; padding: 10px; }
        .msg { color: #d9534f; font-weight: bold; text-align: center; }
    </style>
</head>
<body>

    <form method="POST">
        <h2>Create an Account</h2>
        <?php if ($message): ?>
            <div class="msg"><?= $message ?></div>
        <?php endif; ?>

        <input type="text" name="name" placeholder="Full Name" required>
        <input type="email" name="email" placeholder="Email Address" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="text" name="keyprogramming" placeholder="Primary Programming Language (e.g. PHP, Java)">
        <button type="submit" class="btn">Register</button>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </form>

</body>
</html>