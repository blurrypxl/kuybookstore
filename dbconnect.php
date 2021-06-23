<?php 
// isi nama host, username mysql, dan password mysql anda
$conn = mysqli_connect("localhost","root","","db_toko_buku");

if(!$conn){
	echo "gagal konek database menn";
}
?>
