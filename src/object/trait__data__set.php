<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data__set {



	/** Задаёт имя ключевого поля
	 * @param string $name Имя ключевого столбца
	 */
	final protected function set_column_id(string $name) {
		$this->key_name = $name;
	}





	/** Задаёт имя и псевдоним поля
	 * @param string $name Имя столбца
	 * @param string $alias Псевдоним-свойство
	 */
	final protected function set_column_name(string $name, string $alias = null) {
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





	/** Задаёт имя и значение дополнительного свойства
	 * @param string $name Имя свойства
	 * @param mixed $value Значение свойства
	 * @param string $lock Блокировка свойства
	 */
	final protected function set_extended(string $name, $value, bool $lock = false) {
		if (\array_key_exists($name, $this->data_extended)) {
			throw new \Exception("Дублирование дополнительного свойства объекта: " . \get_called_class() . "->{$name}");
		}
		$this->data_extended[$name] = $value;
		if ($lock) {
			$this->data_extended_lock[$name] = $lock;
		}
	}





	/** Задаёт произвольное дополнительное свойство
	 * @param string $name Имя свойства
	 * @param mixed $value Значение свойства
	 */
	final protected function set_add_data(string $name, $value = null) {
		$this->set_extended($name, $value);
	}





	/** Задаёт имя и значение свойства-функции
	 * @param string $name Имя свойства
	 * @param callback $func Значение свойства
	 */
	final protected function set_gen_data(string $name, $func) {
		if (!\is_callable($func)) {
			throw new \Exception("Значение свойства формируемого методом " . __FUNCTION__ . " должно иметь тип callable: " . \get_called_class() . "->{$name}");
		}
		$this->set_extended($name, $func, true);
	}





	/** Задаёт имя и значение свойства-объект
	 * @param string $name Имя свойства
	 * @param object $obj Значение свойства
	 */
	final protected function set_sub_obj(string $name, $obj) {
		if (!\is_object($obj)) {
			throw new \Exception("Значение свойства формируемого методом " . __FUNCTION__ . " должно иметь тип object: " . \get_called_class() . "->{$name}");
		}
		$this->set_extended($name, $obj, true);
	}





/**/
}
