<?php
namespace RusaDrako\model_obj\template;


/**
 * Класс для работы с шаблонами классов
 */
class data /*extends \RusaDrako\model_obj\data*/ {


	private $obj_db = null;



 	/** */
 	public function __construct($db) {
 		$this->obj_db = $db;
 	}



	/** Возвращает массив БД */
	public function getDbArray() {
		$sql = "SHOW DATABASES;";
		# Возвращаем результат
		return $this->obj_db->select($sql);
	}



	/** Возвращает массив таблиц в БД */
	public function getTableArray($db) {
		$sql = "SHOW TABLES FROM {$db};";
		# Возвращаем результат
		return $this->obj_db->select($sql);
	}



	/* * Возвращает массив столбцов в таблице БД * /
	public function getColumnArray($table) {
		$sql = "SHOW COLUMNS FROM {$table}";
		# Возвращаем результат
		return $this->obj_db->select($sql);
	}



	/** Возвращает массив с полной информацией по столбцам в таблице БД */
	public function getColumnArrayFull($db, $table) {
		$sql = "SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='{$db}' AND TABLE_NAME='{$table}'";
		# Возвращаем результат
		return $this->obj_db->select($sql);
	}



/**/
}
