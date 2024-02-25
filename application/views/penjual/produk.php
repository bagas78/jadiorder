<h4 class="page-title">Verifikasi Produk</h4>
<div class="card">
	<div class="card-header row">
		<div class="col-md-4 p-tb-6">
			<input type="text" class="form-control" placeholder="cari produk" id="cari" />
		</div>
		<div class="col-md-3 p-tb-6">
			<button class="btn btn-block" style="background-color:rgb(251, 172, 76, 0.4)">Stok Habis &nbsp;<span class="badge badge-danger p-lr-8 p-tb-2 fs-16"><?=$this->admfunc->getProdukHabis()?></span></button>
		</div>
		<div class="col-md-3 col-8 p-tb-6">
			<select id="status" class="form-control">
				<option value="0">Semua Produk</option>
				<option value="1">Stok Tersedia</option>
				<option value="3">Stok Menipis</option>
				<option value="2">Stok Habis</option>
			</select>
		</div>
		<div class="col-md-2 col-4 p-tb-6">
			<select id="perpage" class="form-control">
				<option value="10">10</option>
				<option value="25">25</option>
				<option value="50">50</option>
				<option value="75">75</option>
				<option value="100">100</option>
			</select>
		</div>
	</div>
	<div class="card-body table-responsive">
		<i class="la la-spin la-spinner"></i> Loading data...
	</div>
</div>

<script type="text/javascript">
	$(function(){
		refreshTabel(1);

		$("#cari,#perpage,#status").change(function(){
			refreshTabel(1);
		});
	});
	
	function refreshTabel(page){
		$(".card-body").html('<i class="fas fa-spin fa-spinner"></i> Loading data...');
		var perpage = $("#perpage").val();
		$.post("<?=site_url("update_akun/produk?load=true")?>&page="+page+"&perpage="+perpage,{"cari":$("#cari").val(),"status":$("#status").val(),[$("#names").val()]:$("#tokens").val()},function(msg){
			var data = eval("("+msg+")");
			updateToken(data.token);
			$(".card-body").html(data.result);
		});
	}

	function verifikasi(id){
		swal.fire({
			title: "Yakin verifikasi produk?",
			text: "sudah setujui tidak akan bisa dikembalikan",
			type: "warning",
			showCancelButton: true,
			cancelButtonText: "Batal",
			confirmButtonText: "Oke"
		}).then((val)=>{
			if(val.value == true){
				$.post("<?=site_url("update_akun/setujui")?>",{"id":id,[$("#names").val()]:$("#tokens").val()},function(msg){
					var data = eval("("+msg+")");
					updateToken(data.token);
					if(data.success == true){
						swal.fire("Berhasil","data telah di verifikasi","success").then((val)=>{
							window.location.href="<?=site_url("update_akun/verifikasi_produk")?>";
						});
					}else{
						swal.fire("Gagal!","gagal verifikasi data, cobalah beberapa saat lagi","error");
					}
				});
			}
		});
	}
</script>


