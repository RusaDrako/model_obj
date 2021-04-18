<?php
namespace RusaDrako\model_obj;

/**
 * Класс списка элементов
 */
class object_list implements \JsonSerializable {

	/* Массив данных */
	protected $arr_data = [];
	/* Шаг итерации */
	protected $step = 0;



	/** */
	public function __construct() {}



	/** Подготовка данных к var_dump() */
	public function __debugInfo() {
		$arr = $this->__preparationData([]);
		return $arr;
	}



	/** Подготовка данных к серилизации JSON (JsonSerializable) */
	public function jsonSerialize() {
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
		foreach ($this->arr_data as $k => $v) {
			$this->step = $k;
			yield $v;
		}
	}



	/** Возвращает следующий элемент */
	public function next() {
		$this->step = $this->step + 1;
		if ($this->count() <= $this->step) { $this->step = 0;};
		return $this->item($this->step);
	}



	/** Возвращает предыдущий элемент */
	public function back() {
		$this->step = $this->step - 1;
		if (0 > $this->step) { $this->step = $this->count() - 1;}
		return $this->item($this->step);
	}



	/** Возвращает число элементов */
	public function count() {
		return count($this->arr_data);
	}



	/** Возвращает номер шага */
	public function step() {
		return $this->step;
	}



	/** Устанавливает номер шага на первый элемент */
	public function step_first() {
		$this->step = 0;
	}



	/** Устанавливает номер шага на последний элемент */
	public function step_last() {
		$this->step = $this->count() - 1;
	}



/**/
}
