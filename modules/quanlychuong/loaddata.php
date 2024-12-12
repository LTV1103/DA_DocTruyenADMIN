<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";
$id = isset($_GET['id']) ? $_GET['id'] : null;
try {
    // Truy vấn lấy thông tin từ hai bảng
    $sqltruyen = "SELECT 
            tbl_chuongtruyen.chuong_truyen_id,
            tbl_chuongtruyen.truyen_tranh_id,
            tbl_chuongtruyen.ten_chuong,
            tbl_chuongtruyen.ngay_phat_hanh,
            tbl_chuongtruyen.hinh_anh_truyen,
            tbl_truyentranh.ten_truyen
        FROM tbl_chuongtruyen
        JOIN tbl_truyentranh 
        ON tbl_chuongtruyen.truyen_tranh_id = tbl_truyentranh.truyen_tranh_id
        WHERE tbl_chuongtruyen.truyen_tranh_id = :id";
    $stmt = $pdo->prepare($sqltruyen);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $truyen = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn: " . $e->getMessage();
    exit;
}
?>

<div class="form_addCate_item">
    <div class="card">
        <div class="card-header">
            <h2>DANH SÁCH CHƯƠNG TRUYỆN</h2>
            <a class="btn btn-success" href="?action=quanlychuong&query=them&id=<?php echo $id;?>">Thêm</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>ID</th>
                        <th>Tên Truyện</th>
                        <th>Tên Chương</th>
                        <th>Ngày Phát Hành</th>
                    
                        <th colspan="3">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if (!empty($truyen)) {
                        foreach ($truyen as $row) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['truyen_tranh_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['ten_truyen']); ?></td>
                                <td><?php echo htmlspecialchars($row['ten_chuong']); ?></td>
                                <td><?php echo htmlspecialchars($row['ngay_phat_hanh']); ?></td>
                                <td><a class="btn btn-info" href="?action=quanlychuong&query=doc&id=<?php echo $row['chuong_truyen_id']; ?>">Đọc Truyện</a></td>
                                <td><a class="btn btn-secondary" href="?action=quanlychuong&query=sua&id=<?php echo $row['chuong_truyen_id']; ?>">Sửa</a></td>
                                <td><a class="btn btn-danger delete-btn" href="./modules/quanlychuong/remove.php?id=<?php echo $row['chuong_truyen_id']; ?>">Xóa</a></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td colspan="7">Không có dữ liệu.</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>