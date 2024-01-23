<?php
if(!defined('BASEPATH')) exit('Hacking Attempt : Keluar dari sistem !! ');

class Digiflazz_api extends CI_Model{
    public function __construct(){
        parent::__construct();
    }
    
    function globalset($data){
		if($data != "semua"){
		$this->db->where("field",$data);
		}
		$res = $this->db->get("setting");
		$result = null;
		if($data == "semua"){
			$result = array(null);
			foreach($res->result() as $re){
				$result[$re->field] = $re->value;
			}
			$result = (object)$result;
		}else{
			$result = "";
			foreach($res->result() as $re){
				$result = $re->value;
			}
		}
		return $result;
	}

    // CEK SALDO
    function saldo(){
        $sal = $this->reqCurl('cek-saldo','deposit');
        if(is_object($sal->response)){
            if(isset($sal->response->data->deposit)){
                return "IDR ".$this->func->formUang($sal->response->data->deposit);
            }else{
                return "gagal terhubung ke digiflazz...";
            }
        }else{
            return "gagal terhubung ke digiflazz...";
        }
    }

    // PROSES PESANAN
    function prosesPesanan($id){
        $tag = $this->func->getTransaksiPPOB($id,'semua');
        if($tag->id > 0){
            $prod = $this->func->getPPOB($tag->idproduk,'semua');
            if($prod->id > 0){
                if($prod->tipe == 1){
                    $data = [
                        "buyer_sku_code"=> $prod->kode,
                        "customer_no"   => $tag->nomer,
                        "ref_id"        => $tag->invoice,
                        "testing"       => false
                    ];
                    $sal = $this->reqCurl('transaction',null,$tag->invoice,$data);
                    //print_r($sal);exit;
                    if(is_object($sal->response)){
                        if(isset($sal->response->data)){
                            $res = $sal->response->data;
                            $hasil = array();
                            $hasil['raw'] = json_encode($res);
                            if($res->status == "Sukses"){
                                $hasil['status'] = 2;
                                $hasil['harga_beli'] = $res->price;
                                $hasil['selesai'] = date("Y-m-d H:i:s");
                            }elseif($res->status == "Gagal"){
                                $sal = $this->func->getSaldo($tag->usrid,'semua','usrid',true);
                                $saldo = $sal->saldo + $tag->saldo;
                                $koin = $sal->koin + $tag->koin;
                                $this->db->where("id",$sal->id);
                                $this->db->update("saldo",["saldo"=>$saldo,"koin"=>$koin]);
                                
                                $this->db->where("sambung",$tag->id);
                                $this->db->where("darike",5);
                                $this->db->delete("saldohistory");

                                $this->func->notifBatalPPOB($tag->id,"*produk sedang gangguan* dan saldo Anda telah kami kembalikan");
                                
                                $hasil['status'] = 3;
                                $hasil['harga_beli'] = isset($res->price) ? $res->price : $tag->harga_beli;
                                $hasil['keterangan'] = $res->message."<br/>Telegram: ".$res->tele."<br/>WA: ".$res->wa;
                                $hasil['selesai'] = date("Y-m-d H:i:s");
                            }

                            $this->db->where("id",$tag->id);
                            $this->db->update("transaksi_ppob",$hasil);
                            return $res;
                        }else{
                            return null;
                        }
                    }else{
                        return null;
                    }
                }else{
                    $data = [
                        "buyer_sku_code"=> $prod->kode,
                        "customer_no"   => $tag->nomer,
                        "ref_id"        => $tag->invoice,
                        "testing"       => false
                    ];
                    $sal = $this->reqCurl('transaction','pay-pasca',$tag->invoice,$data);
                    //print_r($sal);exit;
                    if(is_object($sal->response)){
                        if(isset($sal->response->data)){
                            $res = $sal->response->data;
                            $hasil = array();
                            $hasil['raw'] = json_encode($res);
                            if($res->status == "Sukses"){
                                $hasil['status'] = 2;
                                $hasil['harga_beli'] = $res->price;
                                $hasil['selesai'] = date("Y-m-d H:i:s");
                            }elseif($res->status == "Gagal"){
                                $sal = $this->func->getSaldo($tag->usrid,'semua','usrid',true);
                                $saldo = $sal->saldo + $tag->saldo;
                                $koin = $sal->koin + $tag->koin;
                                $this->db->where("id",$sal->id);
                                $this->db->update("saldo",["saldo"=>$saldo,"koin"=>$koin]);
                                
                                $this->db->where("sambung",$tag->id);
                                $this->db->where("darike",5);
                                $this->db->delete("saldohistory");

                                $this->func->notifBatalPPOB($tag->id,"*produk sedang gangguan* dan saldo Anda telah kami kembalikan");
                                
                                $hasil['status'] = 3;
                                $hasil['harga_beli'] = isset($res->price) ? $res->price : $tag->harga_beli;
                                $hasil['keterangan'] = $res->message."<br/>Telegram: ".$res->tele."<br/>WA: ".$res->wa;
                                $hasil['selesai'] = date("Y-m-d H:i:s");
                            }

                            $this->db->where("id",$tag->id);
                            $this->db->update("transaksi_ppob",$hasil);
                            return $res;
                        }else{
                            return null;
                        }
                    }else{
                        return null;
                    }
                }
            }
        }else{
            return null;
        }
    }

    // CEK STATUS PESANAN
    function statusPesanan($id){
        $tag = $this->func->getTransaksiPPOB($id,'semua');
        if($tag->id > 0 && $tag->status >= 1){
            $prod = $this->func->getPPOB($tag->idproduk,'semua');
            if($prod->id > 0){
                if($prod->tipe == 1){
                    $data = [
                        "buyer_sku_code"=> $prod->kode,
                        "customer_no"   => $tag->nomer,
                        "ref_id"        => $tag->invoice,
                        "testing"       => false
                    ];
                    $sal = $this->reqCurl('transaction',null,$tag->invoice,$data);
                    //print_r($sal);exit;
                    if(is_object($sal->response)){
                        if(isset($sal->response->data)){
                            $res = $sal->response->data;
                            if($tag->status == 1){
                                $hasil = array();
                                $hasil['raw'] = json_encode($res);
                                if($res->status == "Sukses"){
                                    $hasil['status'] = 2;
                                    $hasil['harga_beli'] = $res->price;
                                    $hasil['selesai'] = date("Y-m-d H:i:s");
                                }elseif($res->status == "Gagal"){
                                    $sal = $this->func->getSaldo($tag->usrid,'semua','usrid',true);
                                    $saldo = $sal->saldo + $tag->saldo;
                                    $koin = $sal->koin + $tag->koin;
                                    $this->db->where("id",$sal->id);
                                    $this->db->update("saldo",["saldo"=>$saldo,"koin"=>$koin]);
                                    
                                    $this->db->where("sambung",$tag->id);
                                    $this->db->where("darike",5);
                                    $this->db->delete("saldohistory");

                                    $this->func->notifBatalPPOB($tag->id,"*produk sedang gangguan* dan saldo Anda telah kami kembalikan");
                                    
                                    $hasil['status'] = 3;
                                    $hasil['harga_beli'] = isset($res->price) ? $res->price : $tag->harga_beli;
                                    $hasil['keterangan'] = $res->message."<br/>Telegram: ".$res->tele."<br/>WA: ".$res->wa;
                                    $hasil['selesai'] = date("Y-m-d H:i:s");
                                }

                                $this->db->where("id",$tag->id);
                                $this->db->update("transaksi_ppob",$hasil);
                            }
                            return $res;
                        }else{
                            return null;
                        }
                    }else{
                        return null;
                    }
                }else{
                    $data = [
                        "buyer_sku_code"=> $prod->kode,
                        "customer_no"   => $tag->nomer,
                        "ref_id"        => $tag->invoice,
                        "testing"       => false
                    ];
                    $sal = $this->reqCurl('transaction','status-pasca',$tag->invoice,$data);
                    //print_r($sal);exit;
                    if(is_object($sal->response)){
                        if(isset($sal->response->data)){
                            $res = $sal->response->data;
                            if($tag->status == 1){
                                $hasil = array();
                                $hasil['raw'] = json_encode($res);
                                if($res->status == "Sukses"){
                                    $hasil['status'] = 2;
                                    $hasil['harga_beli'] = $res->price;
                                    $hasil['selesai'] = date("Y-m-d H:i:s");
                                }elseif($res->status == "Gagal"){
                                    $sal = $this->func->getSaldo($tag->usrid,'semua','usrid',true);
                                    $saldo = $sal->saldo + $tag->saldo;
                                    $koin = $sal->koin + $tag->koin;
                                    $this->db->where("id",$sal->id);
                                    $this->db->update("saldo",["saldo"=>$saldo,"koin"=>$koin]);
                                    
                                    $this->db->where("sambung",$tag->id);
                                    $this->db->where("darike",5);
                                    $this->db->delete("saldohistory");

                                    $this->func->notifBatalPPOB($tag->id,"*produk sedang gangguan* dan saldo Anda telah kami kembalikan");
                                    
                                    $hasil['status'] = 3;
                                    $hasil['harga_beli'] = isset($res->price) ? $res->price : $tag->harga_beli;
                                    $hasil['keterangan'] = $res->message."<br/>Telegram: ".$res->tele."<br/>WA: ".$res->wa;
                                    $hasil['selesai'] = date("Y-m-d H:i:s");
                                }

                                $this->db->where("id",$tag->id);
                                $this->db->update("transaksi_ppob",$hasil);
                            }
                            return $res;
                        }else{
                            return null;
                        }
                    }else{
                        return null;
                    }
                }
            }
        }else{
            return null;
        }
    }

    // GET TAGIHAN
    function cekTagihan($sku,$nomor){
        $refid = date("YmdHis");
        $data = [
            "buyer_sku_code"=> $sku,
            "customer_no"   => $nomor,
            "ref_id"        => $refid,
            "testing"       => false
        ];
        $sal = $this->reqCurl('transaction','inq-pasca',$refid,$data);
        //print_r($sal);exit;
        if(is_object($sal->response)){
            if(isset($sal->response->data)){
                return $sal->response->data;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }

    // GET PRODUK
    function produk($jenis){
        $sal = $this->reqCurl('price-list',$jenis);
        //print_r($sal);exit;
        if(is_object($sal->response)){
            if(isset($sal->response->data)){
                return $sal->response->data;
            }else{
                return null;
            }
        }else{
            return null;
        }
    }
    function sinkronPra(){
        $set = $this->globalset('semua');
		$res = $this->produk('prabayar');
		if(is_array($res)){
			$pro = count($res);
			$kat = [];
			$prod = [];
			foreach($res as $k => $v){
                $this->db->where("tipe",1);
                $this->db->where("kode",$v->category);
                $this->db->limit(1);
                $db = $this->db->get("ppob_kategori");
                if($db->num_rows() > 0){
                    foreach($db->result() as $r){
                        $katid = $r->id;
                        $this->db->where("id",$r->id);
                        $this->db->update("ppob_kategori",['status'=>1]);
                    }
                }else{
                    $katdata = [
                        "tgl"	=> date("Y-m-d H:i:s"),
                        "tipe"	=> 1,
                        "nama"	=> $v->category,
                        "kode"	=> $v->category,
                        "icon"	=> null,
                        "status"=> 1
                    ];
                    $dbs = $this->db->insert("ppob_kategori",$katdata);
                    $katid = $this->db->insert_id();
                }

				if(!in_array($katid,$kat)){
                    $kat[] = $katid;
				}
                $hj = $v->price + intval($set->digiflazz_untung);

				$this->db->where("tipe",1);
				$this->db->where("kode",$v->buyer_sku_code);
				$this->db->limit(1);
				$db = $this->db->get("ppob");
				if($db->num_rows() > 0){
					foreach($db->result() as $r){
						$hargabeli = ($r->harga_beli != $v->price) ? $v->price : $r->harga_beli;
						$hargajual = ($r->harga_jual < $hj) ? $hj : $r->harga_jual;
						$this->db->where("id",$r->id);
						$this->db->update("ppob",["harga_jual"=>$hargajual,"harga_beli"=>$hargabeli,"apdet"=>date("Y-m-d H:i:s"),'status'=>1]);
					}
				}else{
					$katdata = [
						"tgl"	=> date("Y-m-d H:i:s"),
						"apdet"	=> date("Y-m-d H:i:s"),
						"kode"	=> $v->buyer_sku_code,
						"tipe"	=> 1,
						"kategori"	=> $v->category,
						"kategori_id"=> $katid,
						"brand"	=> $v->brand,
						"start_cutoff"	=> $v->start_cut_off,
						"end_cutoff"	=> $v->end_cut_off,
						"nama"	=> $v->product_name,
						"deskripsi"	=> $v->desc,
						"multi"	=> $v->multi,
						"harga_beli"	=> $v->price,
						"harga_jual"	=> $hj,
						"status"=> 1
					];
					$dbs = $this->db->insert("ppob",$katdata);
				}
			}
			$kate = count($kat);
			
			// NONAKTIFKAN KATEGORI
			if($kate > 0){
				$this->db->where_not_in("id",$kat);
				$this->db->where("tipe",1);
				$this->db->update("ppob_kategori",['status'=>0]);
			}
			return json_encode(['success'=>true,'produk'=>$pro,'kategori'=>$kate]);
		}else{
			return json_encode(['success'=>false,'produk'=>0,'kategori'=>0]);
		}
    }
    function sinkronPasca(){
        //$set = $this->globalset('semua');
		$res = $this->produk('pasca');
		if(is_array($res)){
			$pro = count($res);
			$prod = [];
			foreach($res as $k => $v){
				$this->db->where("tipe",2);
				$this->db->where("kode",$v->buyer_sku_code);
				$this->db->limit(1);
				$db = $this->db->get("ppob");
				if($db->num_rows() > 0){
					foreach($db->result() as $r){
						$this->db->where("id",$r->id);
						$this->db->update("ppob",[
                            //"start_cutoff"  => $v->start_cut_off,
                            //"end_cutoff"    => $v->end_cut_off,
                            "biaya_admin"   => $v->admin,
                            "apdet" => date("Y-m-d H:i:s"),
						    "komisi"=> $v->commission,
                            "status"=> 1
                        ]);
					}
				}else{
					$katdata = [
						"tgl"	=> date("Y-m-d H:i:s"),
						"apdet"	=> date("Y-m-d H:i:s"),
						"kode"	=> $v->buyer_sku_code,
						"tipe"	=> 2,
						"kategori"	=> $v->category,
						"kategori_id"=> 0,
						"brand"	=> $v->brand,
						//"start_cutoff"	=> $v->start_cut_off,
						//"end_cutoff"	=> $v->end_cut_off,
						"nama"	=> $v->product_name,
						"deskripsi"	=> $v->desc,
						"biaya_admin"	=> $v->admin,
						"komisi"	=> $v->commission,
						"status"=> 1
					];
					$dbs = $this->db->insert("ppob",$katdata);
				}
			}
			return json_encode(['success'=>true,'produk'=>$pro]);
		}else{
			return json_encode(['success'=>false,'produk'=>0]);
		}
    }

    function sign($kode){
        $set = $this->globalset('semua');
        $result = md5($set->digiflazz_username.$set->digiflazz_apikey.$kode);
        return $result;
    }
    function reqCurl($url,$cmd,$inv=null,$data=null){
        $set = $this->globalset('semua');
        $cmda = [
            'deposit'   => 'depo',
            'prepaid' => 'pricelist',
            'pasca' => 'pricelist',
        ];
        $cmds = isset($cmda[$cmd]) ? $cmda[$cmd] : $inv;
        $sign = md5($set->digiflazz_username.$set->digiflazz_apikey.$cmds);
        $datar = array(
            "username"  => $set->digiflazz_username,
            "sign"      => $sign
        );
        if($cmd){
            if(in_array($cmd,['inq-pasca','pay-pasca','status-pasca'])){
                $datar["commands"] = $cmd;
            }else{
                $datar["cmd"] = $cmd;
            }
        }
        
        $data = ($data != null) ? array_merge($data,$datar) : $datar;
        $err = false;
        $responses = ['default'];
        //print_r($cmds);exit;
        //print_r(json_encode($data));exit;

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_FRESH_CONNECT     => true,
            CURLOPT_URL               => "https://api.digiflazz.com/v1/".$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json'
            ),
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS        => json_encode($data)
        ));

        $responses = curl_exec($curl);
        //print_r($responses);exit;
        $err = curl_error($curl);

        curl_close($curl);
        

        if($err || (isset($responses->data->rc) && intval($responses->data->rc) > 0)){
            $error = (object)["success"=>false,"response"=>$responses,"err"=>$err];
            return $error;
        }else{
            $sks = (object)["success"=>true,"response"=>json_decode($responses),"err"=>$err];
            return $sks;
        }
    }

}