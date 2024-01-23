<script type="text/javascript">

	//action
	$('form').attr('action', '<?=base_url('update_akun/rekening_update/'.$data['id'])?>');

	//input
	$('#bank').val('<?=$data['bank']?>');
	$('#nama').val('<?=$data['nama']?>');
	$('#kode').val('<?=$data['kode']?>');
	$('#rekening').val('<?=$data['rekening']?>');
	
</script>