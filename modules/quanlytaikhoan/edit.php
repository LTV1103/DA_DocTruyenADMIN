<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

// Lấy ID người dùng từ URL
$id = $_GET['id'];

try {
    // Truy vấn để lấy thông tin người dùng hiện tại
    $stmt_user = $pdo->prepare("SELECT * FROM tbl_nguoidung WHERE nguoi_dung_id = ?");
    $stmt_user->execute([$id]);
    $user = $stmt_user->fetch(PDO::FETCH_ASSOC);
    
    if (!$user) {
        throw new Exception("Người dùng không tồn tại.");
    }

    if (isset($_POST['sbm'])) {
        // Lấy dữ liệu từ form
        $ten_dang_nhap = $_POST['ten_dang_nhap'];
        $mat_khau = $_POST['mat_khau'];
        $so_du = $_POST['so_du'];
        $phan_quyen = $_POST['phan_quyen'];

        // Cập nhật dữ liệu người dùng vào bảng
        $sql_update = "UPDATE tbl_nguoidung SET ten_dang_nhap = :ten_dang_nhap, mat_khau = :mat_khau, so_du = :so_du, phan_quyen = :phan_quyen WHERE nguoi_dung_id = :id";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([
            'ten_dang_nhap' => $ten_dang_nhap,
            'mat_khau' => $mat_khau,
            'so_du' => $so_du,
            'phan_quyen' => $phan_quyen,
            'id' => $id
        ]);

        // Chuyển hướng với thông báo thành công
        header('Location:index.php?action=quanlytaikhoan&query=load&message=success');
        exit;
    }
} catch (PDOException $e) {
    // Xử lý lỗi truy vấn cơ sở dữ liệu
    error_log("Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage());
    echo "<div class='alert alert-danger'>Lỗi truy vấn cơ sở dữ liệu: " . $e->getMessage() . "</div>";
} catch (Exception $e) {
    // Xử lý các lỗi khác
    error_log("Lỗi khác: " . $e->getMessage());
    echo "<div class='alert alert-danger'>Lỗi: " . $e->getMessage() . "</div>";
}
?>

<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Sửa Thông Tin Người Dùng</h1>
    </div>
    <div class="card-body">
        <form method="POST">
            <div class="form-group mb-3">
                <label for="">Tên Đăng Nhập</label>
                <input type="text" name="ten_dang_nhap" class="form-control" required value="<?php echo htmlspecialchars($user['ten_dang_nhap']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Mật Khẩu</label>
                <input type="password" name="mat_khau" class="form-control" required value="<?php echo htmlspecialchars($user['mat_khau']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Số Dư</label>
                <input type="number" step="0.01" name="so_du" class="form-control" required value="<?php echo htmlspecialchars($user['so_du']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Phân Quyền</label>
                <select class="form-control" name="phan_quyen" required>
                    <option value="USER" <?php if ($user['phan_quyen'] == 'USER') echo 'selected'; ?>>USER</option>
                    <option value="ADMIN" <?php if ($user['phan_quyen'] == 'ADMIN') echo 'selected'; ?>>ADMIN</option>
                </select>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">CẬP NHẬT NGƯỜI DÙNG</button>
        </form>
    </div>
</div>
