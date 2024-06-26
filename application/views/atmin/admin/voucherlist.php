<div class="table-responsive">
	<table class="table table-condensed table-hover">
		<tr>
			<th scope="col">No</th>
			<th scope="col">Nama</th>
			<th scope="col">Kode Voucher</th>
			<th scope="col">Jenis Potongan</th>
			<th scope="col">Nilai</th>
			<th scope="col">Masa Berlaku</th>
			<th scope="col">Terpakai</th>
			<th scope="col">Aksi</th>
		</tr>
	<?php
		$page = (isset($_GET["page"]) AND $_GET["page"] != "") ? $_GET["page"] : 1;
		$cari = (isset($_POST["cari"]) AND $_POST["cari"] != "") ? $_POST["cari"] : "";
		$orderby = (isset($data["orderby"]) AND $data["orderby"] != "") ? $data["orderby"] : "selesai";
		$perpage = 10;
		
		$where = "nama LIKE '%$cari%' OR deskripsi LIKE '%$cari%' OR kode LIKE '%$cari%' OR potongan LIKE '%$cari%'";
		$this->db->select("id");
		$this->db->where($where);
		$rows = $this->db->get("voucher");
		$rows = $rows->num_rows();
		
		$this->db->where($where);
		$this->db->order_by("selesai","DESC");
		$this->db->limit($perpage,($page-1)*$perpage);
		$db = $this->db->get("voucher");
			
		if($rows > 0){
			$no = 1;
			$total = 0;
			foreach($db->result() as $r){
				$pot = $this->admfunc->formUang($r->potongan);
				$potongan = $r->tipe == 2 ? "Rp ".$pot : $pot."%<br/><small>maks. Rp ".$this->admfunc->formUang($r->potonganmaks)."</small>";
				$jenis = $r->jenis == 1 ? "Harga" : "Ongkir";
				$kode = ($r->mulai <= date("Y-m-d H:i:s") AND $r->selesai >= date("Y-m-d H:i:s")) ? strtoupper(strtolower($r->kode)) : "<span class='text-danger'><i class='fas fa-times-circle'></i> ".strtoupper(strtolower($r->kode))."</span>";
				$public = $r->public == 1 ? "<br/><span class='text-success'><i class='fas fa-check-circle'></i> public</span>" : "<br/><span class='text-danger'><i class='fas fa-lock'></i> private</span>";
				$digital = $r->digital == 1 ? "<br/><span class='badge badge-primary'><i class='fas fa-cloud'></i> produk digital</span>" : "";
				$kab = $this->admfunc->getKab($r->idkab,"semua");
				$kab = ($r->idkab == 0) ? "Seluruh Indonesia" : $kab->tipe." ".$kab->nama;

				$this->db->select("id");
				$this->db->where("voucher",$r->id);
				$this->db->where("status",1);
				$byr = $this->db->get("pembayaran");
	?>
			<tr>
				<td><?=$no?></td>
				<td><?=$r->nama.$public."<br/><small class='text-primary'><i class='fas fa-map-marker-alt'></i> ".$kab."</small>"?></td>
				<td><?=$kode.$digital?></td>
				<td><?=$jenis?></td>
				<td><?=$potongan?></td>
				<td>
					<b>mulai:</b> <?=$this->admfunc->ubahTgl("d/m/Y",$r->mulai)?><br/>
					<b>selesai:</b> <?=$this->admfunc->ubahTgl("d/m/Y",$r->selesai)?>
				</td>
				<td class='text-center'><b class='text-danger fs-16'><?=$byr->num_rows()?></b></td>
				<td>
					<button onclick="edit(<?=$r->id?>)" class="btn btn-xs btn-warning"><i class="fas fa-pencil-alt"></i> edit</button>
					<?php if($_GET["load"] != "mutasi") : ?>
					<button onclick="hapus(<?=$r->id?>)" class="btn btn-xs btn-danger"><i class="fas fa-times"></i> hapus</button>
					<?php endif; ?>
				</td>
			</tr>
	<?php	
				$no++;
			}
		}else{
			echo "<tr><td colspan=5 class='text-center text-danger'>Belum ada voucher</td></tr>";
		}
	?>
	</table>

	<?=$this->admfunc->createPagination($rows,$page,$perpage,"loadVoucher");?>
</div>