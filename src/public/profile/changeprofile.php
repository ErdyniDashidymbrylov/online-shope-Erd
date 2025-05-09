<?php
global $users;
require_once './users.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
     session_start();
 }

 if (isset($_SESSION['userId'])) {
     $userId = $_SESSION['userId'];
     /*$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
     $stmt = $pdo->query("SELECT * FROM users WHERE id = $userId");
     $user = $stmt->fetch();*/

     $user = $users->selectUserID($userId);

 } else {
     header('location: /login');
 }

 ?>

<form action="/changeprofile" method="POST">
    <div class="container">
        <h1>Редактировать профиль</h1>
        <p>Пожалуйста введите новые данные.</p>
        <hr>

        <label for="name"><b>Name </b></label>
        <?php if(isset($errors['name'])): ?>
            <label style="color:red"><?php echo $errors['name']; ?></label>
        <?php endif; ?>
        <input  type="text" placeholder="" name="name" id="name"  value="<?php echo $user['name'];?>">

        <label for="email"><b>Email </b></label>
        <?php if(isset($errors['email'])): ?>
            <label style="color:red"><?php echo $errors['email']; ?></label>
       <?php endif; ?>
        <input type="text" placeholder="" name="email" id="email" value="<?php echo $user['email']; ?>">

      <!--  <label for="psw"><b>Password</b></label>
        <?php /*if(isset($errors['psw'])): */?>
            <label style="color:red"><?php /*echo $errors['psw']; */?></label>
        <?php /*endif; */?>
        <input type="password" placeholder="Enter Password" name="psw" id="psw" >

        <label for="psw-repeat"><b>Repeat Password</b></label>
        <?php /*if(isset($errors['psw-repeat'])): */?>
            <label style="color:red"><?php /*echo $errors['psw-repeat']; */?></label>
        <?php /*endif; */?>
        <input type="password" placeholder="Repeat Password" name="psw-repeat" id="psw-repeat" >
        <hr>-->

        <button type="submit" class="registerbtn">Редактировать</button>
    </div>


</form>



<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background-color: #ddeefc;
    }

    * {
        box-sizing: border-box;
    }

    /* Add padding to containers */
    .container {
        padding: 16px;
        background-color: white;
    }

    /* Full-width input fields */
    input[type=text], input[type=password] {
        width: 100%;
        padding: 15px;
        margin: 5px 0 22px 0;
        display: inline-block;
        border: none;
        background: #f1f1f1;
    }

    input[type=text]:focus, input[type=password]:focus {
        background-color: #ddd;
        outline: none;
    }

    /* Overwrite default styles of hr */
    hr {
        border: 1px solid #f1f1f1;
        margin-bottom: 25px;
    }

    /* Set a style for the submit button */
    .registerbtn {
        background-color: #55b1df;
        color: white;
        padding: 16px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        opacity: 0.9;
    }

    .registerbtn:hover {
        opacity: 1;
    }

    /* Add a blue text color to links */
    a {
        color: dodgerblue;
    }

    /* Set a grey background color and center the text of the "sign in" section */
    .signin {
        background-color: #f1f1f1;
        text-align: center;
    }
</style>