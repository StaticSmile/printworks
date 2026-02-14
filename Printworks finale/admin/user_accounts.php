<?php 
    include '../components/connection.php' ;

    session_start();

    $admin_id = $_SESSION['admin_id'];

    if (!isset($admin_id)){
        header('location: login.php');
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
    <title>print works admin panel - register user's</title>
</head>
<body>
    <?php include '../components/admin_header.php'; ?>
    <div class="main">
        <div class="banner">
            <h1>register user's</h1>
        </div>
        <div class="title2">
            <a href="dashboard.php">dashboard</a><span> / register user's</span>
        </div>
        <section class="accounts">
                <h1 class="heading">register user's</h1>
                <div class="box-container">
                  <?php 
                  $select_users = $conn->prepare("SELECT * FROM `users`");
                  $select_users->execute();

                  if ($select_users->rowCount() > 0){
                    while($fetch_users = $select_users->fetch(PDO::FETCH_ASSOC)){
                        $user_id = $fetch_users['id'];
               
                  ?> 
                  <div class="box">
                    
                    <P>user id : <span><?= $user_id; ?></span></p>
                    <P>user name : <span><?= $fetch_users['name']; ?></span></p>
                    <P>user email : <span><?= $fetch_users['email']; ?></span></p>
                  </div> 
                  <?php 
                       }
                  }else{echo '
                            <div class="empty">
                                <p>no user registered yet! <br> <a href="add_products.php" style="margin-top:1.5rem; class="btn"<a href="add_products.php">add products</a></p>
                            </div>
                        
                        ';}
                  ?>
                </div>
        </section>
    </div>




     <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
     <script type="text/javascript" src="ascript.js"></script>

     <?php include '../components/alert.php'; ?>
</body>
</html>