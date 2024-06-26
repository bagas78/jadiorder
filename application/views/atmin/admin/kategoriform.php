<?php
    if($id != 0){
        $this->db->where("id",intval($id));
        $db = $this->db->get("kategori");
        foreach($db->result() as $r){
        }
    }
?>
<form id="saveform" method="POST" action="" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?=intval($id)?>" />
    <input type="hidden" class="tokens" name="<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash();?>" />
    <div class="row">
        <div class="col-md-12">
            <a class="float-right btn btn-danger" href="javascript:history.back()"><i class="la la-arrow-left"></i> Kembali</a>
            <?php if($id == 0){ ?>
			<h4 class="page-title">Tambah Kategori Baru</h4>
			<?php }else{ ?>
			<h4 class="page-title">Edit Kategori</h4>
			<?php } ?>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">Detail Kategori</div>
                </div>
                <div class="card-body">
                    <div class="form-group m-b-12">
                        <label>Nama</label>
                        <input type="text" name="nama" class="form-control" value="<?php echo (isset($r->nama)) ? $r->nama : ""; ?>" required />
                    </div>
                    <div class="form-group m-b-12">
                        <label>Parent/Induk Kategori</label>
                        <select name="parent" class="form-control" id="parent" required>
                            <option value="">- Pilih Kategori Induk -</option>
                            <option value="0" <?php echo (isset($r->parent) AND $r->parent == 0 AND !isset($_GET["parent"])) ? "selected" : ""; ?>>## Kategori Utama ##</option>
                            <?php
                                $this->db->where("parent",0);
                                $this->db->order_by("nama","asc");
                                $kat = $this->db->get("kategori");
                                $parent = (isset($r->parent)) ? $r->parent : 0;
                                $parent = (isset($_GET["parent"])) ? intval($_GET["parent"]) : $parent;
                                foreach($kat->result() as $k){
                                    $selec = ($k->id == $parent) ? " selected" : "";
                                    echo '<option value="'.$k->id.'"'.$selec.'>'.$k->nama.'</option>';
                                }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6" id="formfoto" <?php if(isset($_GET["parent"]) || $parent > 0){ echo "style='display:none'"; } ?>>
            <div class="card">
                <div class="card-header">
					<?php if(isset($r->icon)){ ?>
					<button type="button" class="btn btn-primary float-right" onclick="$(this).hide();$('#inputfile').show();$('#imgicon').slideUp()">
						<i class="fas fa-refresh"></i> 
						Ubah Foto
					</button>
					<?php } ?>
                    <div class="card-title">Foto Display</div>
				</div>
                <div class="card-body">
                    <?php 
                        if(isset($r->icon)){
							$form = "style='display:none;'";
					?>
						<img src='<?=base_url('cdn/kategori/'.$r->icon)?>' class='imgPreview' id="imgicon" />
					<?php
                       }else{
						   $form = "";
                       }
                    ?>
					<div id="inputfile" <?=$form?>>
                        <input type='file' accept="image/*" name="icon" id="imgInp" />
                        <a href="javascript:void(0)" class="btn btn-secondary" onclick="selectIMG()"><i class="la la-image"></i> Pilih Foto</a>
                        <div class="divider"></div>
                        <div class="imgInpPreview">
                            <div class="text" onclick="selectIMG()">Pilih foto</div>
                            <img id="blah" class="imgpreview" src="#" alt="gambar" />
                            <div  class="delete">
                                <a href="javascript:void(0)" onclick="clearIMG()"><i class="la la-times"></i> hapus</a>
                            </div>
                        </div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="">
        <button type="submit" class="btn btn-primary"><i class="la la-check-circle"></i> Simpan Kategori</button>
        <button type="reset" class="btn btn-warning"><i class="la la-refresh"></i> Reset</button>
    </div>
</form>

<script type="text/javascript">
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            
            reader.onload = function(e) {
            $('#blah').attr('src', e.target.result);
            }
            
            reader.readAsDataURL(input.files[0]);
        }
    }
    function selectIMG(){
        $("#imgInp").trigger("click");
    }
    function clearIMG(){
        $("#imgInp").val(null).trigger("change");
    }

    $(function(){
		$("#saveform").on("submit",function(){
			var btn = $(".btn-primary").html();
			$(".btn-primary").html("<i class='fas fa-spin fa-spinner'></i> Menyimpan...");
			$(".btn-primary").prop("disabled",true);
		});

        $("#parent").change(function(){
            if($(this).val() != 0 && $(this).val() != ""){
                $("#formfoto").hide();
            }else{
                $("#formfoto").show();
            }
        });
		
        $("#imgInp").change(function() {
            if($(this).val() != ""){
                readURL(this);
                $("#blah").show();
                $(".delete").show();
                $(".text").hide();
            }else{
                $("#blah").hide();
                $(".delete").hide();
                $(".text").show();
            }
        });
    });
</script>