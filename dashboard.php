<?php
session_start();
require_once 'db.php';

// Authorization: If not logged in, redirect to login page
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$message = '';

// Handling the Update form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $profile = $_POST['profile'] ?? '';
    $education = $_POST['education'] ?? '';
    $links = $_POST['URLlinks'] ?? '';

    // Security: Prepared Statements to handle injections
    $sql = "UPDATE cvs SET profile = ?, education = ?, URLlinks = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    if ($stmt->execute([$profile, $education, $links, $user_id])) {
        $message = "CV updated successfully!";
    } else {
        $message = "Error updating CV.";
    }
}

// Fetching current user data to pre-fill the form
$stmt = $pdo->prepare("SELECT * FROM cvs WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Update CV</title>
    <style>
        body { font-family: sans-serif; padding: 40px; background: #f8f9fa; }
        .container { max-width: 700px; margin: auto; background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        textarea { width: 100%; height: 120px; margin-bottom: 15px; padding: 10px; border: 1px solid #ccc; border-radius: 4px; font-family: inherit; }
        label { font-weight: bold; display: block; margin-top: 10px; }
        .btn { background: #007bff; color: white; padding: 10px 20px; border: none; cursor: pointer; border-radius: 5px; font-size: 16px; }
        .nav { margin-bottom: 20px; border-bottom: 1px solid #eee; padding-bottom: 10px; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <strong>Welcome, <?= htmlspecialchars($user['name']) ?></strong> | 
        <a href="index.php">View Public List</a> | 
        <a href="logout.php">Logout</a>
    </div>

    <h1>Update Your CV Details</h1>
    
    <?php if ($message): ?>
        <p style="color: green; font-weight: bold;"><?= $message ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Personal Profile:</label>
        <textarea name="profile" placeholder="Tell us about yourself..."><?= htmlspecialchars($user['profile'] ?? '') ?></textarea>

        <label>Education History:</label>
        <textarea name="education" placeholder="List your degrees and schools..."><?= htmlspecialchars($user['education'] ?? '') ?></textarea>

        <label>Important Links (e.g., GitHub, LinkedIn):</label>
        <textarea name="URLlinks" placeholder="https://github.com/yourprofile"><?= htmlspecialchars($user['URLlinks'] ?? '') ?></textarea>

        <button type="submit" class="btn">Save Changes</button>
    </form>
</div>

</body>
</html>