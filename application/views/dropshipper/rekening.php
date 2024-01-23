<!-- sweet alert -->
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">No Rekening</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">
			
			<a href="<?=base_url('update_akun/rekening_add')?>"><button class="btn btn-primary"><i class="fa fa-plus"></i> Tambah Rekening</button></a>

			<?php if (@$data): ?>
				<button class="btn btn-success" data-toggle="modal" data-target="#modal"><i class="fa fa-pen"></i> Nominal Transfer</button>
			<?php endif ?>

			<div class="clearfix"></div><br/>

			<h6>Total Nominal Transfer : Rp. <?=@$data[0]['nominal']?></h6>

			<div class="clearfix"></div><br/>

			<table class="table table-bordered">
				<thead>
					<tr>
						<th>Bank</th>
						<th>Atas Nama</th>
						<th>Kode Bank</th>
						<th>No Rekening</th>
						<th width="180">Aksi</th>
					</tr>
				</thead>
				<tbody>

					<?php foreach (@$data as $v): ?>
						
						<tr>
							<td><?=$v['bank']?></td>
							<td><?=$v['nama']?></td>
							<td><?=$v['kode']?></td>
							<td><?=$v['rekening']?></td>
							<td>
								<a href="<?=base_url('update_akun/rekening_edit/'.$v['id'])?>"><button class="btn btn-info btn-sm"><i class="fa fa-pen"></i> Edit</button></a>
								<button onclick="del('<?=$v['id']?>')" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i> Hapus</button>
							</td>
						</tr>

					<?php endforeach ?>
					
				</tbody>
			</table>

		</div>
	</div>
</div>

<!-- Modal Nominal Transfer -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Nominal Transfer</h5>
				<button type="button" data-dismiss="modal" aria-label="Close">
					<i class="fas fa-times text-danger fs-24 p-all-2"></i>
				</button>
			</div>
			<div class="modal-body">
				<form method="POST" action="<?=base_url('update_akun/rekening_nominal')?>">
					<div class="form-group">
						<label>Set Nominal Transfer</label>
						<div class="input-group mb-2">
					        <div class="input-group-prepend">
					          <div class="input-group-text">Rp</div>
					        </div>
					        <input type="number" class="form-control" id="inlineFormInputGroup" name="nominal">
					     </div>
					</div>
					<div class="form-group">
						<button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
					</div>
				</form>
			</div>
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
		            $(location).attr('href','<?=base_url('update_akun/rekening_delete/')?>'+id);
		        }

		    });
  	}

</script>