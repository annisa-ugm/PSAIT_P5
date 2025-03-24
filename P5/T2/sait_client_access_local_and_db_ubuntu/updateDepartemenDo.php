<?php

if(isset($_POST['submit']))
{    
    $nama_departemen = $_POST['nama_departemen'];
    $id_departemen = $_POST['id_departemen'];

    // URL API
    $url = 'http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?id_departemen='.$id_departemen;

    // Inisialisasi cURL
    $ch = curl_init($url);

    // Data JSON yang akan dikirim ke API
    $jsonData = array(
        'id_departemen' => (int)$id_departemen, // Pastikan tipe data benar
        'nama_departemen' => $nama_departemen,
    );

    // Cek apakah id_departemen benar-benar dikirim
    error_log("Data yang dikirim ke API: " . json_encode($jsonData, JSON_PRETTY_PRINT));

    $jsonDataEncoded = json_encode($jsonData);

    // Konfigurasi cURL
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT"); // Gunakan metode PUT
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonDataEncoded);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json')); 

    // Eksekusi request
    $result = curl_exec($ch);
    
    // Cek apakah cURL mengalami error
    if (curl_errno($ch)) {
        echo "<center><br>Error cURL: " . curl_error($ch);
        curl_close($ch);
        exit;
    }

    // Debug respons dari API
    error_log("Respons API: " . print_r($result, true));
    error_log("Respons API (raw): " . $result);


    // Decode respons JSON
    $result = json_decode($result, true);
    curl_close($ch);

    // Cek apakah respons API valid sebelum mengakses status dan message
    if ($result && isset($result["status"]) && isset($result["message"])) {
        if ($result["status"] == 1) {
            echo "<center><br>Status: {$result["status"]}"; 
            echo "<br>Message: {$result["message"]}"; 
            echo "<br>Sukses mengupdate data di Ubuntu server!";
            echo "<br><a href='selectPegawaiView.php'> OK </a>";
        } else {
            echo "<center><br>Status: {$result["status"]}"; 
            echo "<br>Message: {$result["message"]}"; 
            echo "<br>Gagal mengupdate data!";
        }
    } else {
        echo "<center><br>Gagal mengupdate data! Respons API tidak valid.";
    }
}
?>
