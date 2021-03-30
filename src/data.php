<?php
namespace RusaDrako\model_obj;

/**
 *
 */
class data {

	/** Имя таблицы */
	protected $table_name            = null;
	/** Имя ключевого поля */
	protected $id_name               = null;
	/** Объект подключения к БД */
	protected $obj_db                = null;
	/** Имя класса объекта */
	protected $class_obj_name        = null;
	/** Имя класса объекта списка */
	protected $class_obj_list_name   = null;
	/** Контрольный элемент */
	protected $control_item          = null;





	/** */
	public function __construct(/*RusaDrako\model_obj\intf_data*/ $db, $class_obj_name, $class_obj_list_name = 'RusaDrako\model_obj\object_list') {
		$this->obj_db = $db;
		$this->class_obj_name = $class_obj_name;
		$this->class_obj_list_name = $class_obj_list_name;
		$this->data = $this->setting();
		$this->control_item = $this->newItem();
		$this->id_name = $this->control_item->getKeyName();
	}



	/** */
	public function __debugInfo() {return [get_called_class()];}



	/** Дополнительные настройки класса */
	protected function setting() {}



	/** Создаёт новый объект */
	public function newItem() {
		return $this->newObject([]);
	}



	/** Создаёт объект */
	protected function newObject($arr_data) {
		$class = $this->class_obj_name;
		$obj = new $class($this);
		$obj->setDataArrDB($arr_data);
		return $obj;
	}



	/** Создаёт объект списка */
	protected function newObjectList() {
		$class = $this->class_obj_list_name;
		$obj = new $class($this);
		return $obj;
	}



	/** Возвращает элементы полученные по запросу */
	public function select(string $sql) {
		$sql = $this->replace_alias($sql);
		$data = $this->obj_db->select($sql);
		$obj_list = $this->newObjectList();
		foreach ($data as $v) {
			$obj_list->add($this->newObject($v));
		}
		return $obj_list;
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
		$col = $this->control_item->getDBColumnList();
		$key = $this->control_item->getKeyName();
		if (!$col) {
			$col = '*';
		}
		$sql = \str_replace(':key:', $key, $sql);
		$sql = \str_replace(':col:', $col, $sql);
		$sql = \str_replace(':tab:', $this->table_name, $sql);
		return $sql;
	}










	/** Возвращает запись по id */
	public function getByKey(int $id) {
		if (!$id) { return [];}
		$sql = "SELECT :col: FROM :tab: WHERE {$this->id_name} = {$id}";
		$data = $this->select($sql);
		$data = $data->first();
		return $data;
	}



	/** Возвращает все записи */
	public function getAll() {
		$sql = "SELECT :col: FROM :tab:";
		$data = $this->select($sql);
		return $data;
	}





/**/
}
