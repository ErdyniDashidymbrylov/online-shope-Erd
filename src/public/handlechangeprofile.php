<?php
global $pdo;
session_start();

if (!isset($_SESSION['userId'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['userId'];
$pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->execute([':user_id' => $user_id]);
$user = $stmt->fetch();

/*echo "<pre>";
print_r($data);
echo "</pre>";
die;*/

$oldname = $user['name'];
$oldemail = $user['email'];
$oldpassword = $user['password'];
global $oldname; global $oldemail;
//$_SESSION['name']=$oldname;
function validateRegistration(array $data) : array
{
    $errors = [];

    if (isset($data['name'])) {
        $name = $data['name'];
        if (strlen($name) < 2) {
            $errors['name'] = "Имя обязательно для заполнения.";
        }
    }
    else  { $errors['name'] = "Имя должно быть заполнено." ;
    }

    if (isset($data['email'])) {
        $email = $data['email'];
        if (strlen($email) < 3) {
            $errors['email'] = "Email не может содержать меньше 3 - х символов.";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = "Некорректный формат email.";
        } else {
            $pdo = new PDO('pgsql:host=postgres;port=5432;dbname=testdb', 'user', '123');
            $stmt = $pdo->prepare(query: "SELECT COUNT(*) FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $row = $stmt->fetchColumn();
            if ($row > 0) {
                $errors['email'] = 'Этот Email уже зарегистрирован!';
            }
        }
    }   else { $errors['email'] = "Емаил должен быть заполнен." ;
    }

    if (isset($data['psw']))
    {
        $password = $data['psw'];
        if (strlen($password)<2) {
            $errors['psw'] = "Пароль не может содержать меньше 2 - х символов.";
        }
        $passwordRepeat = $data['psw-repeat'];
        if ($password !== $passwordRepeat) {
            $errors['psw-repeat'] = "Пароли не совпадают.";
        }
    } else { $errors['psw'] = "Пароль должен быть заполнен." ;
    }

    return $errors;
}



$validationErrors = validateRegistration($_POST);

if (empty($validationErrors))
{

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['psw'];
    $passwordRepeat = $_POST['psw-repeat'];

    $user_id = $_SESSION['userId'];

    if ($_POST['name'] !== $user['name']) {
            $stmtUpdateName = $pdo->prepare("UPDATE users SET name = :name WHERE id = :user_id");
            $stmtUpdateName->execute([':name' => $_POST['name'], ':user_id' => $user_id]);
        }

    if ($_POST['email'] !== $user['email']) {
        $stmtEmailCheck = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email AND id != :user_id");
        $stmtEmailCheck->execute([':email' => $_POST['email'], ':user_id' => $user_id]);
        if ($stmtEmailCheck->fetchColumn() == 0) {
            $stmtUpdateEmail = $pdo->prepare("UPDATE users SET email = :email WHERE id = :user_id");
            $stmtUpdateEmail->execute([':email' => $_POST['email'], ':user_id' => $user_id]);
        } else {
            $errors['email'] = 'Этот Email уже зарегистрирован!';
        }
    }


    if (!empty($_POST['psw']) && $_POST['psw'] === $_POST['psw-repeat']) {
            $hashedPassword = password_hash($_POST['psw'], PASSWORD_DEFAULT);
            $stmtUpdatePassword = $pdo->prepare("UPDATE users SET password = :password WHERE id = :user_id");
            $stmtUpdatePassword->execute([':password' => $hashedPassword, ':user_id' => $user_id]);
        }

        header("Location: /profile");

    }




