<?php 

$servername = "localhost";
$name = "root";
$password = "";
$dbname = "webmaster";

$db = new mysqli($servername, $name, $password, $dbname);

if($db->connect_errno){
	die("koneksi tidak terhubung ...");
 }
