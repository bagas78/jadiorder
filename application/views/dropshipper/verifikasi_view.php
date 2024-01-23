<!-- sweet alert -->
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">Verifikasi Data</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">

			<button onclick="history.back()" class="btn btn-primary"><i class="fa fa-chevron-circle-left "></i> Kembali</button>
			<div class="clearfix"></div><br/>

			<table class="table table-bordered table-striped">
				<tr>
					<td>Nama Lengkap</td>
					<td><?=@$data['nama']?></td>
				</tr>
				<tr>
					<td>Tempat, Tanggal Lahir</td>
					<td><?=@$data['kota']?>, <?= date_format(date_create(@$data['lahir_tanggal']), 'd/m/Y')?></td>
				</tr>
				<tr>
					<td>Jenis Kelamin</td>
					<td><?=(@$data['kelamin'] == 'l')?'Laki-Laki':'Perempuan'?></td>
				</tr>
				<tr>
					<td>Alamat</td>
					<td><?=@$data['alamat']?></td>
				</tr>
				<tr>
					<td>Agama</td>
					<td><?=@$data['agama']?></td>
				</tr>
				<tr>
					<td>Status Perkawinan</td>
					<td><?=@$data['kawin']?></td>
				</tr>
				<tr>
					<td>Pekerjaan</td>
					<td><?=@$data['pekerjaan']?></td>
				</tr>
				<tr>
					<td>Kewarganegaraan</td>
					<td><?=strtoupper(@$data['kewarganegaraan'])?></td>
				</tr>
			</table>

		</div>
	</div>
</div>