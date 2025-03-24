<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Data Departemen</title>
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
$id_departemen = $_GET['id_departemen'];

// Ambil data pegawai berdasarkan ID
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?id_departemen=' . $id_departemen);
$res = curl_exec($curl);
$pegawaiData = json_decode($res, true);
curl_close($curl);

// // DEBUG: Tampilkan data API untuk melihat apakah respons API benar
// echo "<pre>";
// var_dump($pegawaiData);
// echo "</pre>";

$nama_departemen = isset($pegawaiData["data"][0]["nama_departemen"]) ? $pegawaiData["data"][0]["nama_departemen"] : "";

?>

<div class="wrapper">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="page-header">
                    <h2>Update Data Departemen</h2>
                </div>
                <p>Silakan isi formulir berikut untuk memperbarui data departemen.</p>
                <form action="updateDepartemenDo.php" method="post">
                    <input type="hidden" name="id_departemen" value="<?php echo $id_departemen; ?>">
                    <div class="form-group">
                        <label>Nama Departemen</label>
                        <input type="text" name="nama_departemen" class="form-control" value="<?php echo $nama_departemen; ?>">
                    </div>

                    <input type="submit" class="btn btn-primary" name="submit" value="Update">
                </form>
            </div>
        </div>        
    </div>
</div>

</body>
</html>
