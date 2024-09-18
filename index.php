<?php
session_start();
include 'config.php'; // Make sure to set up your DB connection in this file

$search = '';
$results = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $search = $_POST['search'];
    
    // Prepare and execute search query
    $stmt = $pdo->prepare("SELECT * FROM districts WHERE district LIKE ? OR commune LIKE ?");
    $stmt->execute(["%$search%", "%$search%"]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phnom Penh Districts and Communes</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
        }
        header {
            background-color: #4CAF50;
            color: white;
            padding: 15px;
            text-align: center;
        }
        h1 {
            margin: 0;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        form {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        input[type="text"] {
            padding: 10px;
            width: 70%;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            font-weight: 700;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .no-results {
            text-align: center;
            font-size: 18px;
            color: #777;
        }
    </style>
</head>
<body>

<header>
    <h1>Search Phnom Penh Districts and Communes</h1>
</header>

<div class="container">
    <form method="POST">
        <input type="text" name="search" placeholder="Enter district or commune..." value="<?= htmlspecialchars($search) ?>" required>
        <input type="submit" value="Search">
    </form>

    <?php if (!empty($results)): ?>
        <table>
            <tr>
                <th>District</th>
                <th>Commune</th>
            </tr>
            <?php foreach ($results as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['district']) ?></td>
                    <td><?= htmlspecialchars($row['commune']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p class="no-results">No results found.</p>
    <?php endif; ?>
</div>

</body>
</html>

