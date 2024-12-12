<?php
require_once dirname(dirname(__DIR__)) . "/config/config.php";

$id = $_GET['id'];

// Lấy thông tin sản phẩm
try {
    $stmt_product = $pdo->prepare("SELECT * FROM tbl_products WHERE id_product = ?");
    $stmt_product->execute([$id]);
    $row_upload = $stmt_product->fetch(PDO::FETCH_ASSOC);

    // Lấy danh mục
    $stmt_categories = $pdo->prepare("SELECT * FROM tbl_categories");
    $stmt_categories->execute();
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Lỗi: " . $e->getMessage();
    exit;
}

if (isset($_POST['sbm'])) {
    $name = $_POST['namepro'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $stock = $_POST['stock'];
    $id_category = $_POST['id_category'];

    // Xử lý hình ảnh
    if ($_FILES['image']['name'] != '') {
        $image = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        move_uploaded_file($image_tmp, ROOT . '/image/' . $image);
    } else {
        $image = $row_upload['image']; // Giữ nguyên hình ảnh cũ
    }

    // Cập nhật sản phẩm
    try {
        $stmt_update = $pdo->prepare("UPDATE tbl_products SET namepro = ?, description = ?, price = ?, stock = ?, image = ?, id_category = ? WHERE id_product = ?");
        $stmt_update->execute([$name, $description, $price, $stock, $image, $id_category, $id]);
        header('Location:/admin/index.php?action=quanlysanpham&query=load&message=update');
        exit;
    } catch (PDOException $e) {
        header('Location:/admin/index.php?action=quanlysanpham&query=load&message=error');
    }
}
?>

<div class="card mt-5 mx-auto" style="width: 50%;">
    <div class="card-header">
        <h1>Sửa Thông Tin Sản Phẩm</h1>
    </div>
    <div class="card-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="form-group mb-3">
                <label for="">Tên Sản Phẩm</label>
                <input type="text" name="namepro" class="form-control" required value="<?php echo htmlspecialchars($row_upload['namepro']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Mô Tả</label>
                <input type="text" name="description" class="form-control" required value="<?php echo htmlspecialchars($row_upload['description']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Giá Tiền</label>
                <input type="number" name="price" class="form-control" required value="<?php echo htmlspecialchars($row_upload['price']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Số Lượng</label>
                <input type="number" name="stock" class="form-control" required value="<?php echo htmlspecialchars($row_upload['stock']); ?>">
            </div>
            <div class="form-group mb-3">
                <label for="">Hình Ảnh Sản Phẩm</label><br>
                <input type="file" name="image" class="form-control-file">
                <img src="../../../image/<?php echo htmlspecialchars($row_upload['image']); ?>" alt="Hình ảnh sản phẩm" width="100" />
            </div>
            <div class="form-group mb-3">
                <label for="">Danh Mục</label>
                <select class="form-control" name="id_category" required>
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['id_category']; ?>" <?php if ($category['id_category'] == $row_upload['id_category']) echo 'selected'; ?>>
                            <?php echo htmlspecialchars($category['name']); ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <button name="sbm" class="btn btn-success" type="submit">CẬP NHẬT SẢN PHẨM</button>
        </form>
    </div>
</div>