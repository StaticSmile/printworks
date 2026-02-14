<?php 
    include '../components/connection.php' ;

    if (isset($_POST['register'])){

        $id = unique_id();

        $name = $_POST['name'];
        $name = filter_var($name, FILTER_SANITIZE_STRING);

        $email = $_POST['email'];
        $email = filter_var($email, FILTER_SANITIZE_STRING);

        $pass = sha1($_POST['password']);
        $pass = filter_var($pass, FILTER_SANITIZE_STRING);
        
        $cpass = sha1($_POST['cpassword']);
        $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

        $image = $_FILES['image']['name'];
        $image = filter_var($image, FILTER_SANITIZE_STRING);
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_folder = '../image/'.$image;

        $select_admin = $conn->prepare("SELECT * FROM `admin` WHERE email = ?");
        $select_admin->execute([$email]);

        if ($select_admin->fetch()) {
            $warning_msg[] = 'user email already exists';
        }else{
            if($pass != $cpass){
                $warning_msg[] = "Password's don't match'";
            }else{
                $insert_admin = $conn->prepare("INSERT INTO `admin` (id, name, email, password, profile) VALUE(?,?,?,?,?)");
                $insert_admin->execute([$id, $name, $email, $cpass, $image]);
                move_uploaded_file($image_tmp_name, $image_folder);
                $success_msg[] = 'new admin registered';
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="stylesheet" type="text/css" href="admin_style.css?v=<?php echo time(); ?>">
    <title>print works admin panel - register</title>
</head>
<body>
    <div class="main">
        <section>
            <div class="form-container" id="admin_login">
                <form action="" method="post" enctype="multipart/form-data">
                    <h3>register now</h3>
                    <div class="input-feild">
                        <label>user name <sup>*</sup></label>
                        <input type="text" name="name" maxlength="20" required placeholder="Enter your name" oninput="this.value.replace(/\/g,'')">
                    </div>
                    <div class="input-feild">
                        <label>user email <sup>*</sup></label>
                        <input type="email" name="email" maxlength="50" required placeholder="Enter your email" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-feild">
                        <label>user password <sup>*</sup></label>
                        <input type="password" name="password" maxlength="20" required placeholder="Enter your password" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-feild">
                        <label>confirm password <sup>*</sup></label>
                        <input type="password" name="cpassword" maxlength="20" required placeholder="Confirm your password" oninput="this.value.replace(/\s/g,'')">
                    </div>
                    <div class="input-feild">
                        <label>select profile <sup>*</sup></label>
                        <input type="file" name="image" accept="image/*">
                    </div>
                    <button type="submit" name="register" class="btn">register now</button>
                    <p>already have an account ? <a href="login.php">login now</a></p>
                </form>
            </div>
        </section>
    </div>




     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script type="text/javascript" src="admin_script.js"></script>

     <?php include '../components/alert.php'; ?>
</body>
</html>