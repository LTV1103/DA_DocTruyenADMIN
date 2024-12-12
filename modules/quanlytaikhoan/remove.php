<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Chuẩn bị câu truy vấn xóa truyện
        $sql = "DELETE FROM tbl_nguoidung WHERE nguoi_dung_id = :id";
        $stmt = $pdo->prepare($sql);

        // Thực thi truy vấn với tham số id
        $stmt->execute([':id' => $id]);

        // Chuyển hướng sau khi xóa thành công
        header('Location:/index.php?action=quanlytaikhoan&query=load&message=delSuccess');
        exit;
    } catch (PDOException $e) {
        // Xử lý lỗi khi truy vấn không thành công
        header('Location: /index.php?action=quanlytaikhoan&query=load&message=error');
        exit;
    }
} else {
    // Nếu không có id, chuyển hướng về trang quản lý
    header('Location:/index.php?action=quanlytaikhoan&query=load');
    exit;
}
?>
