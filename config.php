<?php
$servername = "localhost";
$user= "root";
$password="";
$database = "si_pariwisata";
$conn = mysqli_connect($servername,$user,$password,$database);

if(!$conn){
    echo "koneksi gagal";
}

?>