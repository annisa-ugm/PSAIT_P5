<?php include "sqlicon_con.php"; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Pegawai</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper {
            width: 80%;
            margin: 20px auto;
        }
        table {
            width: 100%;
        }
        th, td {
            text-align: left;
            padding: 10px;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .btn-custom {
            padding: 5px 10px;
            font-size: 14px;
            border-radius: 5px;
        }
        .btn-sm i {
            margin-right: 3px;
        }
        
        /* Pastikan kolom "Nomor" di kedua tabel sama */
        .table th:nth-child(1), .table td:nth-child(1) { 
            width: 5%; /* Lebar tetap untuk kolom Nomor */
        }
        
        /* Lebar kolom "Aksi" agar lebih kecil */
        .table th:last-child, .table td:last-child { 
            width: 15%;
        }
    </style>
</head>

<body>
<div class="wrapper">
    <h2 class="text-center">Data Pegawai dan Departemen</h2>

    <!-- Daftar Pegawai -->
    <div class="mb-4">
        <h3>Daftar Pegawai</h3>
        <a href="pegawai/create.php" class="btn btn-success btn-sm btn-custom">
            <i class="fa fa-plus"></i> Tambah Pegawai
        </a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama Pegawai</th>
                    <th>Jabatan</th>
                    <th>Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query = "SELECT pegawai.id_pegawai, pegawai.nama, pegawai.jabatan, 
                             GROUP_CONCAT(departemen.nama_departemen SEPARATOR ', ') as departemen
                      FROM pegawai
                      LEFT JOIN departemen_pegawai ON pegawai.id_pegawai = departemen_pegawai.id_pegawai
                      LEFT JOIN departemen ON departemen_pegawai.id_departemen = departemen.id_departemen
                      GROUP BY pegawai.id_pegawai";
            $result = mysqli_query($conn, $query);
            while ($value = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?= $value['id_pegawai'] ?></td>
                    <td><?= $value['nama'] ?></td>
                    <td><?= $value['jabatan'] ?></td>
                    <td><?= $value['departemen'] ?></td>
                    <td>
                        <a href="pegawai/update.php?uid=<?= $value['id_pegawai'] ?>" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="pegawai/delete.php?id=<?= $value['id_pegawai'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Daftar Departemen -->
    <div>
        <h3>Daftar Departemen</h3>
        <a href="departemen/create.php" class="btn btn-success btn-sm btn-custom">
            <i class="fa fa-plus"></i> Tambah Departemen
        </a>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>Nomor</th>
                    <th>Nama Departemen</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $query_dep = "SELECT * FROM departemen";
            $result_dep = mysqli_query($conn, $query_dep);
            while ($dep = mysqli_fetch_assoc($result_dep)) : ?>
                <tr>
                    <td><?= $dep['id_departemen'] ?></td>
                    <td><?= $dep['nama_departemen'] ?></td>
                    <td>
                        <a href="departemen/update.php?uid=<?= $dep['id_departemen'] ?>" class="btn btn-warning btn-sm">
                            <i class="fa fa-pencil"></i> Edit
                        </a>
                        <a href="departemen/delete.php?id=<?= $dep['id_departemen'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus?')">
                            <i class="fa fa-trash"></i> Hapus
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
