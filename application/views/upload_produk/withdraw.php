<script type="text/javascript" src="<?=base_url('assets/vendor/swal/sweetalert2.min.js')?>"></script>

<style type="text/css">
	.card-pj{
		box-shadow: 0px 0px 8px #d0d1d4;
	    border-radius: 12px;
	    background-color: #ffffff;
	    margin: 20px;
	    padding: 2%;
	}
	.nom{
		background: aliceblue;
	    padding: 1%;
	    border-width: 1px;
	    border-style: dashed;
	}
	.min{
		background: #dc3545;
    	color: white;
    	padding: 1%;
    	text-align: center;
	}
</style>

<div class="card-pj">
	<h4 class="page-title">Withdraw</h4>
	<br>
	
	<div class="card">		

		<div class="card-body">

			<div align="left">
              <button onclick="modal()" class="btn btn-success">Tarik Penghasilan <i class="fas fa-undo"></i></button>
              <a href="<?=base_url('upload_produk/withdraw_history')?>"><button class="btn btn-primary">History <i class="fa fa-file"></i></button></a>
            </div>

            <br/> 

			<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		                <th>Bulan</th>
		                <th>Tahun</th>
		                <th>Jumlah</th>
		            </tr>
		        </thead>
		    </table>
		</div>

	</div>

</div>

<!-- Modal -->
<div class="modal fade" id="modal-s" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Withdraw</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        	
        <div class="nom">
        	<h3>Rp. <span id="nominal_text">0</span></h3>
        	<small>Seluruh penghasilan yang belum di tarik</small>
        </div>

        <hr>

        <div id="minimal" class="min">
        	<h3>Minimal withdraw Rp. 50.000</h3>
        </div>

        <div id="maximal">
        	
        	<form method="POST" action="<?=base_url('upload_produk/withdraw_request')?>">
	    		<div class="form-group">
	    			<label>No. Rekening</label>
	    			<input required type="number" name="rekening" class="form-control">
	    		</div>
	    		<div class="form-group">
	    			<label>Kode Bank</label>
	    			<input required type="number" name="kode" class="form-control">
	    		</div>
	        	<div class="form-group">
	        		<label>Masukan Nominal ( <small>Minimal 50.000</small> )</label>
	        		<input id="nominal" type="number" name="nominal" class="form-control" required min="50000">
	        		<small id="nominal_alert" class="text-danger"></small>
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
</div>

<!-- Modal -->
<div class="modal fade" id="modal-x" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-body">

        <div class="min">
        	<h5>Maaf masih ada withdraw yang di proses</h5>
        </div>

        <table class="table table-bordered">
    		<tr>
    			<td><span id="x-tanggal"></span></td>
    			<td>Rp. <span id="x-nominal"></span></td>
    		</tr>
    	</table>
		
	  </div>
    </div>
  </div>
</div>

<script type="text/javascript">

//save response
<?php if ($this->session->flashdata('sukses')): ?>
	swal.fire("Berhasil","<?=$this->session->flashdata('sukses')?>","success");	
<?php endif ?>

<?php if ($this->session->flashdata('gagal')): ?>
	swal.fire("Gagal!","<?=$this->session->flashdata('gagal')?>","error");
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
            "url": "<?= base_url('upload_produk/withdraw_get'); ?>",
            "type": "GET"
        },
        "columns": [   
        			{ "data": "bulan" },                            
                    { "data": "tahun"},
                    { "data": "total",
                      "render": 
                      function( data ) {

                            return "<span>"+number_format(data)+"</span>";
                        }
                    },
                
                ],
    });

});

function auto(){

	var text = Number($('#nominal_text').text().replaceAll('.',''));

	if (text > 50000) {

		$('#minimal').attr('hidden', true);
		$('#maximal').removeAttr('hidden');
		$('.modal-footer').removeAttr('hidden');
	}else{

		$('#minimal').removeAttr('hidden');
		$('#maximal').attr('hidden', true);
		$('.modal-footer').attr('hidden', true);
	}

    $('.pagination').css('display', 'flex');

    setTimeout(function() {
        auto();
    }, 100);
  }

auto();

function modal() {

	//get nominal
	$.get('<?=base_url('upload_produk/withdraw_nominal')?>', function(data) {
		
		$('#nominal_text').text(number_format(data.replaceAll('"','')));

		//show modal
		if ('<?=@$status['status']?>') {

			//withdraw aktif
			$('#x-nominal').text('<?=number_format(@$status['nominal'])?>');
			$('#x-tanggal').text('<?=@$status['tanggal']?>');
			$('#modal-x').modal('toggle');
		}else{

			$('#modal-s').modal('toggle');
		}

	});  
}

$(document).on('keyup', '#nominal', function() {

	var nominal = Number($('#nominal').val());
	var text = Number($('#nominal_text').text().replaceAll('.',''));

	if (nominal > text) {

		//nominal lebih kecil dari inputan
		$('#nominal_alert').text('Saldo tidak cukup');
		$('#nominal_submit').css({
			'background': 'darkgray',
			'pointer-events': 'none'
		});

	}else{

		$('#nominal_alert').text('');
		$('#nominal_submit').css({
			'background': '#2980b9',
			'pointer-events': 'unset'
		});

	}  

});


</script>