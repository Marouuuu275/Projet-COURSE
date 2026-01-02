<?php
session_start();
require_once "pdo.php";

// Récupérer les profils depuis la base
$stmt = $pdo->query("SELECT profile_id, first_name, last_name, headline FROM users JOIN Profile ON users.user_id = Profile.user_id");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>RHAFOUR Maroua</title> <!-- Titre exact demandé par WA4E -->
    <link rel="stylesheet" href="starter-template.css"> <!-- CSS -->
</head>
<body>
<div class="container">
    <h2>Welcome to My Resume Registry</h2>

    <?php
    // Lien de déconnexion si connecté
    if (isset($_SESSION['name'])) {
        echo '<p><a href="logout.php">Logout</a></p>';
    }

    // Message de succès
    if (isset($_SESSION['success'])) {
        echo('<p style="color: green;">' . htmlentities($_SESSION['success']) . "</p>\n");
        unset($_SESSION['success']);
    }
    ?>

    <?php
    // Lien "Please log in" si pas connecté
    if (!isset($_SESSION['name'])) {
        echo "<p><a href='login.php'>Please log in</a></p>";
    }
    ?>

    <?php
    if (count($rows) > 0) {
        echo "<table border='1'>";
        echo "<thead><tr><th>Name</th><th>Headline</th>";
        if (isset($_SESSION['name'])) {
            echo "<th>Action</th>";
        }
        echo "</tr></thead><tbody>";

        foreach ($rows as $row) {
            echo "<tr>";
            echo "<td><a href='view.php?profile_id=" . $row['profile_id'] . "'>" . 
                 htmlentities($row['first_name'] . " " . $row['last_name']) . "</a></td>";
            echo "<td>" . htmlentities($row['headline']) . "</td>";
            if (isset($_SESSION['name'])) {
                echo "<td>";
                echo '<a href="edit.php?profile_id=' . $row['profile_id'] . '">Edit</a> / ';
                echo '<a href="delete.php?profile_id=' . $row['profile_id'] . '">Delete</a>';
                echo "</td>";
            }
            echo "</tr>";
        }

        echo "</tbody></table>";
    } else {
        echo "<p>No rows found</p>";
    }
    ?>

    <?php
    // Lien pour ajouter un profil si connecté
    if (isset($_SESSION['name'])) {
        echo '<p><a href="add.php">Add New Entry</a></p>';
    }
    ?>

    <p><b>Note:</b> Your implementation should retain data across multiple logout/login sessions.</p>
</div>
</body>
</html>
