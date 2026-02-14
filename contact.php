<?php
include '../components/connection.php';
session_start();

// Set user_id if logged in
if (isset($_SESSION['user_id'])){
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
}

// Handle logout
if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit(); 
}

// Handle contact form submission
if (isset($_POST['submit-btn'])) {

    $name    = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_SPECIAL_CHARS);
    $email   = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $number  = filter_input(INPUT_POST, 'number', FILTER_SANITIZE_SPECIAL_CHARS);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    $subject = $number;
    $current_date = date('Y-m-d H:i:s');

    if (!empty($name) && !empty($email) && !empty($message)) {

        $insert_message = $conn->prepare("
            INSERT INTO `message` (user_id, name, email, subject, message, date)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        $insert_message->execute([
            $user_id,
            $name,
            $email,
            $subject,
            $message,
            $current_date
        ]);

        /* ---------- EMAIL SEND ---------- */
        $to = 'Marcelle@printworks.co.za';
        $email_subject = 'New Contact Message - Print Works';

        $email_body = "
New message received:

Name: $name
Email: $email
Phone: $number
Date: $current_date

Message:
$message
        ";

        $headers  = "From: Print Works <no-reply@printworks.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

        @mail($to, $email_subject, $email_body, $headers);
       

        $notyf_type = 'success';
        $notyf_msg  = 'Message sent successfully!';

    } else {
        $notyf_type = 'error';
        $notyf_msg  = 'Please fill in all required fields!';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf/notyf.min.css">
    <link rel="stylesheet" href="style.css">
    <title>Print Works - Contact Us</title>
</head>
<body>

<?php include '../components/header.php'; ?>

<div class="main">

    <div class="banner">
        <h1>contact us</h1>
    </div>

    <div class="title2">
        <a href="home.php">home</a><span> / contact</span>
    </div>

    <section class="services">
        <div class="box-container">
            <div class="box">
                <img src="../img/icon2.png">
                <div class="detail">
                    <h3>great savings</h3>
                    <p>Save big on every order. Quality prints without breaking the bank.</p>
                </div>
            </div>
            <div class="box">
                <img src="../img/icon1.png">
                <div class="detail">
                    <h3>support</h3>
                    <p>We’re here when you need us. Quick, friendly support every step of the way.</p>
                </div>
            </div>
            <div class="box">
                <img src="../img/icons8-delivery-time-50.png">
                <div class="detail">
                    <h3>Fast Turnaround</h3>
                    <p>Get your prints quickly with our efficient production process, no waiting around. </p>
                </div>
            </div>
            <div class="box">
                <img src="../img/icon.png">
                <div class="detail">
                    <h3>Satisfaction Guaranteed</h3>
                    <p>We make sure you love every print. Your satisfaction is our top priority. </p>
                </div>
            </div>
        </div>
    </section>

    <div class="form-container" id="contact-form">
        <form method="post" action="#contact-form">
            <div class="title">
             
                <h1>leave a message</h1>
            </div>

            <div class="input-field">
                <p>your name</p>
                <input type="text" name="name">
            </div>

            <div class="input-field">
                <p>your email</p>
                <input type="email" name="email">
            </div>

            <div class="input-field">
                <p>your number</p>
                <input type="text" name="number">
            </div>

            <div class="input-field">
                <p>your message</p>
                <textarea name="message"></textarea>
            </div>

            <button type="submit" name="submit-btn" class="btn">send message</button>
        </form>
    </div>

    <!-- Contact Details -->
        <div class="address">
            <div class="title">
                <h1>contact details</h1>
                <p>Feel free to get in touch with me using any of the contact options below:</p>
            </div>
            <div class="box-container">
                <div class="box">
                    <i class="bx bxs-map-pin"></i>
                    <div>
                        <h4>address</h4>
                        <p>18 Frank Street, Port Elizabeth</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-phone-call"></i>
                    <div>
                        <h4>phone number</h4>
                        <p>078 595 0733</p>
                    </div>
                </div>
                <div class="box">
                    <i class="bx bxs-envelope"></i>
                    <div>
                        <h4>email</h4>
                        <p>printworks@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>

    <?php include '../components/footer.php'; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/notyf/notyf.min.js"></script>

<?php if (isset($notyf_msg)): ?>
<script>
const notyf = new Notyf({
  duration: 3000,
  position: { x: 'right', y: 'top' }
});

<?php if ($notyf_type === 'success'): ?>
notyf.success("<?= addslashes($notyf_msg); ?>");
<?php else: ?>
notyf.error("<?= addslashes($notyf_msg); ?>");
<?php endif; ?>
</script>
<?php endif; ?>

</body>
</html>