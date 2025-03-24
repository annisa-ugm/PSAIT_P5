<?php

$conn = new mysqli('localhost', 'root', "", 'pegawai_db');

if (!$conn) {
    echo "Your connection failed please try again " . mysqli_connect_errno();
}

