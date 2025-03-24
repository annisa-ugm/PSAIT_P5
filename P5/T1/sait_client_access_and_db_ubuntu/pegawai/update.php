<?php include '../sqlicon_con.php';

$id = $_GET['uid'];

$query = "SELECT * FROM pegawai WHERE id_pegawai = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

$departemenQuery = "SELECT * FROM departemen";
$departemenResult = mysqli_query($conn, $departemenQuery);

$selectedDepartemenQuery = "SELECT id_departemen FROM departemen_pegawai WHERE id_pegawai = $id";
$selectedDepartemenResult = mysqli_query($conn, $selectedDepartemenQuery);
$selectedDepartemen = mysqli_fetch_assoc($selectedDepartemenResult)['id_departemen'] ?? '';

if (isset($_POST['submit'])) {
    $nama = $_POST['nama'];
    $jabatan = $_POST['jabatan'];
    $departemenTerpilih = $_POST['departemen']; 

    $updateQuery = "UPDATE pegawai SET nama='$nama', jabatan='$jabatan' WHERE id_pegawai=$id";
    if (mysqli_query($conn, $updateQuery)) {
        mysqli_query($conn, "DELETE FROM departemen_pegawai WHERE id_pegawai=$id");

        mysqli_query($conn, "INSERT INTO departemen_pegawai (id_pegawai, id_departemen) 
        VALUES ($id, $departemenTerpilih)");

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
    <title>Update Pegawai</title>
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
                    <h3 class="text-center"><i class="fa fa-pencil"></i> Update Pegawai</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label>Nama:</label>
                            <input type="text" name="nama" value="<?= $row['nama'] ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Jabatan:</label>
                            <input type="text" name="jabatan" value="<?= $row['jabatan'] ?>" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Departemen:</label>
                            <select name="departemen" class="form-control">
                                <?php while ($dep = mysqli_fetch_assoc($departemenResult)) : ?>
                                    <option value="<?= $dep['id_departemen'] ?>" 
                                        <?= ($dep['id_departemen'] == $selectedDepartemen) ? 'selected' : '' ?>>
                                        <?= $dep['nama_departemen'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
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
