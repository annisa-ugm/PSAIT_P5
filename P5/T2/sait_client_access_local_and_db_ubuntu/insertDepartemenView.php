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
                        <h2>Add New Department</h2>
                    </div>
                    <p>Please fill this form and submit to add a department record to the database.</p>

                    <!-- Form untuk Insert Pegawai -->
                    <form action="insertDepartemenDo.php" method="post">
                        <!-- Input Nama Pegawai -->
                        <div class="form-group">
                            <label>Nama Departemen</label>
                            <input type="text" name="nama_departemen" class="form-control" required>
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
