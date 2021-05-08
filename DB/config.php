<?
// BAZAGA ULANUVCHI CLASS
class database{
	//uzgaruvchilar
	protected $dbhost  = 'localhost';    	// o'zgartirish shart emas
	protected $dbname  = 'magazin9'; // Ma'lumotlar bazasi nomi
	protected $dbuser  = 'root';   	// user nomi
	protected $dbpass  = '';   // parol
	public $connection;
	public $sql;
// constanta
const SITE='http://sharqona.uz';
public function __construct(){
	$this->connection = new mysqli($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
	$_COOKIE['count']=0;
	if ($this->connection->connect_error) {
		die("MySQLga ulanishda xatolik sodir bo`ldi: ".
			$this->connection->connect_error);
	}else{
		mysqli_set_charset($this->connection,"utf-8");
	}

	return $this->connection;
}
	public function secur($sql){
		if(isset($sql) && !empty($sql)){
			return mysqli_real_escape_string($this->connection, $sql);
		}
	}
	function qr_id(){
		return mysqli_insert_id($this->connection);
	}
}
?>