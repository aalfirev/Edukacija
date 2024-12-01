<?php

require_once 'dbconn.php';


if (!isset($_SESSION['role']) || !in_array($_SESSION['role'], ['admin', 'editor'])) {
    echo "<p>Nemate dopuštenje za pristup ovoj stranici.</p>";
    exit;
}


if (isset($_GET['id'])) {
    $news_id = (int)$_GET['id'];
    $query = "SELECT * FROM novosti WHERE id = $news_id";
    $result = mysqli_query($MySQL, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $news = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Novost nije pronađena.</p>";
        exit;
    }
} else {
    echo "<p>Nevažeći ID novosti.</p>";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = mysqli_real_escape_string($MySQL, $_POST['title']);
    $content = mysqli_real_escape_string($MySQL, $_POST['content']);
    $archive = isset($_POST['archive']) ? 1 : 0;


    $image_path = $news['slika']; 
    if (!empty($_FILES['image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true); 
        }
        $image_path = $target_dir . basename($_FILES['image']['name']);

        
        $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
        if (in_array($_FILES['image']['type'], $allowed_types) && move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
         
        } else {
            echo "<p>Slika nije uspješno prenesena. Provjerite format datoteke.</p>";
        }
    }


    $update_query = "UPDATE novosti SET naslov = '$title', tekst = '$content', arhiva = $archive, slika = '$image_path' WHERE id = $news_id";
    if (mysqli_query($MySQL, $update_query)) {
        echo "<p>Novost je uspješno ažurirana!</p>";
        header("Location: http://localhost/php/edukacija_II/index.php?menu=2");
        exit;
    } else {
        echo "<p>Greška prilikom ažuriranja novosti: " . mysqli_error($MySQL) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi novost</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Uredi novost</h2>
    <form action="edit_news.php?id=<?= $news_id ?>" method="POST" enctype="multipart/form-data">
        <label for="title">Naslov:</label>
        <input type="text" name="title" id="title" value="<?= htmlspecialchars($news['naslov']) ?>" required>
        <label for="content">Sadržaj:</label>
        <textarea name="content" id="content" rows="5" required><?= htmlspecialchars($news['tekst']) ?></textarea>
        <label for="image">Promijeni sliku:</label>
        <input type="file" name="image" id="image">
        <label>
            <input type="checkbox" name="archive" <?= $news['arhiva'] ? 'checked' : '' ?>> Arhiviraj
        </label>
        <button type="submit">Spremi promjene</button>
    </form>
</body>
</html>
