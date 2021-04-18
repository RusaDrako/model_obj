<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data__set {



	/** Задаёт имя ключевого поля */
	final protected function set_column_id($name) {
		$this->key_name = $name;
	}





	/** Задаёт имя и псевдоним поля */
	final protected function set_column_name($name, $alias = null) {
		if (!$alias) {$alias = $name;}
		if (\array_key_exists($alias, $this->alias)) {
			throw new \Exception("Дублирование псевдонима: " . \get_called_class() . "->{$alias}");
		}
		$this->alias[$alias] = $name;
		if (\array_key_exists($name, $this->data)) {
			throw new \Exception("Дублирование столбца: " . \get_called_class() . "->{$name}");
		}
		$this->data[$name] = null;
	}





	/** Задаёт имя и псевдоним поля */
	final protected function set_extended($name, $value, $lock = false) {
		if (\array_key_exists($name, $this->data_extended)) {
			throw new \Exception("Дублирование дополнительного свойства объекта: " . \get_called_class() . "->{$name}");
		}
		$this->data_extended[$name] = $value;
		if ($lock) {
			$this->data_extended_lock[$name] = $lock;
		}
	}





	/** Задаёт имя добавочных данных */
	final protected function set_add_data($name, $default = null) {
		$this->set_extended($name, $default);
	}





	/** Задаёт имя и псевдоним поля */
	final protected function set_gen_data($name, $func) {
		$this->set_extended($name, $func, true);
	}





	/** Задаёт связанный со свойством объект */
	final protected function set_sub_obj($name, $obj) {
		$this->set_extended($name, $obj, true);
	}





/**/
}
