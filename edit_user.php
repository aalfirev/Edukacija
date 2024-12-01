<?php
require_once 'dbconn.php';


if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}


if (isset($_GET['id'])) {
    $user_id = (int)$_GET['id'];
    $query = "SELECT * FROM users WHERE id = $user_id";
    $result = mysqli_query($MySQL, $query);

    if ($result && mysqli_num_rows($result) === 1) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Korisnik nije pronađen.</p>";
        exit;
    }
} else {
    echo "<p>Nevažeći ID korisnika.</p>";
    exit;
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = mysqli_real_escape_string($MySQL, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($MySQL, $_POST['last_name']);
    $email = mysqli_real_escape_string($MySQL, $_POST['email']);
    $username = mysqli_real_escape_string($MySQL, $_POST['username']);
    $role = mysqli_real_escape_string($MySQL, $_POST['role']);

    $update_query = "UPDATE users SET 
                     first_name = '$first_name', 
                     last_name = '$last_name', 
                     email = '$email', 
                     username = '$username', 
                     role = '$role' 
                     WHERE id = $user_id";

    if (mysqli_query($MySQL, $update_query)) {
        header("Location: http://localhost/php/edukacija_II/index.php?menu=8");
        exit;
    } else {
        echo "<p>Greška prilikom ažuriranja korisnika: " . mysqli_error($MySQL) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Uredi korisnika</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h2>Uredi korisnika</h2>
    <form action="edit_user.php?id=<?php echo $user_id; ?>" method="POST">
        <label for="first_name">Ime:</label>
        <input type="text" id="first_name" name="first_name" value="<?php echo htmlspecialchars($user['first_name']); ?>" required>

        <label for="last_name">Prezime:</label>
        <input type="text" id="last_name" name="last_name" value="<?php echo htmlspecialchars($user['last_name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="username">Korisničko ime:</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>

        <label for="role">Rola:</label>
        <select id="role" name="role" required>
            <option value="user" <?php echo $user['role'] === 'user' ? 'selected' : ''; ?>>Korisnik</option>
            <option value="editor" <?php echo $user['role'] === 'editor' ? 'selected' : ''; ?>>Editor</option>
            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>Administrator</option>
        </select>

        <button type="submit">Spremi promjene</button>
    </form>
</body>
</html>
