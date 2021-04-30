<?php 
// koneksi database
include "config.php";

// tampung data
$data = [];

// query data
$sql = $db->query("SELECT * FROM bayu_ajax_todos ORDER BY name ASC");

// looping data dari database
while($row = $sql->fetch_object()){
	$data[]=$row;
}

// kirim data
echo json_encode($data);
 ?>