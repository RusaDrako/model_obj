<?php

namespace RusaDrako\model_obj;

/**
 *
 */
class factory {

	private $obj_class          = [];
	/** Объект модели */
	private static $_object		= null;





	/** */
	function __construct() {}



	/** Вызов объекта */
	public static function call(...$args) {
		# Проверяем отсутствие объекта заданного класса в массиве объектов
		if (!isset(self::$_object)) {
			# Создаём объект и запоминаем его
			self::$_object = new static(...$args);
		}
		# Возвращаем указанный объект
		return self::$_object;
	}



	/** Возвращает класс данных */
	public function getObj($name) {
		if (array_key_exists($name, $this->obj_class)) { return $this->obj_class[$name];}

		$class = $this->selection_object($name);

		$this->obj_class[$name] = $class;
		return $this->obj_class[$name];
	}



	/** Производит формирование объекта
	 * @param String $alias - псевдоним объекта
	 */
	protected function selection_object($alias) {}


/**/
}
