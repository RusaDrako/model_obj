<?php
namespace RusaDrako\model_obj\object;

/**
 *
 */
trait trait__data {

	use trait__data__set;
	use trait__data__db;

	# Значение ключевого поля
	protected $key                  = null;
	# Имя ключевого поля
	protected $key_name             = null;
	# Псевдонимы базовых параметров (связанных с БД)
	protected $alias                = [];
	# Базовые параметры (связанных с БД)
	protected $data                 = [];
	# Дополнительные параметры
	protected $data_extended        = [];
	# Блокировка дополнительных параметров
	protected $data_extended_lock   = [];
	#
	protected $change_data          = false;





	/** */
	final public function __get($name) {
		if (array_key_exists($name, $this->alias)) {
			return $this->data[$this->alias[$name]];
		}
		if (array_key_exists($name, $this->data_extended)) {
			# Если это функция
			if (\is_callable($this->data_extended[$name])) {
				return $this->data_extended[$name]();
			} else {
				return $this->data_extended[$name];
			}
		}
/*		if (array_key_exists($name, $this->data_add)) {
			return $this->data_add[$name];
		}
		if (array_key_exists($name, $this->data_gen)) {
			return $this->data_gen[$name]();
		}
		if (array_key_exists($name, $this->data_obj)) {
			return $this->data_obj[$name];
		}/**/
		echo '<pre>';
		print_r($this->alias);
		print_r($this->$data_extended);
//		print_r($this->data_obj);
		throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$name}");
	}





	/** Возвращает ключ элемента */
	final public function getKey() {
		return $this->key;
	}





	/** Возвращает имя ключевого поля */
	final public function getKeyName() {
		return $this->key_name;
	}





	/** Возвращает значение свойства */
	final public function getProp(string $name) {
		return $this->$name;
	}





	/** Задаёт свойство */
	final public function setProp(string $name, $value) {
		# Если это базовое свойство
		if (\array_key_exists($name, $this->alias)) {
			# Пропускаем через фильтр
			$value = $this->filter($name, $value);
			# Если данные меняются
			if ($this->data[$this->alias[$name]] != $value) {
				# Метка об изменении данных
				$this->change_data[$this->alias[$name]] = true;
			}
			$this->data[$this->alias[$name]] = $value;
			return;
		}
		# Если это дополнительное свойство
		if (\array_key_exists($name, $this->data_extended)) {
			# Если есть метка о блокировке изменения дополнительного свойства (function, object)
			if (\array_key_exists($name, $this->data_extended_lock) && $this->data_extended_lock[$name]) {
				throw new \Exception("Свойство заблокировано для изменения: " . \get_called_class() . "->{$name}");
			}
			$this->data_extended[$name] = $value;
			return;
		}
		echo '<pre>';
		print_r($this->alias);
		print_r($this->data_extended);
		throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$name}->{$value}");
	}





	/** Фильтр обновления данных */
	protected function filter($name, $value) {
		return $value;
	}



/**/
}
