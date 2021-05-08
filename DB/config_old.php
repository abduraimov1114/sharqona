<?
// BAZAGA ULANUVCHI CLASS
class database{
	//uzgaruvchilar
	protected $dbhost  = 'localhost';    	// o'zgartirish shart emas
	protected $dbname  = 'admin_compass'; // Ma'lumotlar bazasi nomi
	protected $dbuser  = 'admin_superadmin';   	// user nomi
	protected $dbpass  = 'zA^t*2N1KyJbUTZ';   // parol
	public $connection;
	public $sql;
	public function secur($sql){
		return mysqli_real_escape_string($this->connection,$sql);
	}
// constanta
const SITE='http://compas.uz';
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
}
?>