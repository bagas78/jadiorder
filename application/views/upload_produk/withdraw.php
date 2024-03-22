<style type="text/css">
	.card-pj{
		box-shadow: 0px 0px 8px #d0d1d4;
	    border-radius: 12px;
	    background-color: #ffffff;
	    margin: 20px;
	    padding: 2%;
	}
</style>

<div class="card-pj">
	<h4 class="page-title">Withdraw</h4>
	<br>
	
	<div class="card">		

		<div class="card-body">

			<div align="left">
              <button class="btn btn-success">Tarik Penghasilan <i class="fas fa-undo"></i></button>
            </div>

            <br/>

			<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		                <th>Bulan</th>
		                <th>Tahun
		                <th>Jumlah</th>
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
            "url": "<?= base_url('upload_produk/withdraw_get'); ?>",
            "type": "GET"
        },
        "columns": [   
        			{ "data": "bulan" },                            
                    { "data": "tahun"},
                    { "data": "total"},
                    
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