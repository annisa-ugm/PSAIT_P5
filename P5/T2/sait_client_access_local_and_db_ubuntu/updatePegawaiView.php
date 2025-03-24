<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Data Pegawai</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>

<?php
$id_pegawai = $_GET['id_pegawai'];

// Ambil data pegawai berdasarkan ID
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?id_pegawai=' . $id_pegawai);
$res = curl_exec($curl);
$pegawaiData = json_decode($res, true);
curl_close($curl);

// // DEBUG: Tampilkan data API untuk melihat apakah respons API benar
// echo "<pre>";
// var_dump($pegawaiData);
// echo "</pre>";

$nama = isset($pegawaiData["data"]["nama"]) ? $pegawaiData["data"]["nama"] : "";
$jabatan = isset($pegawaiData["data"]["jabatan"]) ? $pegawaiData["data"]["jabatan"] : "";
$nama_departemen = isset($pegawaiData["data"]["departemen"]) ? $pegawaiData["data"]["departemen"] : "";

// Ambil daftar departemen untuk dropdown
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?departemen'); // Pastikan URL API benar
$res = curl_exec($curl);
$departemenData = json_decode($res, true);
curl_close($curl);
?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Update Data Pegawai</h2>
                </div>
                <p>Silakan isi formulir berikut untuk memperbarui data pegawai.</p>
                <form action="updatePegawaiDo.php" method="post">
                    <input type="hidden" name="id_pegawai" value="<?php echo $id_pegawai; ?>">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo $nama; ?>">
                    </div>
                    <div class="form-group">
                        <label>Jabatan</label>
                        <input type="text" name="jabatan" class="form-control" value="<?php echo $jabatan; ?>">
                    </div>
                    <div class="form-group">
                        <label>Departemen</label>
                        <select name="nama_departeme" class="form-control">
                            <option value="<?php echo $nama_departeme; ?>" selected><?php echo $nama_departemen; ?></option>
                            <?php
                            if (!empty($departemenData["data"])) {
                                foreach ($departemenData["data"] as $dept) {
                                    echo "<option value='" . $dept["id_departemen"] . "'>" . $dept["nama_departemen"] . "</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <input type="submit" class="btn btn-primary" name="submit" value="Update">
                </form>
            </div>
        </div>        
    </div>
</div>

</body>
</html>
