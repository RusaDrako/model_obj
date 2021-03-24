<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data {

	use trait__data__set;
	use trait__data__db;

	protected $key             = null;
	protected $key_name        = null;
	protected $data            = [];
	protected $data_gen        = [];
	protected $alias           = [];
	protected $data_obj        = [];
//	protected $change          = false;
	protected $change_column   = false;





	/** */
	final public function __get($name) {
		if (array_key_exists($name, $this->alias)) {
			return $this->data[$this->alias[$name]];
		}
		if (array_key_exists($name, $this->data_gen)) {
			return $this->data_gen[$name]();
		}
		if (array_key_exists($name, $this->data_obj)) {
			return $this->data_obj[$name];
		}
		echo '<pre>';
		print_r($this->alias);
		print_r($this->data_gen);
		print_r($this->data_obj);
		throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$name}");
	}





	/** Возвращает ID элемента */
	final public function getKey() {
		return $this->key;
	}





	/** Возвращает имя ключевого поля */
	final public function getKeyName() {
		return $this->key_name;
	}





	/** Возвращает свойство */
	final public function getProp(string $name) {
		return $this->$name;
	}





	/** Задаёт свойство */
	final public function setProp(string $name, $value) {
		if (\array_key_exists($name, $this->alias)) {
			$value = $this->filter($name, $value);
			# Если данные меняются
			if ($this->data[$this->alias[$name]] != $value) {
				# Метка об изменении данных
				$this->change_column[$this->alias[$name]] = true;
			}
			$this->data[$this->alias[$name]] = $value;
			return;
		}
		echo '<pre>';
		print_r($this->alias);
		throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$name}->{$value}");
	}





	/** Фильтр обновления данных */
	protected function filter($name, $value) {}



/**/
}
