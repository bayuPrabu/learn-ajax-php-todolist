<html>
<head>
	<meta charset="UTF-8">
	<title>To do List</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-4">
				<h3>To <strong>do List</strong>.</h3>
				<table class="table">
					<thead id="thead"></thead>
					<tbody id="content"></tbody>
				</table>
				<form action="" id="create-form">
					<div class="form-group">
						<label for="create-input" style="font-weight: bold">Name :</label>
						<input type="text" placeholder="content..." id="create-input">
					</div>
					<div>
						<h6 class="help-block error-message"></h6>
					</div>
					<div>
						<button class="btn btn-sm btn-default" style="border-color: lightgrey">Create</button>
					</div>
					
				</form>
			</div>
		</div>
	</div>

<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script>
	$(document).ready(function(){

		// Tambah tabel head
		let todohead = $("#thead");
		todohead.append(`
			<tr>
				<th>No.</th>
				<th>Nama</th>
				<th>Keterangan</th>
				<th>Hapus</th>
			</tr>
		`);

		// CRUD
		let app = {
			// Menampilkan Data
			show: function(){
				let todoname = $("#content");
				todoname.html("");

				// Menampilkan data dari database dengan metode GET
				$.get("get.php", function(response){
					let todos = JSON.parse(response);
					
					if(todos.length>0){
						todos.forEach(function(value, index){
							let classtodo = "badge " +(value.is_completed == 1 ? 'badge-success' : 'badge-danger');
							let complete = (value.is_completed ) == 1 ? "" : "complete";

							// Tambah isi tabel 
							todoname.append(`
								<tr style="cursor:pointer">
									<td>${(index+1)}</td>
									<td class="name ${complete}" data-completed= "${value.is_completed}">${value.name}</td>
									<td class="text-center"><span class="${classtodo} boolean" data-completed= "${value.is_completed}" id="${value.name}">${value.is_completed == 1 ? "active" : "no active"} </span></td>
									<td><a href="" class="delete badge badge-warning">delete</a></td>
								</tr>
								`)
							$(".complete").css({"text-decoration-line": "line-through"})
						})	
					}else{
						todoname.append('<tr><td colspan="4" class="bg-secondary text-center text-white">Name is empty</td></tr>')
					}	
				})
			},

			// Read Data Error
			showError : function(pesan){
				$(".error-message").html(pesan).css({"color":"red"}).slideDown("slow");
				setTimeout(function(){
					$(".error-message").html("")
				}, 3000)
			},

			// Save Data
			save: function(data){
				data.preventDefault();
				let input = $("#create-input");
				let text = input.val();
				let errorMessage = null				

				// Pesan error
				if(text === ""){
					errorMessage = "nama wajib diisi"
				} else if (text.length<3){
					errorMessage = "minimal 3 karakter"
				} else if(text.length>15){
					errorMessage = "maksimal 15 karakter"
				} 

				// Jalankan Fungsi error
				if(errorMessage){
					app.showError(errorMessage);
					return false
				}
					
				// melakukan request POST untuk simpan data
				$.post("post.php", {name:text, type:"insert"}, function(response){
					app.showError(response);
					input.val("");
				})
				app.show();
			},

			// Toggle Boolean Pada List Nama
			toggle: function(key){
				let elemen = $(this).text();
				let status = $(this).data("completed");
				console.log(status);
				$.ajax({
					url : "post.php",
					method : "POST",
					data : {name : elemen, type:"edit", status:status},
					success : function(response){
						app.showError(response);
					}
				})
				app.show();
			},

			// Toggle Boolean Pada List Keterangan
			toggleValue: function(){
				let elemen = $(this).attr("id");
				let status = $(this).data('completed');
				console.log(status)

				$.ajax({
					url : "post.php",
					method : "POST",
					data : {name:elemen, type:"edit", status:status},
					success: function(response){
						app.showError(response);
					}
				})
				app.show();
			},

			// Delete data
			delete: function(event){
				event.preventDefault(); /*mencegah sifat asli dari href*/
				let text = $(this).parent("td").prev().prev().text();
				let notice = confirm("yakin hapus ini ?");

				if (notice>0) {
					$.ajax({
						url: "post.php",
						method: "POST",
						data: {name: text, type: "delete"},
						success: function(response){
							app.showError(response);
						}
					})	
				}
				app.show();
			}
		}

		// Jalankan Fungsi to do list 
		app.show();
		$("#create-form").on("submit", app.save);
		$(document).on("click", ".name", app.toggle);
		$(document).on("click", ".boolean",app.toggleValue);
		$(document).on("click", ".delete", app.delete);
	})
</script>
</body>
</html>