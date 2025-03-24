<?php
require_once "config.php";
$request_method = $_SERVER["REQUEST_METHOD"];

switch ($request_method) {
   case 'GET':
      if (!empty($_GET["id_pegawai"])) {
          $id = intval($_GET["id_pegawai"]);
          get_pegawai($id);
      } else if (!empty($_GET["id_departemen"])) {
          $id = intval($_GET["id_departemen"]);
          get_departemen($id);
      } else if (isset($_GET["departemen"])) { 
          get_all_departemen();
      } else {
          get_all_pegawai();
      }
      break;
   case 'POST':
      $data = json_decode(file_get_contents("php://input"), true);
   
      if (isset($data["id_pegawai"])) {
         update_pegawai($data["id_pegawai"], $data);
      } elseif (isset($data["id_departemen"]) && isset($data["nama_departemen"])) {
            update_departemen($data);
      } elseif (isset($data["nama_departemen"])) {
            insert_departemen($data);
      } elseif (isset($data["nama"]) && isset($data["jabatan"])) {
            insert_pegawai($data);
      } else {
            echo json_encode(["status" => 0, "message" => "Parameter Do Not Match"]);
      }
      break;
   case 'PUT':
      $data = json_decode(file_get_contents("php://input"), true);
      parse_str($_SERVER['QUERY_STRING'], $query_params);
   
      if (isset($query_params["id_pegawai"])) {
            update_pegawai($query_params["id_pegawai"], $data);
      } elseif (isset($query_params["id_departemen"])) { 
            update_departemen($data);
      } else {
            echo json_encode(["status" => 0, "message" => "ID Pegawai or ID Departemen is required"]);
      }
      break;
   case 'DELETE':
         if (!empty($_GET["id_pegawai"])) {
            $id = intval($_GET["id_pegawai"]);
            delete_pegawai($id);
         } else if (!empty($_GET["id_departemen"])) {
            $id = intval($_GET["id_departemen"]);
            delete_departemen($id);
         }
         break;
   default:
         header("HTTP/1.0 405 Method Not Allowed");
         break;
}

/* ======= FUNGSI CRUD ======= */

function get_all_pegawai()
{
    global $mysqli;
    $query = "SELECT pegawai.*, GROUP_CONCAT(departemen.nama_departemen SEPARATOR ', ') AS departemen
              FROM pegawai
              LEFT JOIN departemen_pegawai ON pegawai.id_pegawai = departemen_pegawai.id_pegawai
              LEFT JOIN departemen ON departemen_pegawai.id_departemen = departemen.id_departemen
              GROUP BY pegawai.id_pegawai";
    $result = $mysqli->query($query);
    $data = [];
    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode(["status" => 1, "message" => "Get List Pegawai Successfully.", "data" => $data]);
}

function get_pegawai($id)
{
    global $mysqli;
    $query = "
        SELECT p.id_pegawai, p.nama, p.jabatan, 
               GROUP_CONCAT(d.nama_departemen SEPARATOR ', ') AS departemen
        FROM pegawai p
        LEFT JOIN departemen_pegawai dp ON p.id_pegawai = dp.id_pegawai
        LEFT JOIN departemen d ON dp.id_departemen = d.id_departemen
        WHERE p.id_pegawai = $id
        GROUP BY p.id_pegawai
    ";

    $result = mysqli_query($mysqli, $query);

    if ($result) {
        $row = mysqli_fetch_assoc($result);
        echo json_encode(["status" => 1, "message" => "Get Pegawai Successfully.", "data" => $row]);
    } else {
        echo json_encode(["status" => 0, "message" => "Pegawai Not Found"]);
    }
}

function insert_pegawai($data)
{
    global $mysqli;

    if (!empty($data["nama"]) && !empty($data["jabatan"])) {
        $nama = mysqli_real_escape_string($mysqli, $data["nama"]);
        $jabatan = mysqli_real_escape_string($mysqli, $data["jabatan"]);
        $departemen = isset($data["id_departemen"]) && is_array($data["id_departemen"]) ? $data["id_departemen"] : [];

        $query = "INSERT INTO pegawai (nama, jabatan) VALUES ('$nama', '$jabatan')";
        $result = mysqli_query($mysqli, $query);

        if ($result) {
            $id_pegawai = $mysqli->insert_id;

            if (!empty($departemen)) {
                foreach ($departemen as $id_dep) {
                    $id_dep = intval($id_dep); 

                    $cek_dep = mysqli_query($mysqli, "SELECT id_departemen FROM departemen WHERE id_departemen = $id_dep");
                    if (mysqli_num_rows($cek_dep) > 0) {
                        mysqli_query($mysqli, "INSERT INTO departemen_pegawai (id_pegawai, id_departemen) VALUES ($id_pegawai, $id_dep)");
                    }
                }
            }

            echo json_encode(["status" => 1, "message" => "Pegawai Added Successfully."]);
        } else {
            echo json_encode(["status" => 0, "message" => "Failed to add pegawai."]);
        }
    } else {
        echo json_encode(["status" => 0, "message" => "Parameter Do Not Match"]);
    }
}


function update_pegawai($data)
{
    header("Content-Type: application/json");
    global $mysqli;
    $id = $data['id_pegawai']; 

    if (!empty($data["nama"]) || !empty($data["jabatan"]) || isset($data["id_departemen"])) {
        $query = "UPDATE pegawai SET ";
        $updates = [];

        if (!empty($data["nama"])) {
            $updates[] = "nama = '{$data['nama']}'";
        }
        if (!empty($data["jabatan"])) {
            $updates[] = "jabatan = '{$data['jabatan']}'";
        }

        if (!empty($updates)) {
            $query .= implode(", ", $updates) . " WHERE id_pegawai = $id";
            $result = mysqli_query($mysqli, $query);
            if (!$result) {
                echo json_encode(["status" => 0, "message" => "Failed to update pegawai."]);
                return;
            }
        }

        mysqli_query($mysqli, "DELETE FROM departemen_pegawai WHERE id_pegawai = $id");

        if (!empty($data["id_departemen"]) && is_array($data["id_departemen"])) {
            foreach ($data["id_departemen"] as $id_dep) {
                $query_dep = "INSERT INTO departemen_pegawai (id_pegawai, id_departemen) 
                VALUES ($id, $id_dep)";
                mysqli_query($mysqli, $query_dep);
            }
        }
        echo json_encode(["status" => 1, "message" => "Pegawai Updated Successfully."]);
    } else {
        echo json_encode(["status" => 0, "message" => "Parameter Do Not Match"]);
    }
}


function delete_pegawai($id)
{
    global $mysqli;
    $query = "DELETE FROM pegawai WHERE id_pegawai = $id";
    $result = mysqli_query($mysqli, $query);
    echo json_encode(["status" => 1, "message" => "Pegawai Deleted Successfully."]);
}

function get_all_departemen()
{
    global $mysqli;
    $query = "SELECT * FROM departemen";
    $result = $mysqli->query($query);
    $data = [];
    while ($row = mysqli_fetch_object($result)) {
        $data[] = $row;
    }
    header('Content-Type: application/json');
    echo json_encode(["status" => 1, "message" => "Get List Departemen Successfully.", 
    "data" => $data]);
}

function get_departemen($id = 0)
{
    global $mysqli;
    $query = "SELECT * FROM departemen";
    if ($id != 0) {
        $query .= " WHERE id_departemen = " . $id . " LIMIT 1";
    }
    $result = $mysqli->query($query);
    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
    header('Content-Type: application/json');
    echo json_encode(["status" => 1, "message" => "Get Departemen Successfully.", "data" => $data]);
}

function insert_departemen($data)
{
    global $mysqli;
    if (!empty($data["nama_departemen"])) {
        $nama = $data["nama_departemen"];
        $result = mysqli_query($mysqli, "INSERT INTO departemen (nama_departemen) VALUES ('$nama')");
        echo json_encode(["status" => 1, "message" => "Departemen Added Successfully."]);
    } else {
        echo json_encode(["status" => 0, "message" => "Parameter Do Not Match"]);
    }
}

function update_departemen($data) {
   global $mysqli;

   if (!empty($data["id_departemen"]) && !empty($data["nama_departemen"])) {
       $id_departemen = intval($data["id_departemen"]); 
       $nama_departemen = mysqli_real_escape_string($mysqli, $data["nama_departemen"]); 

       $query = "UPDATE departemen SET nama_departemen = '$nama_departemen' 
       WHERE id_departemen = $id_departemen";
       $result = mysqli_query($mysqli, $query);

       if ($result) {
           echo json_encode(["status" => 1, "message" => "Departemen Updated Successfully."]);
       } else {
           echo json_encode(["status" => 0, "message" => "Departemen Update Failed."]);
       }
   } else {
       echo json_encode(["status" => 0, "message" => "Parameter Do Not Match"]);
   }
}

function delete_departemen($id) {
   global $mysqli;
   $query = "DELETE FROM departemen WHERE id_departemen=" . $id;
   $result = mysqli_query($mysqli, $query);
   echo json_encode(['status' => $result ? 1 : 0, 
   'message' => $result ? 'Departemen Deleted Successfully.' : 'Departemen Deletion Failed.']);
}

?>
