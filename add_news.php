<?php
require_once 'dbconn.php';

// Provjera
if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'editor'])) {
    echo "<p>Nemate dopuštenje za pristup ovoj stranici.</p>";
    exit;
}

// Obrada 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($MySQL, $_POST['title']);
    $content = mysqli_real_escape_string($MySQL, $_POST['content']);
    $date = date('Y-m-d H:i:s');
    $archive = isset($_POST['archive']) ? 1 : 0;

    // slika
    $image_path = '';
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $image_path = $target_dir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    $query = "INSERT INTO novosti (naslov, tekst, datum, arhiva, slika) 
              VALUES ('$title', '$content', '$date', $archive, '$image_path')";
    if (mysqli_query($MySQL, $query)) {
        echo "<p>Novost je uspješno dodana!</p>";
        header("Location: http://localhost/php/edukacija_II/index.php?menu=2");
        exit;
    } else {
        echo "<p>Greška prilikom dodavanja novosti: " . mysqli_error($MySQL) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dodaj novu novost</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Dodaj novu novost</h2>
    <form action="add_news.php" method="POST" enctype="multipart/form-data">
        <label for="title">Naslov:</label>
        <input type="text" name="title" id="title" required>
        <label for="content">Sadržaj:</label>
        <textarea name="content" id="content" rows="5" required></textarea>
        <label for="image">Slika:</label>
        <input type="file" name="image" id="image" required>
        <label>
            <input type="checkbox" name="archive"> Arhiviraj
        </label>
        <button type="submit">Dodaj novost</button>
    </form>
</body>
</html>
