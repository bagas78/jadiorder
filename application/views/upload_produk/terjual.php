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
	<h4 class="page-title">Produk Terjual</h4>
	<br>
	
	<div class="card">		

		<div class="card-body">
			<table id="example" class="table table-striped table-bordered" style="width:100%">
		        <thead>
		            <tr>
		                <th>Transaksi</th>
		                <th>Nama Produk</th>
		                <th>Jumlah</th>
		                <th>Harga</th>
		                <th>Tanggal</th>
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
            "url": "<?= base_url('upload_produk/terjual_get'); ?>",
            "type": "GET"
        },
        "columns": [   
        			{ "data": "id_transaksi" },                            
                    { "data": "produk"},
                    { "data": "jumlah",
		                "render": 
		                function( data ) {

		                      return '<span>'+number_format(data)+'</span>';
		                }
		            },
                    { "data": "harga",
		                "render": 
		                function( data ) {

		                      return '<span>'+number_format(data)+'</span>';
		                }
		            },
                    { "data": "tanggal"},
                    
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