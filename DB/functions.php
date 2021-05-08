<?
include_once("config.php");
	class database_func extends database{
		public $result;
		public  function queryMysql($query){
						$this->result = $this->connection->query($query);
					if (!$this->result){
							echo $query.'<br>';
							die("So`rovda xatolik bor. ".$this->connection->error);
						}		
		}
	//glabal massivni uchirish
	public function destroySession(){
		$_SESSION=array();
		if (session_id() != "" || isset($_COOKIE[session_name()]))
			setcookie(session_name(), '', time()-2592000, '/');
		session_destroy();
		}
	//bu stringni tugrilash uchun
	public function sanitizeString($var1){
		$var1 = strip_tags($var1);
		$var1 = htmlentities($var1, ENT_QUOTES);
		$var1 = stripslashes($var1);
		return ($var1);
		}
	//satrni kodga ugiradigan va har blgilarni kodini olib beradi, teglarni kodga ugiradi , ma`lumot bazaga qushishda ishlatiladi
	function strtocode($var2){
		return htmlentities($var2, ENT_QUOTES);
		}
	//kodni satrga ugiadi , bazadan olinganda satrni asl holiga qaytarish uchun ishlatiladi
	function aslString($var3){
		return html_entity_decode($var3);
		}
	///umumiy select * , select where , searching
		function sws_function($table,$column='no',$value='no',$type=3,$start=0,$finish=1000){
			if($type==1){
				$sorov="select * from ".$table." WHERE ".$column." = ".$value." limit ".$start.",".$finish;

			}elseif($type==2 && $column!='no' && $value!='no'){
				$sorov="select * from ".$table." Where ".$column." LIKE '%".$value."%'";
			}
			elseif($type==3){
				$sorov="select * from ".$table." limit ".$start.",".$finish;
			}
			$this->queryMysql($sorov);
		}
	}
?>
