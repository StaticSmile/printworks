<?php 
include '../components/connection.php';
session_start();

if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
}else{
    $user_id = '';
}

// Register user
if (isset($_POST['submit'])){
    $id = unique_id();
    $name = $_POST['name'];
    $name = filter_var($name, FILTER_SANITIZE_STRING);
    $email = $_POST['email'];
    $email = filter_var($email, FILTER_SANITIZE_STRING);
    $pass = $_POST['pass'];
    $pass = filter_var($pass, FILTER_SANITIZE_STRING);
    $cpass = $_POST['cpass'];
    $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);
    
    $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
    $select_user->execute([$email]);

    if ($select_user->rowCount() > 0) {
        $messages[] = ['type' => 'error', 'text' => 'Email already exists'];
    } else {
        if ($pass != $cpass){
            $messages[] = ['type' => 'error', 'text' => 'Passwords do not match'];
        } else {
            $insert_user = $conn->prepare("INSERT INTO `users` (id,name,email,password) VALUES(?,?,?,?)");
            $insert_user->execute([$id,$name,$email,$pass]);

            // Log in the user after registration
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;

            $messages[] = ['type' => 'success', 'text' => 'Registration successful! Redirecting...'];
            header("Refresh:2; url=home.php"); // Redirect after 2 seconds
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
<link rel="stylesheet" href="style.css">
<!-- Notyf CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
<title>PrintWorks - Register Now</title>
</head>
<body>
<div class="main-container">
    <div class="form-container">
        <section class="form-container">
            <div class="title">
                <h1>Register</h1>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit.</p>
            </div>
            
            <form action="" method="post">
                <div class="input-field">
                    <p>Your Name <sup>*</sup></p>
                    <input type="text" name="name" required placeholder="Enter your name" maxlength="50">
                </div>
                <div class="input-field">
                    <p>Your Email <sup>*</sup></p>
                    <input type="email" name="email" required placeholder="Enter your email" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Password <sup>*</sup></p>
                    <input type="password" name="pass" required placeholder="Enter your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <div class="input-field">
                    <p>Confirm Password <sup>*</sup></p>
                    <input type="password" name="cpass" required placeholder="Confirm your password" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">
                </div>
                <input type="submit" name="submit" value="Register Now" class="btn">
                <p>Already have an account? <a href="login.php">Login now</a></p>
                <p><a href="home.php" class="btn btn-back">Go Back to Home</a></p>
            </form>
        </section>
    </div>
</div>

<!-- Notyf JS -->
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
<script>
    // Initialize Notyf
    const notyf = new Notyf({ duration: 3000, position: {x: 'right', y: 'top'} });

    <?php if(isset($messages)) { 
        foreach($messages as $msg){ ?>
            notyf.<?= $msg['type'] === 'success' ? 'success' : 'error' ?>('<?= $msg['text']; ?>');
    <?php } } ?>
</script>
</body>
</html>
