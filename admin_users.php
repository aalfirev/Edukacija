
<?php

require_once 'dbconn.php';


session_start();


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: signin.php');
    exit;
}


$sql = "SELECT id, username, email, role, is_active FROM users";
$result = $conn->query($sql);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newRole = $_POST['role'];
    $isActive = isset($_POST['is_active']) ? 1 : 0;

    $updateSql = "UPDATE users SET role = ?, is_active = ? WHERE id = ?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param('sii', $newRole, $isActive, $userId);

    if ($stmt->execute()) {
        echo '<p>User updated successfully!</p>';
    } else {
        echo '<p>Error updating user.</p>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - User Management</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>User Management</h1>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Email</th>
            <th>Role</th>
            <th>Active</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= $row['username'] ?></td>
            <td><?= $row['email'] ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['is_active'] ? 'Yes' : 'No' ?></td>
            <td>
                <form method="POST">
                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                    <select name="role">
                        <option value="user" <?= $row['role'] === 'user' ? 'selected' : '' ?>>User</option>
                        <option value="editor" <?= $row['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
                        <option value="admin" <?= $row['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                    </select>
                    <label>
                        <input type="checkbox" name="is_active" <?= $row['is_active'] ? 'checked' : '' ?>> Active
                    </label>
                    <button type="submit">Update</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>
