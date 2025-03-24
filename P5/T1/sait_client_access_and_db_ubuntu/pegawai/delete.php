<?php
include '../sqlicon_con.php';

$id = $_GET['id'];
$query = "DELETE FROM pegawai WHERE id_pegawai = $id";

if (mysqli_query($conn, $query)) {
    header("Location: ../index.php");
} else {
    echo "<script>alert('Gagal menghapus data!')</script>";
}
?>

