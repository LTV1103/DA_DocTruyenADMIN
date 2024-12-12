<?php
include('config/config.php');

if (isset($_POST['btnLogin'])) {
    $username = $_POST['user_name'];
    $password = $_POST['password'];
    try {
        $sql = "SELECT * FROM tbl_nguoidung WHERE ten_dang_nhap = :username AND mat_khau = :password AND phan_quyen = :role";
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        $role = 'ADMIN';

        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['login'] = $username;
            header('Location:index.php');
        } else {
            header('Location:login.php');
        }
    } catch (PDOException $e) {
        echo "Lỗi ";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>Login</title>
</head>

<body>

    <div class="form_login">
        <form action="" method="post">
            <div class="box_login">
                <p>ADMIN</p>
                <div class="box_username">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="user_name" value="">
                </div>
                <div class="box_pass">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password">
                </div>
                <div class="box_submit">
                    <input type="submit" name="btnLogin" value="Login">
                </div>
            </div>
        </form>
    </div>

</body>

</html>