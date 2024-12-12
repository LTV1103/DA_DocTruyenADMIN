<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php"; // Đảm bảo bạn đã kết nối với cơ sở dữ liệu
$id = isset($_GET['id']) ? $_GET['id'] : null;

try {
    // Truy vấn kiểm tra truyện có tồn tại
    $sql_truyen = "SELECT truyen_tranh_id, ten_truyen FROM tbl_truyentranh WHERE truyen_tranh_id = :id";
    $stmt_truyen = $pdo->prepare($sql_truyen);
    $stmt_truyen->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_truyen->execute();
    $truyen = $stmt_truyen->fetch(PDO::FETCH_ASSOC);

    if (!$truyen) {
        throw new Exception('Truyện không tồn tại');
    }

    // Lấy tên truyện và tạo thư mục cho truyện
    $truyen_name = $truyen['ten_truyen'];
    $truyen_dir = __DIR__ . '/Truyen/' . $truyen_name;

    // Nếu thư mục truyện chưa tồn tại, tạo nó
    if (!file_exists($truyen_dir)) {
        mkdir($truyen_dir, 0777, true); // Tạo thư mục cho truyện
    }

    if (isset($_POST['sbm'])) {
        $ten_chuong = $_POST['ten_chuong'];
        $ngay_phat_hanh = $_POST['ngay_phat_hanh'];
        $truyen_tranh_id = $id;

        // Tạo thư mục cho chương trong thư mục truyện
        $chuong_dir = $truyen_dir . '/' . $ten_chuong;
        if (!file_exists($chuong_dir)) {
            mkdir($chuong_dir, 0777, true); // Tạo thư mục cho chương nếu chưa có
        }

        // Xử lý hình ảnh
        $hinh_anh_truyen_names = [];
        if (isset($_FILES['hinh_anh_truyen']) && $_FILES['hinh_anh_truyen']['error'][0] == 0) {
            foreach ($_FILES['hinh_anh_truyen']['name'] as $key => $image_name) {
                $image_tmp = $_FILES['hinh_anh_truyen']['tmp_name'][$key];
                $upload_path = $chuong_dir . '/' . $image_name;

                // Di chuyển ảnh vào thư mục chương
                if (move_uploaded_file($image_tmp, $upload_path)) {
                    $hinh_anh_truyen_names[] = $image_name;
                }
            }
        }

        // Chèn dữ liệu vào bảng chương truyện
        $sql_insert = "INSERT INTO tbl_chuongtruyen (truyen_tranh_id, ten_chuong, ngay_phat_hanh, hinh_anh_truyen)
                       VALUES (:truyen_tranh_id, :ten_chuong, :ngay_phat_hanh, :hinh_anh_truyen)";
        $stmt_insert = $pdo->prepare($sql_insert);

        // Lưu tất cả tên hình ảnh vào cơ sở dữ liệu (dùng dấu phẩy để phân cách nếu có nhiều ảnh)
        $hinh_anh_truyen = implode(',', $hinh_anh_truyen_names);

        $stmt_insert->execute([
            'truyen_tranh_id' => $truyen_tranh_id,
            'ten_chuong' => $ten_chuong,
            'ngay_phat_hanh' => $ngay_phat_hanh,
            'hinh_anh_truyen' => $hinh_anh_truyen
        ]);

        // Chuyển hướng sau khi thêm thành công
        header("Location: index.php?action=quanlytruyen&query=chuong&id=$id");
        exit;
    }
} catch (PDOException $e) {
    header("Location: index.php?action=quanlytruyen&query=chuong&id=$id");
    exit;
} catch (Exception $e) {
    echo 'Lỗi: ' . $e->getMessage();
    exit;
}
?>

<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Thêm Chương Truyện</h1>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="ten_chuong">Tên Chương</label>
                <input type="text" name="ten_chuong" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="ngay_phat_hanh">Ngày Phát Hành</label>
                <input type="date" name="ngay_phat_hanh" class="form-control" required>
            </div>
            <div class="form-group mb-3">
                <label for="hinh_anh_truyen">Hình Ảnh Chương</label>
                <input type="file" name="hinh_anh_truyen[]" class="form-control-file" multiple>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">THÊM CHƯƠNG</button>
        </form>
    </div>
</div>
