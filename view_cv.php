<?php
require_once 'db.php';

// Getting the ID from the URL (e.g. view_cv.php?id=1)
$id = $_GET['id'] ?? null;

if (!$id) {
    die("Error: No CV ID provided.");
}

// Preparing the statement to prevent SQL Injection
$stmt = $pdo->prepare("SELECT * FROM cvs WHERE id = ?");
$stmt->execute([$id]);
$cv = $stmt->fetch();

if (!$cv) {
    die("Error: CV not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($cv['name']) ?> - CV Details</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 40px; background: #f9f9f9; }
        .cv-card { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); max-width: 600px; margin: 0 auto; }
        h1 { border-bottom: 2px solid #007bff; padding-bottom: 10px; }
        .label { font-weight: bold; color: #555; }
        .back-link { display: inline-block; margin-top: 20px; text-decoration: none; color: #007bff; }
    </style>
</head>
<body>

<div class="cv-card">
    <h1><?= htmlspecialchars($cv['name']) ?></h1>
    <p><span class="label">Email:</span> <?= htmlspecialchars($cv['email']) ?></p>
    <p><span class="label">Programming Languages:</span> <?= htmlspecialchars($cv['keyprogramming']) ?></p>
    
    <hr>
    
    <h3>Profile</h3>
    <p><?= nl2br(htmlspecialchars($cv['profile'] ?? 'No profile provided.')) ?></p>

    <h3>Education</h3>
    <p><?= nl2br(htmlspecialchars($cv['education'] ?? 'No education history provided.')) ?></p>

    <h3>Links</h3>
<p>
    <?php 
    $links = htmlspecialchars($cv['URLlinks'] ?? '');
    // This looks for anything starting with http and makes it a clickable link
    $clickableLinks = preg_replace(
        '~(https?://[^\s,]+)~', 
        '<a href="$1" target="_blank">$1</a>', 
        $links
    );
    echo nl2br($clickableLinks ?: 'No links provided.'); 
    ?>
</p>

    <a href="index.php" class="back-link">← Back to List</a>
</div>

</body>
</html>