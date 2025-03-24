<?php include '../sqlicon_con.php';

$departemenQuery = "SELECT * FROM departemen";
$departemenResult = mysqli_query($conn, $departemenQuery);

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $jabatan = mysqli_real_escape_string($conn, $_POST['jabatan']);
    $departemenTerpilih = $_POST['departemen']; 

    if (empty($nama) || empty($jabatan) || empty($departemenTerpilih)) {
        echo "<script>alert('Semua kolom harus diisi!')</script>";
    } else {
        $query = "INSERT INTO pegawai (nama, jabatan) VALUES ('$nama', '$jabatan')";
        if (mysqli_query($conn, $query)) {
            $last_id = mysqli_insert_id($conn);

            mysqli_query($conn, "INSERT INTO departemen_pegawai (id_pegawai, id_departemen) 
            VALUES ($last_id, $departemenTerpilih)");

            header('Location: ../index.php');
        } else {
            echo "<script>alert('Gagal menambahkan pegawai!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pegawai</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card mt-5">
                <div class="card-header bg-primary text-white">
                    <h3 class="text-center">Tambah Pegawai</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama:</label>
                            <input type="text" name="nama" class="form-control" placeholder="Masukkan nama pegawai" required>
                        </div>

                        <div class="form-group">
                            <label>Jabatan:</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Masukkan jabatan" required>
                        </div>

                        <div class="form-group">
                            <label>Departemen:</label>
                            <select name="departemen" class="form-control" required>
                                <option value="">Pilih Departemen</option>
                                <?php while ($dep = mysqli_fetch_assoc($departemenResult)) : ?>
                                    <option value="<?= $dep['id_departemen'] ?>"><?= $dep['nama_departemen'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success btn-block">
                            <i class="fa fa-plus"></i> Tambah Pegawai
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="../index.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Pegawai
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
