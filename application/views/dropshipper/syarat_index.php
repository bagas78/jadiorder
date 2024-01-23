<!-- sweet alert -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">Syarat & Ketentuan</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">
			
			<form action="<?=base_url('update_akun/syarat_save')?>" method="POST" enctype="multipart/form-data">
				
				<div class="form-group">
					<textarea name="isi" class="form-control" id="summernote"></textarea>
				</div>
				<div class="form-group">
					<button class="btn btn-primary"><i class="fa fa-check"></i> Simpan</button>
				</div>

			</form>

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
	
	//textarea -> summernote
	$(document).ready(function() {
  			
  		$('#summernote').summernote({
        	tabsize: 2,
        	height: 300,
        	pasteHTML: '<b>hello world</b>',
      	});

  		//isi summernote
		$('#summernote').summernote('editor.pasteHTML', '<?=@$data['isi']?>');
	});

</script>

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>