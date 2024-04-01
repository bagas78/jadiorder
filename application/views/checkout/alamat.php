<?php
    $tipeco = (isset($_SESSION["usrid"])) ? 0 : 1;
    if($tipeco == 0){
        $this->db->where("usrid",$_SESSION["usrid"]);
    }else{
        $this->db->where("usrid_temp",$_SESSION["usrid_temp"]);
    }
    $this->db->order_by("status","DESC");
    $row = $this->db->get("alamat");
?>
<form id="alamat">
    <div class="row">
        <div class="col-md-8">
            <div class="section p-all-24 m-b-20">
                <input type="hidden" id="tujuan" value="" name="tujuan" />
                <div class="m-b-12 alamatform">
                <b>Alamat Pengiriman</b>
                </div>
                <div class="rs1-select2 rs2-select2 m-b-12 alamatform">
                <select class="js-select2 form-control" name="alamat" id="idalamat" required>
                    <option value="">- Pilih Alamat Tujuan -</option>
                    <option value="0">+ Tambah Alamat Baru</option>
                    <?php
                    foreach($row->result() as $al){
                        //RAJAONGKIR
                        $kec = $this->func->getKec($al->idkec,"semua");
                        $idkab = $kec->idkab;
                        $keckab = $kec->nama.", ".$this->func->getKab($idkab,"nama");
                        echo '<option value="'.$al->id.'" data-tujuan="'.$al->idkec.'">'.strtoupper(strtolower($al->judul.' - '.$al->nama)).' ('.$keckab.')</option>';
                    }
                    ?>
                </select>
                <div class="dropDownSelect2"></div>
                </div>
                <div class="m-b-12">
                <?php
                    foreach($row->result() as $als){
                    $kec = $this->func->getKec($al->idkec,"semua");
                    $idkab = $kec->idkab;
                    $kec = $kec->nama;
                    $kab = $this->func->getKab($idkab,"nama");
                    echo "
                        <div class='alamat section bg-foot p-tb-20 p-lr-24 m-t-20' id='alamat_".$als->id."' data-tujuan='".$al->idkec."' style='display:none;'>
                        <b class='text-info'>Nama Penerima:</b><br/>".strtoupper(strtolower($als->nama))."<br/>
                        <b class='text-info'>No HP:</b><br/>".$als->nohp."<br/>
                        <b class='text-info'>Alamat Lengkap:</b><br/>".strtoupper(strtolower($als->alamat."<br/>".$kec.", ".$kab))."<br/>KODEPOS ".$als->kodepos."
                        </div>
                    ";
                    }
                ?>
                </div>
                <div class="m-b-12 tambahalamat" style="display:none;">
                <b>Tambah Alamat Pengiriman</b>
                </div>
                <div class="tambahalamat" style="display:none;">
                    <div class="m-b-12 col-md-10 p-lr-0">
                    <input class="form-control" type="text" name="judul" placeholder="Simpan Sebagai? ex: Alamat Rumah, Alamat Kantor, Dll">
                    </div>
                    <div class="m-b-12 col-md-8 p-lr-0">
                    <input class="form-control" type="text" name="nama" placeholder="Nama Penerima">
                    </div>
                    <div class="m-b-12 col-md-6 p-lr-0">
                    <input class="form-control" type="text" name="nohp" placeholder="No Handphone Penerima">
                    </div>
                    <div class="m-b-12">
                    <textarea class="form-control" name="alamatbaru" placeholder="Alamat lengkap"></textarea>
                    </div>
                    <div class="row m-lr-0">
                    <div class="rs1-select2 rs2-select2 col-md-5 m-b-12 p-lr-0">
                        <select class="js-select2 form-control" name="negara" readonly>
                        <option value="ID">Indonesia</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <div class="col-md-6 p-b-10"></div>
                    <div class="rs1-select2 rs2-select2 col-md-5 m-b-12 p-lr-0">
                        <select class="js-select2 form-control" id="prov">
                        <option value="">Provinsi</option>
                        <?php
                            $prov = $this->db->get("prov");
                            foreach($prov->result() as $pv){
                            echo '<option value="'.$pv->id.'">'.$pv->nama.'</option>';
                            }
                        ?>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <div class="col-md-1 p-b-10"></div>
                    <div class="rs1-select2 rs2-select2 col-md-5 m-b-12 p-lr-0">
                        <select class="js-select2 form-control" id="kab">
                        <option value="">Kabupaten</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <div class="col-md-1 p-b-10"></div>
                    <div class="rs1-select2 rs2-select2 col-md-5 m-b-12 p-lr-0">
                        <select class="js-select2 form-control" id="kec" name="idkec">
                        <option value="">Kecamatan</option>
                        </select>
                        <div class="dropDownSelect2"></div>
                    </div>
                    <div class="col-md-1 p-b-10"></div>
                    <div class="m-b-12 col-md-5 p-lr-0">
                        <input class="form-control" type="number" name="kodepos" placeholder="Kode POS">
                    </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="section p-all-24">
                <b>Dropship</b>

                <!-- status -->
                <input type="hidden" id="status" value="0">

                <div class="dropship">
                    <div class="m-t-10">
                        <button type="button" id="nodrop" class="btn btn-primary m-r-10"><i class="fa fa-check-square"></i> Tidak Dropship</button>
                        <div class="showsmall m-t-10"></div>

                        <?php if ($this->session->userdata('drp_status') == 1): ?>
                            
                            <button type="button" id="yesdrop" class="btn btn-outline-primary"><i class="fa fa-check-square" style="display:none"></i> Dropship</button>

                            <div id="drop-show" style="display: none;">
                                <hr>
                                <button type="button" id="drop-resi" class="btn btn-outline-success"><i class="fa fa-check-square" style="display:none"></i> Resi Otomatis</button>
                                <button type="button" id="drop-kurir" class="btn btn-outline-success"><i class="fa fa-check-square" style="display:none"></i> Kurir</button>
                            </div>

                        <?php endif ?>
                        
                    </div>
                    <div class="p-t-20" id="dropform" style="display:none;">
                        <div class="m-b-12">
                            <label class="m-b-4">Nama Pengirim</label>
                            <input type="text" name="dropship" class="form-control" placeholder="" />
                        </div>
                        <div class="m-b-12">
                            <label class="m-b-4">No Telepon</label>
                            <input type="text" name="dropshipnomer" class="form-control" placeholder="" />
                        </div>
                        <div class="m-b-12">
                            <label class="m-b-4">Kurir</label>
                            <input type="text" name="dropshipkurir" class="form-control" placeholder="" />
                        </div>
                        <div class="m-b-12">
                            <label class="m-b-4">Resi</label>
                            <input type="text" name="dropshipresi" class="form-control" placeholder="" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center p-t-32">
        <button type="submit" class="btn btn-lg btn-primary">SELANJUTNYA &nbsp;<i class="fas fa-chevron-right"></i></button>
    </div>
</form>

<script type="text/javascript">
    $(function(){
        $("#idalamat").change(function(){
            var idalamat = $(this).val();
            var tujuan = $("#alamat_"+idalamat).data('tujuan');

            $(".alamat").hide();
            if($(this).val() == ""){
                $(".tambahalamat").hide();
                $(".tambahalamat input,.tambahalamat textarea").prop("required",false);
            }else if($(this).val() == 0){
                $(".tambahalamat").show();
                $(".tambahalamat input,.tambahalamat textarea").prop("required",true);
                if($("#kab").val() != ""){
                    $("#tujuan").val($("#kab").val());
                }
            }else if($(this).val() > 0){
                $("#alamat_"+idalamat).show();
                $(".tambahalamat").hide();
                $(".tambahalamat input,.tambahalamat textarea").prop("required",false);
            }
        });

        $("#alamat").on("submit",function(e){
            e.preventDefault();

            var status = $('#status').val();

            if (status == 0) {

                $.post("<?=site_url("checkout/simpanalamat")?>",$(this).serialize(),function(msg){
                    var data = eval("("+msg+")");
                    if(data.success == true){
                        
                        //pilih kurir
                        loadKurir();

                    }else{
                        swal.fire("Gagal Menyimpan Alamat","terjadi kesalahan saat menyimpan alamat Anda. Silahkan ulangi beberapa saat lagi","warning");
                    }
                });
            }

            if (status == 2) {

                $.post("<?=site_url("checkout/simpanalamat")?>",$(this).serialize(),function(msg){
                    var data = eval("("+msg+")");
                    if(data.success == true){
                        
                        //langsung bayar
                        loadBayar();

                    }else{
                        swal.fire("Gagal Menyimpan Alamat","terjadi kesalahan saat menyimpan alamat Anda. Silahkan ulangi beberapa saat lagi","warning");
                    }
                });
            }

        });
		
		$("#nodrop").click(function(){

            //status
            $('#status').val(0);

            //nodrop
            $(this).removeClass("btn-outline-primary");
            $(this).addClass("btn-primary");
            $(".fa",this).show();
            $("#drop-show").hide();

            //yesdrop
			$("#yesdrop").removeClass("btn-primary");
			$("#yesdrop").addClass("btn-outline-primary");
			$("#yesdrop .fa").hide();

            //form
			$("#dropform").hide();
			$("#dropform input").val("");
			$("#dropform input").prop("required",false);

            //drop-resi & drop-kurir
            $("#drop-resi, #drop-kurir").removeClass("btn-success");
            $("#drop-resi, #drop-kurir").addClass("btn-outline-success");
            $("#drop-resi .fa, #drop-kurir .fa").hide();
		});

		$("#yesdrop").click(function(){

            //status
            $('#status').val(1);

            //yesdrop
			$("#drop-show").show();
            $(this).removeClass("btn-outline-primary");
            $(this).addClass("btn-primary");
            $(".fa",this).show();

            //nodrop
            $("#nodrop").removeClass("btn-primary");
            $("#nodrop").addClass("btn-outline-primary");
            $("#nodrop .fa").hide();
		});

        $("#drop-resi").click(function(){

            //status
            $('#status').val(2);

            //drop-resi
            $(this).removeClass("btn-outline-success");
            $(this).addClass("btn-success");
            $(".fa",this).show();

            //drop-kurir
            $("#drop-kurir").removeClass("btn-success");
            $("#drop-kurir").addClass("btn-outline-success");
            $("#drop-kurir .fa").hide();

            //form
            $("#dropform").show();
            $("#dropform input").prop("required",true);
        });

        $("#drop-kurir").click(function(){

            //status
            $('#status').val(0);

            //drop-kurir
            $(this).removeClass("btn-outline-success");
            $(this).addClass("btn-success");
            $(".fa",this).show();

            //drop-resi
            $("#drop-resi").removeClass("btn-success");
            $("#drop-resi").addClass("btn-outline-success");
            $("#drop-resi .fa").hide();

            //form
            $("#dropform").hide();
            $("#dropform input").val("");
            $("#dropform input").prop("required",false);
        });

        //LOAD KABUPATEN KOTA & KECAMATAN
        $("#prov").change(function(){
            $("#kab").html("<option value=''>Loading...</option>");
            $("#kec").html("<option value=''>Kecamatan</option>");
            $.post("<?php echo site_url("assync/getkab"); ?>",{"id":$(this).val(),[$("#names").val()]: $("#tokens").val()},function(msg){
                var data = eval("("+msg+")");
                updateToken(data.token);
                $("#kab").html(data.html);
            });
        });
        $("#kab").change(function(){
            $("#kec").html("<option value=''>Loading...</option>");
            $.post("<?php echo site_url("assync/getkec"); ?>",{"id":$(this).val(),[$("#names").val()]: $("#tokens").val()},function(msg){
                var data = eval("("+msg+")");
                updateToken(data.token);
                $("#kec").html(data.html);
            });
        });
    });
</script>