<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    try {
        // Truy vấn lấy truyen_tranh_id từ chuong_truyen_id
        $sql = "SELECT truyen_tranh_id FROM tbl_chuongtruyen WHERE chuong_truyen_id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        // Lấy truyen_tranh_id
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $truyen_tranh_id = $row['truyen_tranh_id'];

            // Truy vấn xóa chương truyện
            $sql_delete = "DELETE FROM tbl_chuongtruyen WHERE chuong_truyen_id = :id";
            $stmt_delete = $pdo->prepare($sql_delete);
            $stmt_delete->execute([':id' => $id]);

            // Chuyển hướng về trang với truyen_tranh_id
            header("Location: ../../index.php?action=quanlytruyen&query=chuong&id=$truyen_tranh_id");
            exit;
        } else {
            // Nếu không tìm thấy chuong_truyen_id
            header("Location: ../../index.php?action=quanlytruyen&query=chuong&id=$truyen_tranh_id");
            exit;
        }
    } catch (PDOException $e) {
        // Xử lý lỗi
        header("Location: ../../index.php?action=quanlytruyen&query=chuong&id=$truyen_tranh_id");
        exit;
    }
} else {
    // Nếu không có id
    header("Location: ../../index.php?action=quanlytruyen&query=chuong&id=$truyen_tranh_id");
    exit;
}
?>
