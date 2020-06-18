<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

	<title>Sekawan Media</title>
</head>
<body>
	<div class="container my-3">
		<div id="action" class="mb-2">
			<button type="button" class="btn btn-primary" id="refresh">Muat Ulang</button>
			<button type="button" class="btn btn-success" id="save">Simpan</button>
		</div>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th scope="col">No</th>
					<th scope="col">ID Peg</th>
					<th scope="col">Nama Pegawai</th>
					<th scope="col">Gaji</th>
					<th scope="col">Usia</th>
					<th scope="col">Foto</th>
				</tr>
			</thead>
			<tbody></tbody>
		</table>
	</div>

	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script>
		var state;

		function draw(data){
			$('tbody').empty();

			state.forEach(function(item, i){
				$('<tr></tr>')
					.append($('<td></td>').text(i+1))
					.append($('<td></td>').text(item.id))
					.append($('<td></td>').text(item.employee_name))
					.append($('<td></td>').text(item.employee_salary))
					.append($('<td></td>').text(item.employee_age))
					.append($('<td></td>').append(
						$('<img>').attr('src', item.profile_image).css('max-height', '200px')
					))
					.appendTo($('tbody'));
			});
		}

		function refresh(){
			$('#refresh').attr('disabled', 'disabled');

			$.ajax({
				url: "<?= base_url('home/fetch') ?>",
				method: 'get',
				dataType: 'json',
				success: function(data){
					state = data;
					draw();
				},
				error: function(){
					alert('Terjadi kesalahan');
				},
				complete: function(){
					$('#refresh').removeAttr('disabled');
				}
			});
		}

		function save(){
			$('#save').attr('disabled', 'disabled');

			$.ajax({
				url: "<?= base_url('home/save') ?>",
				method: 'post',
				dataType: 'json',
				data: {
					data: state
				},
				success: function(data){
					alert(data.message);
				},
				error: function(){
					alert('Terjadi kesalahan');
				},
				complete: function(){
					$('#save').removeAttr('disabled');
				}
			});
		}

		$(document).ready(function(){
			refresh();

			$('#refresh').click(function(){
				refresh();
			});

			$('#save').click(function(){
				save();
			});
		});
	</script>
</body>
</html>