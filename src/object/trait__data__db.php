<?php
namespace RusaDrako\model_obj\object;
/**
 *
 */
trait trait__data__db {

	protected $obj_data       = null;





	/** Сохраняет элемент */
	public function save() {
		if (!$this->change_column) {	return;}
		$arr_update = $this->data;
		$arr_update = \array_intersect_key($arr_update, $this->change_column);
		if ($this->key) {
			$this->obj_data->update($arr_update, "{$this->key_name} = {$this->key}");
		} else {
			$this->data[$this->key_name] = $this->key = $this->obj_data->insert($arr_update);
		}
		$this->change_column = [];
	}



	/** Задаёт свойства из массива (БД) */
	final public function setDataArrDB(array $arr_data) {
		foreach($arr_data as $k => $v) {
			# Проверка доступности поля
			if (!array_key_exists($k, $this->data)) {
				echo '<pre>';
				print_r($this->data);
				throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$k}->{$v}");
			}
			# Фильтруем (+ находим псевдоним столбца)
			$v = $this->filter(\array_search($k, $this->alias), $v);
			# Если это ключевое поле
			if ($k == $this->key_name) {
				$this->key = $v;
				$this->data[$k] = $v;
			} else {
				$this->data[$k] = $v;
			}
		}
	}



/**/
}
