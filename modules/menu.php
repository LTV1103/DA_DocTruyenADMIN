<?php
if (isset($_GET['status']) == 'logout') {
    unset($_SESSION['login']);
    header('Location:login.php');
}
?>

<div>
    <h1 style="color: #00b3f0; text-align: center; font-size: 50px;">Admin</h1>
</div>

<div class="nav_bar">
    <ul>
        <li><a href="index.php?action=quanlytruyen&query=load">Quản Lí Truyện</a></li>
        <!-- <li><a href="index.php?action=quanlychuong&query=load">Quản Lí Chương</a></li> -->
        <li><a href="index.php?action=quanlytaikhoan&query=load">Quản Lí Tài Khoản</a></li>
        <!-- <li><a href="/modules/user.php">User</a></li> -->
        <li><a href="index.php?status=logout">Đăng Xuất | <?php if (isset($_SESSION['login'])) {
                                                                echo $_SESSION['login'];
                                                            } ?></a></li>
    </ul>
</div>