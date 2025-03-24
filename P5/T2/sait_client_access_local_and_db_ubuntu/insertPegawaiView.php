<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <style type="text/css">
        .wrapper {
            width: 500px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Add New Employee</h2>
                    </div>
                    <p>Please fill this form and submit to add an employee record to the database.</p>

                    <!-- Form untuk Insert Pegawai -->
                    <form action="insertPegawaiDo.php" method="post">
                        <!-- Input Nama Pegawai -->
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>

                        <!-- Input Jabatan -->
                        <div class="form-group">
                            <label>Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" required>
                        </div>

                        <!-- Dropdown Departemen -->
                        <div class="form-group">
                            <label>Departemen</label>
                            <select name="id_departemen" class="form-control" required>
                                <option value="">Pilih Departemen</option>
                                <?php
                                // Ambil data departemen dari API
                                $curl = curl_init();
                                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                                curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?departemen');
                                $response = curl_exec($curl);
                                curl_close($curl);

                                // Decode JSON
                                $departemenData = json_decode($response, true);

                                // Tampilkan data departemen dalam dropdown
                                if (!empty($departemenData["data"])) {
                                    foreach ($departemenData["data"] as $departemen) {
                                        echo "<option value='" . $departemen["id_departemen"] . "'>" . $departemen["nama_departemen"] . "</option>";
                                    }
                                } else {
                                    echo "<option value=''>Tidak ada departemen</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tombol Submit -->
                        <input type="submit" class="btn btn-primary" name="submit" value="Submit">
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>
