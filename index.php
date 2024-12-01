<?php

session_start();


$menu = isset($_GET['menu']) ? $_GET['menu'] : 1;

$bannerClass = $menu > 1 ? 'hero-subimage' : 'hero-image';


include("dbconn.php");


$is_admin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Web stranica koja nudi informatičku edukaciju i tečajeve prilagođene svima. Prijavite se i proširite svoja znanja!">
    <meta name="keywords" content="informatička edukacija, tečajevi, online učenje, IT edukacija, programiranje">
    <meta name="author" content="Ana Alfirev">
    <title>Informatička edukacija</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
   
    <header>
        <div class="<?php echo $bannerClass; ?>">
            <h1>Informatička edukacija<br>
            Najbolje mjesto za IT učenje i napredak</h1>
        </div>
    </header>

 
    <nav>
        <a href="index.php?menu=1" <?php if ($menu == 1) echo 'class="active"'; ?>>Početna stranica</a>
        <a href="index.php?menu=4" <?php if ($menu == 4) echo 'class="active"'; ?>>O nama</a>
        <a href="index.php?menu=2" <?php if ($menu == 2) echo 'class="active"'; ?>>Novosti</a>
       
      
        <a href="index.php?menu=5" <?php if ($menu == 5) echo 'class="active"'; ?>>Galerija</a>
        <a href="index.php?menu=3" <?php if ($menu == 3) echo 'class="active"'; ?>>Kontakt</a>
        <?php if (!isset($_SESSION['user_id'])) : ?>
            <a href="index.php?menu=6" <?php if ($menu == 6) echo 'class="active"'; ?>>Registracija</a>
            <a href="index.php?menu=7" <?php if ($menu == 7) echo 'class="active"'; ?>>Prijava</a>
        <?php else : ?>
            <?php if ($is_admin): ?>
                <a href="index.php?menu=8" <?php if ($menu == 8) echo 'class="active"'; ?>>Administracija</a>
            <?php endif; ?>
            <a href="logout.php">Odjava</a>
        <?php endif; ?>
    </nav>

 
    <main>
        <?php
       
        if ($menu == 1) {
            include("pocetna.php");
        } elseif ($menu == 2) {
            include("novosti.php");
        } elseif ($menu == 3) {
            include("kontakt.php");
        } elseif ($menu == 4) {
            include("onama.php");
        } elseif ($menu == 5) {
            include("galerija.php");
        } elseif ($menu == 6) {
            include("registracija.php");
        } elseif ($menu == 7) {
            include("prijava.php");
        } elseif ($menu == 8 && $is_admin) {
            include("admin.php");
        } else {
            echo '<p>Tražena stranica nije dostupna.</p>';
        }
        ?>
    </main>

  
    <footer>

    <p>&copy; 2024 Ana Alfirev. Sva prava pridržana. <a href="https://github.com/aalfirev?tab=repositories" title="Github">
        <i class="fab fa-github"></i>
    </a></p>
        
        <p>
            <a href="#" title="LinkedIn" style="margin-right: 10px;">
                <i class="fab fa-linkedin"></i>
            </a>
            <a href="#" title="Twitter" style="margin-right: 10px;">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" title="Instagram">
                <i class="fab fa-instagram"></i>
            </a>
        </p>
    </footer>
</body>
</html>
