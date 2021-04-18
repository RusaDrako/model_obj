<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data_preparation {



	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) */
	protected function __preparationData($arr) {
		$arr['key'] = $this->key;
		foreach ($this->alias as $k => $v) {
			$arr[$k] = $this->data[$v];
		}

		if ($this->data_extended) {
			$_arr = [];
			foreach ($this->data_extended as $k => $v) {
				$key_add = \array_key_exists($k) ? ' (lock)' : '';
				# Если это функция
				if (\is_callable($v[$k])) {
					$_arr[$k.$key_add] = $v[$k]();
				} else {
					$_arr[$k.$key_add] = $v[$k];
				}
			}
			$arr['add_data'] = $_arr;
		}
/*		if ($this->data_gen) {
			$_arr = [];
			foreach ($this->data_gen as $k => $v) {
				$_arr[$k] = $v();
			}
			$arr['generation_data'] = $_arr;
		}
		if ($this->data_obj) {
			$_arr = [];
			foreach ($this->data_obj as $k => $v) {
				$_arr[$k] = $v;
			}
			$arr['obj_data'] = $_arr;
		}*/
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
