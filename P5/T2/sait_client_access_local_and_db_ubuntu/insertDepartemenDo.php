<?php
if (isset($_POST['submit'])) {    
    $nama_departemen = $_POST['nama_departemen'];

    // Pastikan URL API benar
    $url = 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?departemen';
    $ch = curl_init($url);

    // Data yang akan dikirim ke REST API
    $jsonData = array(
        'nama_departemen' => $nama_departemen,
    );

    // Encode JSON
    $jsonDataEncoded = json_encode($jsonData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    // Execute request
    $result = curl_exec($ch);
    $http_status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Cek apakah response dari API kosong atau tidak
    if ($result === false) {
        echo "<center><br><b>Gagal menghubungi API!</b>";
        echo "<br>Error: " . curl_error($ch);
        curl_close($ch);
        exit;
    }

    curl_close($ch);
    
    // Decode hasil response API
    $decodedResult = json_decode($result, true);

    // // Debugging: Cek response API
    // echo "<pre>Response API: ";
    // print_r($decodedResult);
    // echo "</pre>";

    // Cek apakah response API valid
    if ($http_status == 200 && is_array($decodedResult) && isset($decodedResult["status"])) {
        echo "<center><br>Status:  {$decodedResult["status"]} ";
        echo "<br>Message:  {$decodedResult["message"]} ";
        echo "<br>Sukses terkirim ke Ubuntu server!";
    } else {
        echo "<center><br><b>Gagal mengirim data!</b>";
        echo "<br>Response tidak valid atau server error.";
        echo "<br>HTTP Status Code: " . $http_status;
    }

    echo "<br><a href='selectPegawaiView.php'> OK </a>";
}
?>
