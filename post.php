<?php 
// koneksi database
include "config.php";

$pesan="";
$name = $_POST["name"];


if($_POST["type"] === "insert") {
	$sql = $db->query("SELECT * FROM bayu_ajax_todos WHERE name ='$name'");
	$sqlRows = mysqli_num_rows($sql);

	// Proses Simpan Data
	if($sqlRows>0){
		$pesan = "data sudah ada";
	} else{
		$sql_Insert = $db->query("INSERT INTO bayu_ajax_todos VALUES('','$name', '1')") or die($db->error);
		if($sql_Insert) {
			$pesan = "data berhasil disimpan";
		}
	}

} else if($_POST["type"] === "delete"){
	// Proses Hapus Data
	$sql_Delete = $db->query("DELETE FROM bayu_ajax_todos WHERE name = '$name'") or die($db->error);
	if ($sql_Delete){
		$pesan = "Data berhasil dihapus";
	}
} else if($_POST["type"] === "edit"){
	// Proses Edit Data
	$status = ($_POST["status"] == 0) ? 1 : 0 ;
	$sql_Edit = $db->query("UPDATE bayu_ajax_todos SET is_completed = $status WHERE name = '$name'") or die ($db->error);
	if($sql_Edit){
		$pesan = "data berhasil diubah";
	}
}

echo $pesan;


 


 ?>