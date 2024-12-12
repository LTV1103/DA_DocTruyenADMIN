<div class="main_content">
    <?php
    if (isset($_GET['action']) && $_GET['query']) {
        $t = $_GET['action'];
        $query = $_GET['query'];
    } else {
        $t = '';
    }

    //truyen
    if ($t == 'quanlytruyen' && $query == 'load') {
        include("modules/quanlytruyen/loaddata.php");
    } 
    if ($t == 'quanlytruyen' && $query == 'them') {
        include("modules/quanlytruyen/add.php");
    }
    elseif ($t == 'quanlytruyen' && $query == 'sua') {
        include("modules/quanlytruyen/edit.php");
    } 
    elseif ($t == 'quanlytruyen' && $query == 'chuong') {
        include("modules/quanlychuong/loaddata.php");
    } 

    
    //chuong
    elseif ($t == 'quanlychuong' && $query == 'them') {
        include("modules/quanlychuong/add.php");
    } 
    elseif ($t == 'quanlychuong' && $query == 'sua') {
        include("modules/quanlychuong/edit.php");
    } 
    elseif ($t == 'quanlychuong' && $query == 'doc') {
        include("modules/quanlychuong/read.php");
    } 

    //tai khoan
    elseif ($t == 'quanlytaikhoan' && $query == 'load') {
        include("modules/quanlytaikhoan/loaddata.php");
    }
    elseif ($t == 'quanlytaikhoan' && $query == 'them') {
        include("modules/quanlytaikhoan/add.php");
    } 
    elseif ($t == 'quanlytaikhoan' && $query == 'sua') {
        include("modules/quanlytaikhoan/edit.php");
    } 




    ?>
</div>