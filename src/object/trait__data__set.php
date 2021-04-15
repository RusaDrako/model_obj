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





	/** Задаёт связанную со свойством функцию */
	final protected function set_gen_data($name, $func) {
		if (\array_key_exists($name, $this->data_gen)) {
			throw new \Exception("Дублирование генератора данных: " . \get_called_class() . "->{$name}");
		}
		$this->data_gen[$name] = $func;
	}





	/** Задаёт связанный со свойством объект */
	final protected function set_sub_obj($name, $obj) {
		if (\array_key_exists($name, $this->data_obj)) {
			throw new \Exception("Дублирование генератора данных: " . \get_called_class() . "->{$name}");
		}
		$this->data_obj[$name] = $obj;
	}





/**/
}
