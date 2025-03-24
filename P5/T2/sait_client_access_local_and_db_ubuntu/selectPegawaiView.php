<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 800px;
            margin: 0 auto;
        }
        .scroll {
            width: 100%;
            max-height: 400px;
            overflow-y: auto;
        }
        table tr td:last-child {
            width: 150px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="wrapper">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    
                    <!-- Tabel Pegawai -->
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Pegawai</h2>
                        <a href="insertPegawaiView.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                    <div class="scroll">
                        <?php
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php');
                        $res = curl_exec($curl);
                        $json = json_decode($res, true);
                        curl_close($curl);

                        if (!empty($json["data"])) {
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Name</th>";
                                        echo "<th>Jabatan</th>";
                                        echo "<th>Departemen</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($json["data"] as $pegawai) {
                                    echo "<tr>";
                                        echo "<td>{$pegawai["id_pegawai"]}</td>";
                                        echo "<td>{$pegawai["nama"]}</td>";
                                        echo "<td>{$pegawai["jabatan"]}</td>";
                                        echo "<td>{$pegawai["departemen"]}</td>";
                                        echo "<td>";
                                            echo '<a href="updatePegawaiView.php?id_pegawai='. $pegawai["id_pegawai"] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="deletePegawaiDo.php?id_pegawai='. $pegawai["id_pegawai"] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        } else {
                            echo "<p class='text-danger'>Tidak ada data pegawai.</p>";
                        }
                        ?>
                    </div>

                    <!-- Tabel Departemen -->
                    <div class="mt-5 mb-3 clearfix">
                        <h2 class="pull-left">Departemen</h2>
                        <a href="insertDepartemenView.php" class="btn btn-success pull-right"><i class="fa fa-plus"></i> Add New</a>
                    </div>
                    <div class="scroll">
                        <?php
                        $curl = curl_init();
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_URL, 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?departemen');
                        $res = curl_exec($curl);
                        $json = json_decode($res, true);
                        curl_close($curl);

                        if (!empty($json["data"])) {
                            echo '<table class="table table-bordered table-striped">';
                                echo "<thead>";
                                    echo "<tr>";
                                        echo "<th>#</th>";
                                        echo "<th>Nama Departemen</th>";
                                        echo "<th>Action</th>";
                                    echo "</tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                foreach ($json["data"] as $departemen) {
                                    echo "<tr>";
                                        echo "<td>{$departemen["id_departemen"]}</td>";
                                        echo "<td>{$departemen["nama_departemen"]}</td>";
                                        echo "<td>";
                                            echo '<a href="updateDepartemenView.php?id_departemen='. $departemen["id_departemen"] .'" class="mr-3" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></span></a>';
                                            echo '<a href="deleteDepartemenDo.php?id_departemen='. $departemen["id_departemen"] .'" title="Delete Record" data-toggle="tooltip"><span class="fa fa-trash"></span></a>';
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                        } else {
                            echo "<p class='text-danger'>Tidak ada data departemen.</p>";
                        }
                        ?>
                    </div>

                </div>
            </div>        
        </div>
    </div>
</body>
</html>
