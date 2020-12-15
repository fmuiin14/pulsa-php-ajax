<?php 
// cek ajax req
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // panggil untuk koneksi db
    require_once "../../config/config.php";

    // cek data get dr ajax
    if (isset($_GET['id_pelanggan'])) {
        // sql untuk menampilkan data dr table pelanggan berdasarkan id_pelanggan
        $query = "SELECT * FROM tbl_pelanggan WHERE id_pelanggan=?";

        // membuat prepared statement
        $stmt = $mysqli->prepare($query);

        // cel query
        if (!$stmt) {
            die('Query Error: ' .$mysqli->errno.'-'.$mysqli->error);
        }

        // ambil data get dr ajax
        $id_pelanggan = $_GET['id_pelanggan'];

        // hubungkan 'data' dengan prepared statement
        $stmt->bind_param("i", $id_pelanggan);

        // jalankan query execute
        $stmt->execute();

        // ambil hasil query
        $result = $stmt->get_result();

        // tampilkan hasil query
        $data = $result->fetch_assoc();

        // tutup statement
        $stmt->close();
    }

    // tutup koneksi
    $mysqli->close();

    echo json_decode($data);
} else {
    // jika tidak ada ajax req
    echo '<script>window.location="../../index.php"</script>';
}

?>