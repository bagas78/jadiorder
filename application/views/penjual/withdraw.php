<link rel="stylesheet" type="text/css" href="<?=base_url('assets/vendor/datatables/datatables.min.css')?>">
<script type="text/javascript" src="<?=base_url('assets/vendor/datatables/datatables.min.js')?>"></script>
<script src="<?=base_url('assets/js/number_format.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/vendor/swal/sweetalert2.min.js') ?>"></script>

<h4 class="page-title">User Withdraw</h4>

<div class="m-b-60">
	<div class="card">
		<div class="card-body" id="load">

			<table id="example" class="table table-striped table-bordered" style="width:100%">
				<thead>
					<tr>
						<th>Tanggal</th>
						<th>Nama User</th>
		                <th>Kode Bank</th>
		                <th>No. Rekening</th>
		                <th>Nominal</th>
		                <th>Biaya</th>
		                <th>Status</th>
		                <th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
			</table>

		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h6 class="modal-title" id="exampleModalLabel">Verifikasi Withdraw</h6>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	
        <form method="POST" action="">
        	<div class="form-group">
    			<label>Status</label>
    			<select name="status" class="form-control" required>
    				<option value="" hidden>-- Pilih --</option>
    				<option value="1">Setuju</option>
    				<option value="2">Tolak</option>
    			</select>
    		</div>
    		<div class="form-group">
    			<label>Biaya Transfer</label>
    			<input placeholder="Biaya Admin" required type="number" name="biaya" class="form-control">
    		</div>

      	</div>

	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
	        <button type="submit" class="btn btn-primary" id="nominal_submit">Kirim</button>
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

//data table
var table;
$(document).ready(function() {

    //datatables
    table = $('#example').DataTable({ 

        "responsive"  : true,
        "scrollX"     : true,
        "processing"  : true, 
        "serverSide"  : true,
        "order"       :[],  
        
        "ajax": {
            "url": "<?= base_url('update_akun/withdraw_get'); ?>",
            "type": "GET"
        },
        "columns": [   
        	  { "data": "tanggal" },
        	  { "data": "nama" },                            
              { "data": "kode"},
              { "data": "rekening"},
              { "data": "nominal",
                "render": 
                function( data ) {

                      return '<span>'+number_format(data)+'</span>';
                  }
              },
              { "data": "biaya",
                "render": 
                function( data ) {

                      return '<span>'+number_format(data)+'</span>';
                  }
              }, 
              { "data": "status",
                "render": 
                function( data ) {

                      return '<span class="status">'+data+'</span>';
                  }
              }, 
              { "data": "id",
                "render": 
                function( data ) {

                      return '<button onclick="ver('+data+')" title="verifikasi" class="btn btn-primary btn-sm m-b-4"><i class="fa fa-check"></i> Verifikasi</button>';
                  }
              },  
         ],
    });

});

//verifikasi
function ver(id){

	$('#modal').modal('toggle');
	$('form').attr('action', '<?=base_url('update_akun/verifikasi_witdraw/')?>'+id);
}

function auto(){

    $('.pagination').css('display', 'flex');
    $('div.dataTables_filter label').css('text-align', 'right');

    //status
    $.each($('.status'), function(index, val) {
    	 var v = $(this).text();
    	 var target = $(this);

    	 switch(v) {
		  case '0':
		    // menunggu
		    target.html('<span class="text-primary">Menunggu</span>');

		    break;
		  case '1':
		    // setuju
		    target.html('<span class="text-success">Disetujui</span>');
		    target.closest('tr').find('.btn').css('pointer-events', 'none');
		    target.closest('tr').find('.btn').removeClass('btn-primary');
		    target.closest('tr').find('.btn').addClass('btn-secondary');
		    break;
		  case '2':
		    // tolak
		    target.html('<span class="text-danger">Ditolak</span>');
		    target.closest('tr').find('.btn').css('pointer-events', 'none');
		    target.closest('tr').find('.btn').removeClass('btn-primary');
		    target.closest('tr').find('.btn').addClass('btn-secondary');
		    break;
		}
    });

    setTimeout(function() {
        auto();
    }, 100);
  }

auto();

</script>