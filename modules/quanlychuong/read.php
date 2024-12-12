<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

$chuong_id = isset($_GET['id']) ? $_GET['id'] : null;

try {
    // Truy vấn lấy thông tin chương truyện từ cơ sở dữ liệu
    $sql = "SELECT c.ten_chuong, c.hinh_anh_truyen, t.ten_truyen 
            FROM tbl_chuongtruyen c
            JOIN tbl_truyentranh t ON c.truyen_tranh_id = t.truyen_tranh_id
            WHERE c.chuong_truyen_id = :chuong_id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':chuong_id', $chuong_id, PDO::PARAM_INT);
    $stmt->execute();
    $chuong = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chuong) {
        throw new Exception('Chương không tồn tại');
    }

    // Lấy tên chương và hình ảnh từ cơ sở dữ liệu
    $hinh_anh_truyen = explode(',', $chuong['hinh_anh_truyen']);
    $chuong_name = $chuong['ten_chuong'];
    $truyen_name = $chuong['ten_truyen']; // Lấy tên truyện từ cơ sở dữ liệu

    // Đường dẫn tới thư mục chứa hình ảnh trên web
    $truyen_dir = '/modules/quanlychuong/Truyen/' . $truyen_name . '/' . $chuong_name; 
} catch (Exception $e) {
    echo 'Lỗi: ' . $e->getMessage();
    exit;
}
?>
<div class="form_addCate_item">
    <div class="card">
        <div class="card-header">
        <div class="card-body">
<h2>    <?php echo $chuong_name; ?></h2>
<?php if (!empty($hinh_anh_truyen)): ?>
    <div class="images-container">
        <?php foreach ($hinh_anh_truyen as $image): ?>
            <div class="image-item">
                <!-- Sử dụng đường dẫn URL hợp lệ -->
                <img src="<?php echo $truyen_dir . '/' . $image; ?>" alt="Hình ảnh chương">
            </div>
        <?php endforeach; ?>
    </div>
<?php else: ?>
    <p>Không có hình ảnh cho chương này.</p>
<?php endif; ?>
        </div>
</div>
    </div>
</div>
