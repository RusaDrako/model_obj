<?php
namespace RusaDrako\model_obj;

/**
 * Класс получения данных из БД
 */
class data {

	/** Имя таблицы */
	protected $table_name            = null;
	/** Объект подключения к БД */
	protected $obj_db                = null;
	/** Имя класса объекта */
	protected $class_obj_name        = null;
	/** Имя класса объекта списка */
	protected $class_obj_list_name   = null;
	/** Контрольный элемент */
	protected $control_item          = null;
	/** Имя ключевого поля */
	protected $id_name               = null;
	/** Список столцов для поиска */
	protected $column_name_list      = null;





	/** */
	public function __construct($db, $class_obj_name, $class_obj_list_name = 'RusaDrako\model_obj\object_list') {
		$this->obj_db                = $db;
		$this->class_obj_name        = $class_obj_name;
		$this->class_obj_list_name   = $class_obj_list_name;
		$this->data                  = $this->setting();
		$this->control_item          = $this->newItem();
		$this->id_name               = $this->control_item->getKeyName();
		$this->column_name_list      = $this->control_item->getDBColumnList();
	}



	/** */
	public function __debugInfo() {return [get_called_class()];}



	/** Дополнительные настройки класса */
	protected function setting() {}



	/** Создаёт новый объект */
	public function newItem($arr_data = []) {
		$class = $this->class_obj_name;
		$obj = new $class($this);
		$obj->setDataArrDB($arr_data);
		return $obj;
	}



	/** Создаёт объект списка */
	public function newList() {
		$class = $this->class_obj_list_name;
		$obj = new $class($this);
		return $obj;
	}



	/** Возвращает объект со списком объектов записей из запроса */
	public function select(string $sql) {
		$sql = $this->replace_alias($sql);
		$data = $this->obj_db->select($sql);
		$obj_list = $this->newList();
		foreach ($data as $v) {
			$obj_list->add($this->newItem($v));
		}
		return $obj_list;
	}



	/** Возвращает результат запроса */
	public function query(string $sql) {
		$sql = $this->replace_alias($sql);
		$result = $this->obj_db->query($sql);
		return $result;
	}



	/** Добавляет запись */
	public function insert($arr_data) {
		return $this->obj_db->insert($this->table_name, $arr_data);
	}



	/** Обновляет запись */
	public function update($arr_data, $id) {
		return $this->obj_db->update($this->table_name, $arr_data, $id);
	}



	/** Обновляет запроса - замена маркеров */
	protected function replace_alias($sql) {
		$col = $this->column_name_list;
		$key = $this->id_name;
		$sql = \str_replace(':key:',   ":tab:.{$key}",      $sql);
		$sql = \str_replace(':col:',   $col,                $sql);
		$sql = \str_replace(':tab:',   $this->table_name,   $sql);
		return $sql;
	}



/**/
}
