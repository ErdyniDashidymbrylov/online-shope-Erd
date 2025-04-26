<div class="wrapper">
    <form action="handle_login.php" method="POST" class="form-signin">
        <h2 class="form-signin-heading">Пожалуйста, войдите</h2>
        <input type="text" class="form-control" name="username" placeholder="Email адрес" required autofocus />

            <label style="color:red"><?php /*echo $errors['name']; */?></label>
       <?php /*endif; */?>
        <input type="password" class="form-control" name="password" placeholder="Пароль" required />
       <!-- <?php /*if(!isset($errors['name'])): */?>
            <label style="color:red"><?php /*echo $errors['password']; */?></label>
        --><?php /*endif; */?>
        <label class="checkbox">
            <input type="checkbox" value="remember-me" id="rememberMe" name="rememberMe"> Запомнить меня
        </label>

        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
    </form>
</div>

<style>
    body {
        background: #e9f5ff;
    }

    .wrapper {
        margin-top: 80px;
        margin-bottom: 80px;
    }

    .form-signin {
        max-width: 380px;
        padding: 20px;
        margin: auto;
        background-color: #fff;
        border: 1px #66afe9;
        border-radius: 2px;
        box-shadow: 0 4px 20px #66afe9;
    }

    .form-signin-heading {
        text-align: center;
        margin-bottom: 30px;
        font-size: 24px;
        color: #002aff;
    }

    .checkbox {
        font-weight: normal;
    }

    .form-control {
        position: relative;
        font-size: 16px;
        height: auto;
        padding: 10px;
        box-sizing: border-box;
        border: 1px solid #ccc; /* Добавлено для обычного состояния */
        border-radius: 5px; /* Скругление углов полей ввода */

        &:focus {
            z-index: 2;
            border-color: #0056b3; /* Цвет рамки при фокусе */
            outline: none; /* Убираем стандартный контур */
            background-color: #e6f7ff; /* Цвет фона при фокусе */
        }
    }

    input[type="text"], input[type="password"] {
        margin-bottom: 5px;
        border-radius: 12px;
    }

    input[type="password"] {
        margin-bottom: 20px;
    }

    .btn {
        width: 100%;
        padding: 10px;
        background-color: dodgerblue;
        color: white;
        border-radius: 5px;
        border-color: transparent;

        transition: background-color 0.3s ease;
    }

    .btn:hover {
        background-color: #0056b3;
        opacity: 0.9;
        text-decoration:none;
        color:white;
    }
</style>