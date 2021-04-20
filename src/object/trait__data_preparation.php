<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data_preparation {



	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable)
	 * @param array $arr Исходный массив для вывода
	 */
	protected function __preparationData($arr) {
		$arr['key'] = $this->key;
		foreach ($this->alias as $k => $v) {
			$arr[$k] = $this->data[$v];
		}

		if ($this->data_extended) {
			$_arr = [];
			foreach ($this->data_extended as $k => $v) {
				$key_add = \array_key_exists($k, $this->data_extended_lock) ? ' (lock)' : '';
				# Если это функция
				if (\is_callable($v)) {
					$_arr[$k.$key_add] = $v();
				} else {
					$_arr[$k.$key_add] = $v;
				}
			}
			$arr['add_data'] = $_arr;
		}
		\ksort($this->arr_link_obj);
		if ($this->arr_link_obj) {
			foreach ($this->arr_link_obj as $k => $v) {
				$arr[$k] = $v;
			}
		}
		return $arr;
	}





/**/
}
