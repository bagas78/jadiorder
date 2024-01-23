<!-- sweet alert -->
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">No Rekening</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">

			<form method="POST" action="<?=base_url('update_akun/rekening_save')?>">
				<div class="form-group">
					<label>Nama Bank</label>
					<input id="bank" type="text" name="bank" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Atas Nama</label>
					<input id="nama" type="text" name="nama" class="form-control" required>
				</div>
				<div class="form-group">
					<label>Kode Bank</label>
					<input id="kode" type="number" name="kode" class="form-control" required>
				</div>
				<div class="form-group">
					<label>No Rekening</label>
					<input id="rekening" type="number" name="rekening" class="form-control" required>
				</div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
					<button type="button" onclick="history.back()" class="btn btn-danger"><i class="fa fa-times"></i> Batal</button>
				</div>
			</form>

		</div>
	</div>
</div>