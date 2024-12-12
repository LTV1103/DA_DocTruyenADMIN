<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

$id = $_GET['id'];

try {
    // Lấy thông tin sản phẩm cần chỉnh sửa
    $stmt_product = $pdo->prepare("SELECT * FROM tbl_truyentranh WHERE truyen_tranh_id = ?");
    $stmt_product->execute([$id]);
    $row_upload = $stmt_product->fetch(PDO::FETCH_ASSOC);

    if (!$row_upload) {
        header('Location:index.php?action=quanlytruyen&query=load&message=notFound');
        exit;
    }

    // Kiểm tra nếu người dùng đã gửi thông tin để cập nhật
    if (isset($_POST['sbm'])) {
        $tentruyen = isset($_POST['ten_truyen']) ? $_POST['ten_truyen'] : '';
        $theLoai = isset($_POST['the_loai']) ? $_POST['the_loai'] : '';
        $tacGia = isset($_POST['tac_gia']) ? $_POST['tac_gia'] : '';
        $trangThai = isset($_POST['trang_thai']) ? $_POST['trang_thai'] : '';
        $moTa = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '';

        // Xử lý hình ảnh nếu có
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
        $image_tmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
        
        if ($image) {
            // Kiểm tra loại tệp và kích thước (tối đa 5MB)
            $allowed_types = ['image/jpeg', 'image/png', 'image/jpg'];
            $max_size = 5 * 1024 * 1024; // 5MB
            
            if (!in_array($_FILES['image']['type'], $allowed_types)) {
                header('Location: index.php?action=quanlytruyen&query=sua&message=invalidFileType');
                exit;
            }
            
            if ($_FILES['image']['size'] > $max_size) {
                header('Location: index.php?action=quanlytruyen&query=sua&message=fileTooLarge');
                exit;
            }

            // Tạo tên tệp mới để tránh trùng lặp
            $anh_bia = time() . '-' . $image;
            // Chuyển hình ảnh lên thư mục
            $target_dir = dirname(__DIR__) . '/image/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }
            move_uploaded_file($image_tmp, $target_dir . $anh_bia);
        } else {
            // Nếu không có hình ảnh mới, giữ lại hình ảnh cũ
            $anh_bia = $row_upload['anh_bia'];
        }

        // Cập nhật thông tin sản phẩm vào cơ sở dữ liệu
        $sql_update = "UPDATE tbl_truyentranh SET ten_truyen = ?, the_loai = ?, tac_gia = ?, trang_thai = ?, mo_ta = ?, anh_bia = ? WHERE truyen_tranh_id = ?";
        $stmt_update = $pdo->prepare($sql_update);
        $stmt_update->execute([$tentruyen, $theLoai, $tacGia, $trangThai, $moTa, $anh_bia, $id]);

        // Sau khi cập nhật thành công, chuyển hướng về trang danh sách
        header('Location: index.php?action=quanlytruyen&query=load&message=updateSuccess');
        exit;
    }
} catch (PDOException $e) {
    // Xử lý lỗi kết nối hoặc truy vấn
    header('Location: index.php?action=quanlytruyen&query=load&message=error');
    exit;
}
?>

<!-- Form chỉnh sửa thông tin sản phẩm -->
<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Sửa Thông Tin Truyện</h1>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="">Tên Truyện</label>
                <input type="text" name="ten_truyen" class="form-control" required value="<?php echo htmlspecialchars($row_upload['ten_truyen']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Mô Tả</label>
                <textarea name="mo_ta" class="form-control" required><?php echo htmlspecialchars($row_upload['mo_ta']); ?></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="">Thể Loại</label>
                <input type="text" name="the_loai" class="form-control" required value="<?php echo htmlspecialchars($row_upload['the_loai']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Tác Giả</label>
                <input type="text" name="tac_gia" class="form-control" required value="<?php echo htmlspecialchars($row_upload['tac_gia']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Trạng Thái</label>
                <input type="text" name="trang_thai" class="form-control" required value="<?php echo htmlspecialchars($row_upload['trang_thai']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Hình Ảnh Truyện</label><br>
                <input type="file" name="image" class="form-control-file">
                <?php if ($row_upload['anh_bia']) { ?>
                    <img src="modules/image/<?php echo htmlspecialchars($row_upload['anh_bia']); ?>" alt="Ảnh bìa truyện" width="100" />
                    <?php } ?>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">CẬP NHẬT TRUYỆN</button>
        </form>
    </div>
</div>
