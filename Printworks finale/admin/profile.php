<?php
session_start();
require '../components/connection.php'; // your PDO connection

// Check if user is logged in
$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header('Location: dashboard.php');
    exit();
}

// Fetch current admin info
$stmt = $conn->prepare("SELECT name, email, password, profile FROM admin WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$admin) {
    die("Admin not found!");
}

$errors = [];
$success = "";

if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'] ?? '';
    $profile_pic = $_FILES['profile_pic'] ?? null;

    // Validation
    if (empty($name)) $errors[] = "Name is required";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Valid email required";

    // Prepare SQL for update
    $sql = "UPDATE admin SET name = :name, email = :email";
    $params = ['name' => $name, 'email' => $email];

    if (!empty($password)) {
        $sql .= ", password = :password";
        $params['password'] = password_hash($password, PASSWORD_DEFAULT);
    }

    // Handle profile picture
    if ($profile_pic && !empty($profile_pic['name'])) {
        $target_dir = '../image/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0755, true);

        $ext = pathinfo($profile_pic['name'], PATHINFO_EXTENSION);
        $new_filename = "profile_" . $admin_id . "." . $ext;
        $target_file = $target_dir . $new_filename;

        if (move_uploaded_file($profile_pic['tmp_name'], $target_file)) {
            $sql .= ", profile = :profile";
            $params['profile'] = $new_filename;

            // Delete old profile picture if exists and different
            if (!empty($admin['profile']) && $admin['profile'] != $new_filename && file_exists($target_dir . $admin['profile'])) {
                unlink($target_dir . $admin['profile']);
            }
        } else {
            $errors[] = "Failed to upload profile picture";
        }
    }

    $sql .= " WHERE id = :id";
    $params['id'] = $admin_id;

    // Execute update if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare($sql);
        if ($stmt->execute($params)) {
            $success = "Profile updated successfully!";

            // Update $admin array for display
            $admin['name'] = $name;
            $admin['email'] = $email;
            if (!empty($password)) $admin['password'] = $params['password'];
            if (!empty($params['profile'])) $admin['profile'] = $params['profile'];
        } else {
            $errors[] = "Failed to update profile";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<style>
body { font-family: sans-serif; background: #f0f0f0; padding: 2rem; }
.container { max-width: 500px; margin: auto; background: #fff; padding: 2rem; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
input, button { width: 100%; padding: 0.8rem; margin: 0.5rem 0; border-radius: 8px; border: 1px solid #ccc; font-size: 1rem; }
button { background: #7a6cff; color: #fff; border: none; cursor: pointer; }
img { max-width: 120px; border-radius: 50%; display: block; margin-bottom: 1rem; }
.error { color: red; }
.success { color: green; }
</style>
</head>
<body>

<div class="container">
    <h2>Edit Profile</h2>

    <?php foreach ($errors as $error) echo "<p class='error'>$error</p>"; ?>
    <?php if ($success) echo "<p class='success'>$success</p>"; ?>

    <form action="" method="POST" enctype="multipart/form-data">
        <?php if (!empty($admin['profile'])): ?>
            <img src="../image/<?= htmlspecialchars($admin['profile']) ?>" alt="Profile Picture">
        <?php endif; ?>

        <label>Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($admin['name']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" value="<?= htmlspecialchars($admin['email']) ?>" required>

        <label>Password (leave blank to keep current)</label>
        <input type="password" name="password">

        <label>Profile Picture</label>
        <input type="file" name="profile_pic" accept="image/*">

        <div class="flex-btn">
        <button type="submit" name="update">Update Profile</button>
        <a href="dashboard.php" class="btn">Go Back</a>
</div>
    </form>
</div>

</body>
</html>