<?php 
include '../components/connection.php';
session_start();

if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

$message = [];

if (isset($_POST['submit'])){
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $pass = filter_var($_POST['pass'], FILTER_SANITIZE_STRING);
    
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
    $select_user->execute([$email, $pass]);
    $row = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($select_user->rowCount() > 0) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_email'] = $row['email'];

        $redirect = $_GET['redirect'] ?? 'home';
        header("Location: {$redirect}.php");
        exit; 
    } else {
        $message[] = 'Incorrect username or password';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PrintWorks - Login Now</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    <!-- Notyf CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
</head>
<body>
    <div class="main-container">
        <div class="form-container">
            <section class="form-container">
                <div class="title">
                    <h1>Login</h1>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
                </div>

                <form action="" method="post">
                    <div class="input-field">
                        <p>Your Email <sup>*</sup></p>
                        <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                    </div>
                    <div class="input-field">
                        <p>Your Password <sup>*</sup></p>
                        <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                    </div>
                    <input type="submit" name="submit" value="Login Now" class="btn">
                    <p>Do not have an account? <a href="register.php">Register now</a></p>
                    <a href="home.php" class="btn" style="margin-top:10px; display:inline-block;">Go Back to Home</a>
                </form>
            </section>
        </div>
    </div>

    <!-- Notyf JS -->
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        const notyf = new Notyf({
            duration: 3000,
            position: { x: 'right', y: 'top' },
            dismissible: true
        });

        <?php
        if (!empty($message)) {
            foreach ($message as $msg) {
                echo "notyf.error(" . json_encode($msg) . ");";
            }
        }
        ?>
    </script>
</body>
</html>
