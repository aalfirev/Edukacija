<?php

require_once 'dbconn.php';


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
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($news['naslov']) ?></title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="news-full-view">
        <figure>
            <img src="<?= htmlspecialchars($news['slika']) ?>" alt="Slika">
            <figcaption class="news-date">Datum: <?= $news['datum'] ?></figcaption>
        </figure>
        <div class="news-full-content">
            <h1><?= htmlspecialchars($news['naslov']) ?></h1>
            <p><?= htmlspecialchars($news['tekst']) ?></p>
        </div>
    </div>
    <a href="http://localhost/php/edukacija_II/index.php?menu=2" class="back-link">Natrag na novosti</a>
</body>
</html>

