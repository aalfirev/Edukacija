<?php
require_once 'dbconn.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role'])) {
    $_SESSION['role'] = 'viewer'; 
}


$canEdit = in_array($_SESSION['role'], ['admin', 'editor']);


if ($canEdit && isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id']; 
    $delete_query = "DELETE FROM novosti WHERE id = $delete_id";

    if (mysqli_query($MySQL, $delete_query)) {
        header("Location: http://localhost/php/edukacija_II/index.php?menu=2"); 
        exit;
    } else {
        echo "<p>Greška prilikom brisanja novosti: " . mysqli_error($MySQL) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novosti</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<?php if ($canEdit): ?>
    <a href="add_news.php" class="add-news-btn">Dodaj novu novost</a>
<?php endif; ?>
    
    <main>
        <div class="news-container">
            <?php
          
            $query = "SELECT * FROM novosti WHERE arhiva = 0 ORDER BY datum DESC";
            $result = mysqli_query($MySQL, $query);

            while ($novost = mysqli_fetch_assoc($result)) {
                echo '
                <div class="news-card">
                    <img src="' . htmlspecialchars($novost['slika']) . '" alt="Slika" class="news-image">
                    <div class="news-content">
                        <h3><a href="view_news.php?id=' . $novost['id'] . '">' . htmlspecialchars($novost['naslov']) . '</a></h3>
                        <p class="news-date">Datum: ' . $novost['datum'] . '</p>
                        <p class="news-archive">Arhiva: ' . ($novost['arhiva'] ? 'Da' : 'Ne') . '</p>
                    </div>';

                if ($canEdit) {
                    echo '
                    <div class="news-actions">
                        <a href="edit_news.php?id=' . $novost['id'] . '">Uredi</a> |
                        <a href="novosti.php?delete_id=' . $novost['id'] . '" onclick="return confirm(\'Jeste li sigurni?\')">Obriši</a>
                    </div>';
                }

                echo '</div>';
            }
            ?>
        </div>
    </main>
</body>
</html>
