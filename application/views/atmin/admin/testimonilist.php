<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<tr>
			<th scope="col">No</th>
			<th scope="col">Foto</th>
			<th scope="col">Nama Pengguna</th>
			<th scope="col">Titel</th>
			<th scope="col"  width="30%">Komentar</th>
			<th scope="col">Aksi</th>
		</tr>
	<?php
		$page = (isset($_GET["page"]) AND $_GET["page"] != "") ? $_GET["page"] : 1;
		$cari = (isset($_POST["cari"]) AND $_POST["cari"] != "") ? $_POST["cari"] : "";
		$orderby = (isset($data["orderby"]) AND $data["orderby"] != "") ? $data["orderby"] : "id";
		$perpage = 10;
		
		$this->db->select("id");
		$rows = $this->db->get("testimoni");
		$rows = $rows->num_rows();
		
		$this->db->order_by("id","DESC");
		$this->db->limit($perpage,($page-1)*$perpage);
		$db = $this->db->get("testimoni");
			
		if($rows > 0){
			$no = 1;
			foreach($db->result() as $r){
	?>
			<tr>
				<td><?=$no?></td>
				<td><img src="<?=base_url("cdn/uploads/".$r->foto)?>" style="width:120px;"></td>
				<td><?=$r->nama?></td>
				<td><?=$r->jabatan?></td>
				<td><?=$r->komentar?></td>
				<td>
					<button onclick="edit(<?=$r->id?>)" class="btn btn-xs btn-warning"><i class="fas fa-pencil-alt"></i> edit</button>
					<button onclick="hapus(<?=$r->id?>)" class="btn btn-xs btn-danger"><i class="fas fa-times"></i> hapus</button>
				</td>
			</tr>
	<?php	
				$no++;
			}
		}else{
			echo "<tr><td colspan=4 class='text-center text-danger'>Belum ada testismoni</td></tr>";
		}
	?>
	</table>

	<?=$this->admfunc->createPagination($rows,$page,$perpage,"loadTesti");?>
</div>