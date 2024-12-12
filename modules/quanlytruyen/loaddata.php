<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

try {
    // Truy vấn lấy danh sách sản phẩm
    $sqltruyen = "SELECT *FROM tbl_truyentranh";
    $stmt = $pdo->prepare($sqltruyen);
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn!";
    exit;
}
?>

<div class="form_addCate_item">
    <div class="card">
        <div class="card-header">
            <h2>DANH SÁCH TRUYỆN</h2>
            <a class="btn btn-success" href="?action=quanlytruyen&query=them">Thêm</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>TT</th>
                        <th>Tên</th>
                        <th>Thể Loại</th>
                        <th>Tác Giả</th>
                        <th>Mô Tả</th>
                        <th>Ảnh Bìa</th>
                        <th>Trạng Thái</th>
                        <th colspan="3">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($products as $row) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_truyen']); ?></td>
                            <td><?php echo htmlspecialchars($row['the_loai']); ?></td>
                            <td><?php echo htmlspecialchars($row['tac_gia']); ?></td>
                            <td><?php echo htmlspecialchars($row['mo_ta']); ?></td>
                            <td>
                            <img src="modules/image/<?php echo htmlspecialchars($row['anh_bia']); ?>" width="100px">
                            </td>
                            <td><?php echo htmlspecialchars($row['trang_thai']); ?></td>
                            <td><a class="btn btn-info" href="?action=quanlytruyen&query=chuong&id=<?php echo $row['truyen_tranh_id']; ?>">Chương</a></td>
                            <td><a class="btn btn-secondary" href="?action=quanlytruyen&query=sua&id=<?php echo $row['truyen_tranh_id']; ?>">Sửa</a></td>
                            <td><a class="btn btn-danger delete-btn" href="./modules/quanlytruyen/remove.php?id=<?php echo $row['truyen_tranh_id']; ?>">Xóa</a></td>
                            

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>