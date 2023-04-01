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





	/** Магический метод: Возвращает значениесвойства, если оно существует
	 * @param string $name Имя свойства
	 */
	final public function __get($name) {
		# Базовый свойства
		if (array_key_exists($name, $this->alias)) {
			return $this->data[$this->alias[$name]];
		}
		# Дополнительные свойства
		if (array_key_exists($name, $this->data_extended)) {
			# Если это функция
			if (\is_callable($this->data_extended[$name])) {
				# Выполгняем её
				return $this->data_extended[$name]();
			} else {
				# просто возвращаем значение
				return $this->data_extended[$name];
			}
		}
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





	/** Возвращает значение свойства
	 * @param string $name Имя свойства
	 */
	final public function getProp(string $name) {
		return $this->$name;
	}





	/** Задаёт значение свойства
	 * @param string $name Имя свойства
	 * @param mixed $value Значение свойства
	 */
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
			return $this;
		}
		# Если это дополнительное свойство
		if (\array_key_exists($name, $this->data_extended)) {
			# Если есть метка о блокировке изменения дополнительного свойства (function, object)
			if (\array_key_exists($name, $this->data_extended_lock) && $this->data_extended_lock[$name]) {
				throw new \Exception("Свойство заблокировано для изменения: " . \get_called_class() . "->{$name}");
			}
			$this->data_extended[$name] = $value;
			return $this;
		}
		throw new \Exception("Вызов неизвестного свойства объекта: " . \get_called_class() . "->{$name}->{$value}");
	}





	/** Задаёт значения свойств
	 * @param array $data Массив свойств
	 */
	final public function setProps(array $data) {
		foreach ($data as $k => $v) {
			$this->setProp($k, $v);
		}
	}





	/** Фильтр обновления данных
	 * @param string $name Имя свойства
	 * @param mixed $value Значение свойства
	 */
	protected function filter(string $name, $value) {
		return $value;
	}



/**/
}
