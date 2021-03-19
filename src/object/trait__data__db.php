<?php
namespace RusaDrako\model_obj\object;
/**
 *
 */
trait trait__data__db {

	protected $obj_data       = null;





	/** Сохраняет элемент */
	public function save() {
		if (!$this->change) {	return;}

		if ($this->key) {
			$arr_update = $this->data;
			$this->obj_data->update($arr_update, "{$this->key_name} = {$this->key}");
		} else {
			if (\array_key_exists('CREATED', $this->alias)) {
				$this->setData('CREATED', date('Y-m-d H:i:s'));
			}
			$this->data[$this->key_name] = $this->key = $this->obj_data->insert($this->data);
		}
		$this->change = false;
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
