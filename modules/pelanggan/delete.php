<?php
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // panggil file config.php untuk koneksi db
    require_once "../../config/config.php";

    // cek data post dr ajax
    if (isset($_POST['id_pelanggan'])) {
        // sql untuk delete
        $query = "DELETE FROM tbl_pelanggan WHERE id_pelanggan=?";

        // prepared statement
        $stmt = $mysqli->prepare($query);

        // hubungkan data dengan prepared statement
        $stmt->bind_param("i", $id_pelanggan);

        // ambil data post dr ajax
        $id_pelanggan = $_POST['id_pelanggan'];

        // jalankan query execute
        $stmt->execute();

        // cek hasil query
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
    // jika tdk ada ajax req
    echo '<script> window.location="../../index.php" </script>';
}
?>