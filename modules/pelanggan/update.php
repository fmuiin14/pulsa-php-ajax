<?php 

// cek ajax req
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // panggil file config.php untuk koneksi ke db
    require_once "../../config/config.php";

    // cek data post dr ajax
    if (isset($_POST['id_pelanggan'])) {
        // sql untuk update data di table pelanggan
        $query = "UPDATE tbl_pelanggan SET nama = ?, no_hp = ? WHERE id_pelanggan = ?";

        // membuat prepared statement
        $stmt = $mysqli->prepare($query);

        // hubungkan 'data' dengan prepared statement
        $stmt->bind_param("ssi", $nama, $no_hp, $id_pelanggan);

        // ambil data hasil post dr ajax
        $id_pelanggan = trim($_POST['id_pelanggan']);
        $nama = trim($_POST['nama']);
        $no_hp = trim($_POST['no_hp']);

        // jalankan query
        $stmt->execute();

        // cek query
        if ($stmt) {
            echo "Sukses";
        } else {
            echo "Gagal";
        }

        // tutup statement
        $stmt->close();
    }
    // tutup koneksi
    $mysqli->close();
} else {
    echo '<script>window.location="../../index.php"</script>';
}

?>