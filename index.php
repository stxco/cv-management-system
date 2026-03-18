<?php
session_start();
require_once 'db.php';

$search = $_GET['search'] ?? '';
$cvs = [];

if (!empty($search)) {
    // Security: Using Prepared Statements for Search to prevent SQL Injection
    $sql = "SELECT id, name, email, keyprogramming FROM cvs 
            WHERE name LIKE ? OR keyprogramming LIKE ?";
    $stmt = $pdo->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->execute([$searchTerm, $searchTerm]);
    $cvs = $stmt->fetchAll();
} else {
    // If no search, then show everyone
    $stmt = $pdo->query("SELECT id, name, email, keyprogramming FROM cvs");
    $cvs = $stmt->fetchAll();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CV Directory</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; line-height: 1.6; padding: 20px; background-color: #f4f4f9; color: #333; }
        .container { max-width: 900px; margin: auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #007bff; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .btn { padding: 6px 12px; background: #007bff; color: white; text-decoration: none; border-radius: 4px; font-size: 14px; }
        .search-box { margin-bottom: 20px; display: flex; gap: 10px; }
        .search-box input { flex-grow: 1; padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        nav { margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
    </style>
</head>
<body>

<div class="container">
    <h1>CV Directory</h1>
    <nav>
    <a href="index.php">Home</a> | 
    <?php if (isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">My Dashboard</a> | 
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="register.php">Register</a> | 
        <a href="login.php">Login</a>
    <?php endif; ?>
</nav>

    <form class="search-box" method="GET" action="index.php">
        <input type="text" name="search" placeholder="Search by name or programming language..." value="<?= htmlspecialchars($search) ?>">
        <button type="submit" class="btn">Search</button>
    </form>

    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Key Programming Language</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cvs as $cv): ?>
            <tr>
                <td><?= htmlspecialchars($cv['name']) ?></td>
                <td><?= htmlspecialchars($cv['email']) ?></td>
                <td><?= htmlspecialchars($cv['keyprogramming']) ?></td>
                <td><a class="btn" href="view_cv.php?id=<?= $cv['id'] ?>">View Details</a></td>
            </tr>
            <?php endforeach; ?>
            
            <?php if (empty($cvs)): ?>
            <tr><td colspan="4" style="text-align:center;">No records found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

</body>
</html>