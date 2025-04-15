<? 
  /***
  * Entity-base class untuk mengimplementasikan tabel kategori.
  * 
  ***/
namespace App\Models;
use App\Models\Entity;

class Product extends Entity{ 

	var $query;
	var $id;
    /**
    * Class constructor.
    **/
    function Product()
	{
      parent::__construct(); 
    }
	
	function insertData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$this->setField("PID", $this->getSeqId("PID","product")); 

		$str = "INSERT INTO product(PID, nama, detil_nama, keterangan, detil_keterangan, upload, 
									upload_slider, upload_proposal, upload_screenshot) 
				VALUES(
				  ".$this->getField("PID").",
				  '".$this->getField("nama")."',
				  '".$this->getField("detil_nama")."',
				  '".$this->getField("keterangan")."',				  				  
				  '".$this->getField("detil_keterangan")."',				  				  
				  '".$this->getField("upload")."',				  				  				  				  
				  '".$this->getField("upload_slider")."',
				  '".$this->getField("upload_proposal")."',
				  '".$this->getField("upload_screenshot")."'				  				  				  
				)"; 
				
		$this->query = $str;
		return $this->execQuery($str);
    }

    function updateData()
	{
		/*Auto-generate primary key(s) by next max value (integer) */
		$str = "UPDATE product SET
				  nama = '".$this->getField("nama")."',
				  detil_nama = '".$this->getField("detil_nama")."',
				  keterangan = '".$this->getField("keterangan")."',				  				  
				  detil_keterangan = '".$this->getField("detil_keterangan")."',				  				  				  
				  upload = '".$this->getField("upload")."',
				  upload_slider = '".$this->getField("upload_slider")."',
				  upload_proposal = '".$this->getField("upload_proposal")."',				  				  
				  upload_screenshot = '".$this->getField("upload_screenshot")."'				  
				WHERE PID = '".$this->getField("PID")."'
				"; 
				$this->query = $str;
		return $this->execQuery($str);
    }
	
	function delete()
	{
        $str = "DELETE FROM product
                WHERE 
                  PID = '".$this->getField("PID")."'"; 
				  
		$this->query = $str;
        return $this->execQuery($str);
    }

    /** 
    * Cari record berdasarkan array parameter dan limit tampilan 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","ALKID"=>"yyy") 
    * @param int limit Jumlah maksimal record yang akan diambil 
    * @param int from Awal record yang diambil 
    * @return boolean True jika sukses, false jika tidak 
    **/ 
    function selectByParams($paramsArray=array(),$limit=-1,$from=-1,$varStatement="")
	{
		$str = "SELECT PID, nama, detil_nama, keterangan, detil_keterangan, upload, 
				upload_slider, upload_proposal, upload_screenshot FROM product WHERE 1 = 1 "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = $val ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY RAND()";
		return $this->selectLimit($str,$limit,$from); 
    }
    
	function selectByParamsLike($paramsArray=array(),$limit=-1,$from=-1,$varStatement="")
	{
		$str = "SELECT al.ALID AS al_ALID, 
					al.ALKID AS al_ALKID, 
					al.keterangan AS al_keterangan,
					ak.nama AS ak_nama
				FROM alumni al, alumni_kategori ak
				WHERE al.ALID IS NOT NULL 
					AND ak.ALKID = al.ALKID "; 
		
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->query = $str;
		$str .= $varStatement." ORDER BY al.ALID DESC";
				
		return $this->selectLimit($str,$limit,$from); 
    }
    /** 
    * Hitung jumlah record berdasarkan parameter (array). 
    * @param array paramsArray Array of parameter. Contoh array("id"=>"xxx","ALKID"=>"yyy") 
    * @return long Jumlah record yang sesuai kriteria 
    **/ 
    function getCountByParams($paramsArray=array(),$varStatement="")
	{
		$str = "SELECT COUNT(PID) AS ROWCOUNT FROM product WHERE PID IS NOT NULL ".$varStatement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key = '$val' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }

    function getCountByParamsLike($paramsArray=array(),$varStatement="")
	{
		$str = "SELECT COUNT(al.ALID) AS ROWCOUNT FROM alumni al WHERE al.ALID IS NOT NULL ".$varStatement; 
		foreach ($paramsArray as $key => $val)
		{
			$str .= " AND $key LIKE '%$val%' ";
		}
		
		$this->select($str); 
		if($this->firstRow()) 
			return $this->getField("ROWCOUNT"); 
		else 
			return 0; 
    }
	
  } 
?>