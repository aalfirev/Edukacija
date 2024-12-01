<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit;
}

include("dbconn.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $first_name = mysqli_real_escape_string($MySQL, $_POST['first_name']);
    $last_name = mysqli_real_escape_string($MySQL, $_POST['last_name']);
    $email = mysqli_real_escape_string($MySQL, $_POST['email']);
    $username = mysqli_real_escape_string($MySQL, $_POST['username']);
    $role = mysqli_real_escape_string($MySQL, $_POST['role']);
    $password = password_hash('default123', PASSWORD_DEFAULT); // Default lozinka

    $query = "INSERT INTO users (first_name, last_name, email, username, role, password) 
              VALUES ('$first_name', '$last_name', '$email', '$username', '$role', '$password')";
    if (mysqli_query($MySQL, $query)) {
        echo "<p class='success-message'>Korisnik uspješno dodan!</p>";
    } else {
        echo "<p class='error-message'>Greška: " . mysqli_error($MySQL) . "</p>";
    }
}


$query = "SELECT id, first_name, last_name, email, username, role FROM users";
$result = mysqli_query($MySQL, $query);
?>
<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administracija korisnika</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
   

    <main>
     

        <form action="" method="POST" class="admin-form">
            <h2>Dodaj novog korisnika</h2>
            <label for="first_name">Ime:</label>
            <input type="text" id="first_name" name="first_name" placeholder="Ime" required>

            <label for="last_name">Prezime:</label>
            <input type="text" id="last_name" name="last_name" placeholder="Prezime" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Email" required>

            <label for="username">Korisničko ime:</label>
            <input type="text" id="username" name="username" placeholder="Korisničko ime" required>

            <label for="role">Rola:</label>
            <select id="role" name="role" required>
                <option value="user">Korisnik</option>
                <option value="editor">Editor</option>
                <option value="admin">Administrator</option>
            </select>

            <button type="submit" name="add_user">Dodaj korisnika</button>
        </form>

       
        <section class="admin-user-list">
            <h2>Popis korisnika</h2>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Ime</th>
                        <th>Prezime</th>
                        <th>Email</th>
                        <th>Korisničko ime</th>
                        <th>Rola</th>
                        <th>Akcije</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($user = mysqli_fetch_assoc($result)) : ?>
                        <tr>
                            <td><?php echo $user['id']; ?></td>
                            <td><?php echo $user['first_name']; ?></td>
                            <td><?php echo $user['last_name']; ?></td>
                            <td><?php echo $user['email']; ?></td>
                            <td><?php echo $user['username']; ?></td>
                            <td><?php echo $user['role']; ?></td>
                            <td>
                                <a href="edit_user.php?id=<?php echo $user['id']; ?>">Uredi</a> |
                                <a href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Jeste li sigurni da želite obrisati ovog korisnika?')">Obriši</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

   
</body>
</html>
