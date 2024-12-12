<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

if (isset($_POST['sbm'])) {
    try {
        // Lấy dữ liệu từ form
        $ten_dang_nhap = $_POST['ten_dang_nhap'];
        $mat_khau = $_POST['mat_khau'];
        $so_du = $_POST['so_du'];
        $phan_quyen = $_POST['phan_quyen'];

        // Chèn dữ liệu người dùng vào bảng
        $sql_insert = "INSERT INTO tbl_nguoidung (ten_dang_nhap, mat_khau, so_du, phan_quyen)
                       VALUES (:ten_dang_nhap, :mat_khau, :so_du, :phan_quyen)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([
            'ten_dang_nhap' => $ten_dang_nhap,
            'mat_khau' => $mat_khau,
            'so_du' => $so_du,
            'phan_quyen' => $phan_quyen
        ]);

        // Chuyển hướng với thông báo thành công
        header('Location:index.php?action=quanlytaikhoan&query=load&message=success');
        exit;
    } catch (PDOException $e) {
        // Xử lý lỗi truy vấn cơ sở dữ liệu
        error_log("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
        header('Location:index.php?action=quanlytaikhoan&query=load&message=error');
        exit;
    }
}
?>

<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Thêm Người Dùng</h1>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group mb-3">
                <label for="">Tên Đăng Nhập</label>
                <input type="text" name="ten_dang_nhap" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">Mật Khẩu</label>
                <input type="password" name="mat_khau" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">Số Dư</label>
                <input type="number" step="0.01" name="so_du" class="form-control" >
            </div>
            <div class="form-group mb-3">
                <label for="">Phân Quyền</label>
                <select class="form-control" name="phan_quyen" required>
                    <option value="USER">USER</option>
                    <option value="ADMIN">ADMIN</option>
                </select>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">THÊM NGƯỜI DÙNG</button>
        </form>
    </div>
</div>
