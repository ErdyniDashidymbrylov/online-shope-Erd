<?php
global $users;
require_once './users.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (!isset($_SESSION['userId'])) {
    header("Location: /login");
    exit();
}

$userId = $_SESSION['userId'];

// Получение данных пользователя на основе ID сессии.

/*$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');

$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute(['user_id' => $user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);*/

$user = $users->selectUserID($userId);

/*echo "<h1>Добро пожаловать, " . $user['name'] . "!</h1>";

echo "<h3>ваша электронная почта: " . $user['email'] . "!</h3>";

echo "<p><a href='changeprofile.php'>Редактировать профиль</a></p>";

echo "<p><a href='logout.php'>Выйти</a></p>";*/


?>


<div class="card">
    <div class="cover-photo">
        <img src="https://i.imgur.com/KykRUCV.jpeg" class="profile">
    </div>
    <h3 class="profile-name"><?php echo "Привет, " . $user['name'] . "!";?></>
    <p class="about">Вы находитесь на странице профиля</p>
    <a href=''><button class="btn">Написать письмо <?php echo $user['email']?></button></a>
    <a href='/changeprofile'><button class="btn">Редактировать профиль</button></a>
    <a href='/logout'><button class="btn">Выйти</button></a>
</div>

<style>


    @import url("https://fonts.googleapis.com/css2?family=Montserrat:wght@300;700&display=swap");

    * {
        padding: 0;
        margin: 0;
        box-sizing: border-box;
    }

    body {
        background: #222;
        height: 100vh;
        display: grid;
        place-items: center;
        font-family: Montserrat;
        color: #ddeefc;;
    }

    .card {
        padding: 15px;
        width: 350px;
        background: #222;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0 10px 15px rgba(183, 229, 248, 0.7);
        user-select: none;
    }

    .cover-photo {
        position: relative;
        background: url(https://i.imgur.com/jxyuizJ.jpeg);
        background-size: cover;
        height: 200px;
        border-radius: 5px 5px 0 0;
    }

    .profile {
        position: absolute;
        width: 120px;
        bottom: -60px;
        left: 15px;
        border-radius: 50%;
        border: 2px solid #222;
        background: #222;
        padding: 5px;
    }

    .profile-name {
        font-size: 20px;
        margin: 25px 0 0 120px;
        color: #fff;
    }

    .about {
        margin-top: 30px;
        line-height: 1.6;
    }

    .btn {
        margin: 30px 10px;
        background: #7ce3ff;
        padding: 10px 25px;
        border-radius: 10px;
        border: 1px solid #7ce3ff;
        font-weight: bold;
        font-family: Montserrat;
        cursor: pointer;
        color: #7ce3ff;
        transition: 0.2s;
        width: 100%;
        display: flex;
        justify-content: center;

    }

    .btn:last-of-type {
        background: transparent;
        border-color: #7ce3ff;
        color: #7ce3ff;
    }

    .btn:hover {
        background: #7ce3ff;
        color: #222;
    }



</style>