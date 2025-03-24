<?php

$id_departemen = $_GET['id_departemen'];

//Pastikan sesuai dengan alamat endpoint dari REST API di ubuntu
$url='http://10.33.35.35/sait_api_db_ubuntu/perusahaan_api.php?id_departemen='.$id_departemen.'';


$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
// pastikan method nya adalah delete
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$result = curl_exec($ch);
$result = json_decode($result, true);

curl_close($ch);

//var_dump($result);
// tampilkan return statusnya, apakah sukses atau tidak
print("<center><br>status :  {$result["status"]} "); 
print("<br>");
print("message :  {$result["message"]} "); 
 //
echo "<br>Sukses menghapus data di ubuntu server !";
echo "<br><a href=selectPegawaiView.php> OK </a>";

?>