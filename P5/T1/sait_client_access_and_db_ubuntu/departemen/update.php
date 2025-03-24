<?php include '../sqlicon_con.php';

$id = $_GET['uid'];

$query = "SELECT * FROM departemen WHERE id_departemen = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

if (isset($_POST['submit'])) {
    $nama_departemen = $_POST['nama_departemen'];

    $updateQuery = "UPDATE departemen SET nama_departemen='$nama_departemen' WHERE id_departemen=$id";
    if (mysqli_query($conn, $updateQuery)) {
        header('Location: ../index.php');
    } else {
        echo "<script>alert('Gagal memperbarui data!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Departemen</title>
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
                <div class="card-header bg-warning text-white">
                    <h3 class="text-center"><i class="fa fa-pencil"></i> Update Departemen</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama Departemen:</label>
                            <input type="text" name="nama_departemen" class="form-control" 
                            value="<?= $row['nama_departemen'] ?>" required>
                        </div>

                        <button type="submit" name="submit" class="btn btn-success btn-block">
                            <i class="fa fa-save"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="../index.php" class="btn btn-danger">
                        <i class="fa fa-times"></i> Batal
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
