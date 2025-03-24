<?php include '../sqlicon_con.php';

if (isset($_POST['submit'])) {
    $nama_departemen = mysqli_real_escape_string($conn, $_POST['nama_departemen']);

    if (empty($nama_departemen)) {
        echo "<script>alert('Nama departemen harus diisi!')</script>";
    } else {
        $query = "INSERT INTO departemen (nama_departemen) VALUES ('$nama_departemen')";
        if (mysqli_query($conn, $query)) {
            header('Location: ../index.php');
        } else {
            echo "<script>alert('Gagal menambahkan departemen!')</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Departemen</title>
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
                    <h3 class="text-center">Tambah Departemen</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama Departemen:</label>
                            <input type="text" name="nama_departemen" class="form-control" placeholder="Masukkan nama departemen" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success btn-block">
                            <i class="fa fa-plus"></i> Tambah Departemen
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="../index.php" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Kembali ke Daftar Departemen
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
