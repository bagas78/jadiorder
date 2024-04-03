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
	<h4 class="page-title">History</h4>
	<br>
	
	<div class="card">		

		<div class="card-body">

			<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		            		<th>Tanggal</th>
		                <th>Kode Bank</th>
		                <th>No. Rekening</th>
		                <th>Nominal</th>
		                <th>Biaya</th>
		                <th>Status</th>
		            </tr>
		        </thead>
		    </table>
		</div>

	</div>

</div>

<script type="text/javascript">

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
            "url": "<?= base_url('upload_produk/withdraw_history_get'); ?>",
            "type": "GET"
        },
        "columns": [   
        			{ "data": "tanggal" },                            
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

                			if (data == 1) { var s = '<span class="text-primary">Di Verfikasi</span>'; }
                			if (data == 2) { var s = '<span class="text-success">Sukses</span>'; }
                			if (data == 3) { var s = '<span class="text-danger">Di tolak</span>'; }

                      return s;
                  }
              },   
         ],
    });

});

function auto(){

    $('.pagination').css('display', 'flex');

    setTimeout(function() {
        auto();
    }, 100);
  }

auto();


</script>