<!-- sweet alert -->
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">Verifikasi Data</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Nama</th>
						<th>Data</th>
						<th>KTP</th>
						<th>Pembayaran</th>
						<th>Status</th>
						<th width="200">Aksi</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach (@$data as $v): ?>
						
						<tr>
							<td><?=$v['nama']?></td>
							<td><a href="<?=base_url('update_akun/verifikasi_view/'.$v['id'])?>"><button class="btn btn-info"><i class="fa fa-eye"></i> Lihat</button></a></td>
							<td><a target="_BLANK" href="<?=base_url($v['ktp'])?>"><button class="btn btn-info"><i class="fa fa-image"></i> Lihat</button></a></td>
							<td><a target="_BLANK" href="<?=base_url($v['pembayaran'])?>"><button class="btn btn-info"><i class="fa fa-image"></i> Lihat</button></a></td>
							<td><?=($v['status'] == 3)?'<span class="text-success">Sudah di verfikasi</span>':'<span class="text-danger">Belum di verifikasi</span>'?></td>
							<td>
								<button <?= ($v['status'] == 3)?'style="pointer-events: none;" disabled':'' ?> type="button" onclick="ver('<?=$v['id']?>')" class="btn btn-primary btn-sm"><i class="fa fa-check"></i> Verifikasi</button>
								<button type="button" onclick="del('<?=$v['id']?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
							</td>
						</tr>

					<?php endforeach ?>
					
				</tbody>
			</table>

		</div>
	</div>
</div>

<script type="text/javascript">

	//alert
	<?php if ($this->session->userdata('success')): ?>
  		swal.fire("Berhasil!","<?=$this->session->userdata('success')?>","success");
  	<?php endif ?>
  	<?php if ($this->session->userdata('fail')): ?>
  		swal.fire("Gagal!","<?=$this->session->userdata('fail')?>","error");
  	<?php endif ?>

  	//delete
  	function del(id){

  		Swal.fire({
	        title: "Apa kamu yakin?",
	        text: "Hapus data ini ?",
	        icon: "warning",
	        buttons: true,
	        dangerMode: true,
	        showCancelButton: true,
	        cancelButtonColor: "#d33",
	        cancelButtonText: "Batal"
	      }).then(function(result){
		        if(result.value){
		            $(location).attr('href','<?=base_url('update_akun/verifikasi_delete/')?>'+id);
		        }

		    });
  	}

  	//verifikasi
  	function ver(id){

  		Swal.fire({
	        title: "Apa kamu yakin?",
	        text: "Verifikasi akun ini ?",
	        icon: "warning",
	        buttons: true,
	        dangerMode: true,
	        showCancelButton: true,
	        cancelButtonColor: "#d33",
	        cancelButtonText: "Batal"
	      }).then(function(result){
		        if(result.value){
		            $(location).attr('href','<?=base_url('update_akun/verifikasi_add/')?>'+id);
		        }

		    });
  	}
</script>