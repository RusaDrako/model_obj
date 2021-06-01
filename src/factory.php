<?php

namespace RusaDrako\model_obj;

/**
 * Класс фабрики объектов
 */
abstract class factory {

	/** Массив созданных объектов */
	private $obj_class          = [];
	/** Объект модели */
	private static $_object		= null;





	/** */
	public function __construct() {}



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



	/** Возвращает сформированный объект
	 * @param string $alias Фабричное имя объекта
	 */
	public function getObj($alias, ...$arg) {
		if (array_key_exists($alias, $this->obj_class)) { return $this->obj_class[$alias];}

		$class = $this->selection_object($alias, ...$arg);

		$this->obj_class[$alias] = $class;
		return $this->obj_class[$alias];
	}



	/** Производит формирование объекта
	 * @param String $alias - псевдоним объекта
	 */
	abstract protected function selection_object($alias, ...$arg);



/**/
}
