<?php 

// cek ajax req
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // panggil file config.php untuk koneksi database
    require_once "../../config/config.php";

    // sql untuk insert data ke table pelanggan
    $query = "INSERT INTO tbl_pelanggan(nama, no_hp) VALUES (?,?)";

    // membuat prepared statements
    $stmt = $mysqli->prepare($query);

    // hubungkan data dengan prepared statements
    $stmt->bind_param("ss", $nama, $no_hp);

    // ambil data hasil post dr ajax
    $nama = trim($_POST['nama']);
    $no_hp = trim($_POST['no_hp']);

    // jalankan query execute
    $stmt->execute();

    // cek query
    if($stmt) {
        echo "Sukses";
    } else {
        echo "Gagal";
    }

    // tutup statement
    $stmt->close();

    // tutup koneksi
    $mysqli->close();
} else {
    echo '<script>window.location="../../index.php"</script>';
}

?>