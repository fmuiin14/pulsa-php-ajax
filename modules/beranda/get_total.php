<?php
// cek AJAX req
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
    // panggil file config.php untuk konek database
    require_once "../../config/config.php";

    // sql statement untuk menampilkan jumlah data dari tabel pelanggan
    $query = "SELECT sum(jumlah_bayar) as total FROM tbl_penjualan";

    // membuat prepared statements
    $stmt = $mysqli->prepare($query);
    // cek query
    if(!$stmt) {//jika error
        die('Query error: ' . $mysqli->errno.'-'.$mysqli->error);
}

// jalankan query: execute
$stmt->execute();

// ambil hasil query
$result = $stmt->get_result();

// tampilkan hasil query
$data = $result->fetch_assoc();

// tampilkan data
echo number_format($data['total']);

// tutup statement
$stmt->close();

// tutup koneksi
$mysqli->close();
} else {
    // jika tidak ada ajax req, alihkan ke halaman index.php
    echo '<script>window.location="../../index.php"</script>';
}

?>