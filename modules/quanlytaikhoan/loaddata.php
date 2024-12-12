<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

try {
    // Truy vấn lấy danh sách người dùng
    $sqlsp = "SELECT *FROM tbl_nguoidung";
    $stmt = $pdo->prepare($sqlsp);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi truy vấn!";
    exit;
}
?>

<div class="form_addCate_item">
    <div class="card">
        <div class="card-header">
            <h2>DANH SÁCH NGƯỜI DÙNG</h2>
            <a class="btn btn-success" href="?action=quanlytaikhoan&query=them">Thêm</a>
        </div>
        <div class="card-body">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th>TT</th>
                        <th>Tên Đăng Nhập</th>
                        <th>Mật Khẩu</th>
                        <th>Số Dư</th>
                        <th>Phân Quyền</th>
                        <th colspan="2">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($users as $row) { ?>
                        <tr>
                            <td><?php echo $i++; ?></td>
                            <td><?php echo htmlspecialchars($row['ten_dang_nhap']); ?></td>
                            <td><?php echo htmlspecialchars($row['mat_khau']); ?></td>
                            <td><?php echo $row['so_du'] !== null ? number_format($row['so_du'], 0) : '0'; ?> VND</td>
                            <td><?php echo htmlspecialchars($row['phan_quyen']); ?></td>
                            <td><a class="btn btn-secondary" href="?action=quanlytaikhoan&query=sua&id=<?php echo $row['nguoi_dung_id']; ?>">Sửa</a></td>
                            <td><a class="btn btn-danger delete-btn" href="./modules/quanlytaikhoan/remove.php?id=<?php echo $row['nguoi_dung_id']; ?>">Xóa</a></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
