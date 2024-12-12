<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

try {
    $sql_categories = "SELECT * FROM tbl_truyentranh";
    $stmt_categories = $pdo->prepare($sql_categories);
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['sbm'])) {
        $tentruyen = isset($_POST['ten_truyen']) ? $_POST['ten_truyen'] : '';
        $theLoai = isset($_POST['the_loai']) ? $_POST['the_loai'] : '';
        $tacGia = isset($_POST['tac_gia']) ? $_POST['tac_gia'] : '';
        $trangThai = isset($_POST['trang_thai']) ? $_POST['trang_thai'] : '';
        $moTa = isset($_POST['mo_ta']) ? $_POST['mo_ta'] : '';

    
        $image = isset($_FILES['image']['name']) ? $_FILES['image']['name'] : '';
        $image_tmp = isset($_FILES['image']['tmp_name']) ? $_FILES['image']['tmp_name'] : '';
        $anh_bia = $image; 


        $sql_insert = "INSERT INTO tbl_truyentranh (ten_truyen, the_loai, tac_gia, trang_thai, mo_ta, anh_bia)
                       VALUES (:tentruyen, :theLoai, :tacGia, :trangThai, :moTa, :anh_bia)";
        $stmt_insert = $pdo->prepare($sql_insert);
        $stmt_insert->execute([
            'tentruyen' => $tentruyen,
            'theLoai' => $theLoai,
            'tacGia' => $tacGia,
            'trangThai' => $trangThai,
            'moTa' => $moTa,
            'anh_bia' => $anh_bia
        ]);

        if ($image) {
            $target_dir = dirname(__DIR__) .'/image/';
            if (!is_dir($target_dir)) {
                mkdir($target_dir, 0777, true); 
            }
            move_uploaded_file($image_tmp, $target_dir . $image);
        }

        header('Location:index.php?action=quanlytruyen&query=load');
        exit;
    }
} catch (PDOException $e) {
    header('Location: index.php?action=quanlytruyen&query=load');
    exit;
}
?>

<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Thêm Truyện</h1>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="">Tên Truyện</label>
                <input type="text" name="ten_truyen" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">Thể Loại</label>
                <input type="text" name="the_loai" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">Tác Giả</label>
                <input type="text" name="tac_gia" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="trang_thai">Trạng Thái</label>
                <select name="trang_thai" class="form-control" required>
                    <option value="DANG_PHAT_HANH">Đang Phát Hành</option>
                    <option value="HOAN_THANH">Hoàn Thành</option>
                </select>   
            </div>
            <div class="form-group mb-3">
                <label for="">Mô Tả</label>
                <input type="text" name="mo_ta" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="">Ảnh Bìa</label><br>
                <input type="file" name="image" class="form-control-file" required>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">THÊM TRUYỆN</button>
        </form>
    </div>
</div>
