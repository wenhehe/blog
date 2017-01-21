<?php 
abstract class aDB {
	/**
	 * 连接数据库，从配置文件读取配置信息
	 */
	abstract public function conn();

	/**
	 * 发送juery查询
	 * @param string $sql sql语句
	 * @return mixed
	 */
	abstract public function query($sql);

	/**
	 * 查询多行数据
	 * @param string $sql sql语句
	 * @return array
	 */
	abstract public function getAll($sql);

	/**
	 * 单行数据
	 * @param string $sql sql语句
	 * @return array
	 */
	abstract public function getRow($sql);

	/**
	 * 查询单个数据，如 count(*)
	 * @param string $sql sql语句
	 * @return mixed
	 */
	abstract public function getOne($sql);

	/**
	 * 自动创建sql并执行
	 * @param array $data 关联数组  键/值与表的列/值对应
	 * @param string $table 表名字
	 * @param string $act 动作/update/insert
	 * @param string $where 条件,用于update
	 * @return int 新插入的行主键值或影响行数
	 */
	abstract public function Exec($data , $table , $act='insert' , $where='0');

	/**
	 * 返回上一条insert语句产生的主键值
	 */
	abstract public function lastId();

	/**
	 * 上一条语句影响的行数
	 */
	abstract public function affectRows();
}

class Mysql extends aDB{
	public $link;
	public function __construct(){
		$this->conn();
	}
	/**
	 * 连接数据库，从配置文件读取配置信息
	 */
	public function conn(){
		$cfg = include(ROOT.'/lib/config.php');
		$this->link =new mysqli($cfg['host'],$cfg['user'],$cfg['password'],$cfg['db']);		
		$this->query('set names ' .$cfg['charset']);
	}

	/**
	 * 发送juery查询
	 * @param string $sql sql语句
	 * @return mixed
	 */
	public function query($sql){
		$res = $this->link->query($sql);
		if($res === false){
			$this->log($sql."\n".mysqli_error($this->link));
			return $res;
		}
		$this->log($sql);
		return $res;
	}
	
	public function log($log){
		$path =ROOT.'/log/'.date('Ymd',time()).'.txt';
		$head = "-----------------------------------\n".date('Y/m/d H:i:s',time())."\n".$log."\n-----------------------------------\n\n";
		file_put_contents($path, $head,FILE_APPEND);
	}

	/**
	 * 查询多行数据
	 * @param string $sql sql语句
	 * @return array
	 */
	public function getAll($sql){
		$rs = $this->query($sql);
		while($row = $rs->fetch_assoc()){
			$date[]=$row;
		}
		return $date;
	}

	/**
	 * 单行数据
	 * @param string $sql sql语句
	 * @return array
	 */
	public function getRow($sql){
		$rs = $this->query($sql);
		$row = $rs->fetch_assoc();
		return $row;
	}

	/**
	 * 查询单个数据，如 count(*)
	 * @param string $sql sql语句
	 * @return mixed
	 */
	public function getOne($sql){
		$rs = $this->query($sql);
		$row = $rs->fetch_row();
		return $row[0];
	}

	/**
	 * 自动创建sql并执行
	 * @param array $data 关联数组  键/值与表的列/值对应
	 * @param string $table 表名字
	 * @param string $act 动作/update/insert
	 * @param string $where 条件,用于update
	 * @return int 新插入的行主键值或影响行数
	 */
	public function Exec($data , $table , $act='insert' , $where='0'){
		if($act =='insert'){
			//insert into cat (cat_id,catname) values ('2','技术');
			//var_dump($data);
			$sql = 'insert into '.$table;
			$sql.= ' ('.implode(',',array_keys($data));
			$sql.= ") values ('".implode("','",array_values($data))."')";
			return $this->query($sql);		
		}elseif($act =='update'){
			$sql = "update ".$table." set ";
			foreach($data as $k=>$v){
				$sql.=$k." = '".$v."',";
			}
			$sql = rtrim($sql,',');
			$sql.=" where ".$where; 
			return $this->query($sql);
		}
	}

	/**
	 * 返回上一条insert语句产生的主键值
	 */
	public function lastId(){
		return $this->link->insert_id;
	}

	/**
	 * 上一条语句影响的行数
	 */
	public function affectRows(){
		  return $this->link->affected_rows;
	}
}
// $mysql = new Mysql();
// $mysql->Exec(['catname'=>'狂魔1'],'cat','update','num=5');
// var_dump($mysql->affectRows());
?>