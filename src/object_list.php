<?php
namespace RusaDrako\model_obj;

/**
 * Класс списка элементов
 */
class object_list implements \JsonSerializable {

	/* Массив данных */
	protected $arr_data = [];



	/** */
	public function __construct() {}



	/** Подготовка данных к var_dump() */
	public function __debugInfo() {
		$arr = $this->__preparationData([]);
		return $arr;
	}



	/** Подготовка данных к серилизации JSON (JsonSerializable) */
	public function jsonSerialize() : mixed {
		$arr = $this->__preparationData([]);
		return $arr;
	}



	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable)*/
	protected function __preparationData() {
		return $this->arr_data;
	}



	/** Добавляет элемент в список
	 * @param object $item Элемент списка
	 */
	public function add(\RusaDrako\model_obj\object_item $item) {
		$this->arr_data[] = $item;
	}



	/** Добавляет элемент в список из другого списка
	 * @param object $list Список элементов
	 */
	public function addList(\RusaDrako\model_obj\object_list $list) {
		foreach ($list->iterator() as $k => $v) {
			$this->add($v);
		}
	}



	/** Возвращает указанный элемент
	 * @param int $num номер элемента
	 */
	public function item(int $num) {
		if (!isset($this->arr_data[$num])) {return null;}
		return $this->arr_data[$num];
	}



	/** Возвращает первый элемент */
	public function first() {
		return $this->item(0);
	}



	/** Возвращает последний элемент */
	public function last() {
		$count = $this->count() - 1;
		return $this->item($count);
	}



	/** Осуществляет перебор элементов */
	public function iterator() {
		foreach ($this->arr_data as $v) {
			yield $v;
		}
	}



	/** Возвращает массив элементов */
	public function get_array() {
		return $this->arr_data;
	}



	/** Возвращает число элементов */
	public function count() {
		return count($this->arr_data);
	}



	/** Сохраняет все элементы списка */
	public function saveAll() {
		foreach ($this->iterator() as $v) {
			$v->save();
		}
	}



/**/
}
