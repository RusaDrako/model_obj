<?php
namespace test;


/**
 * Тестовый класс
 */
class test_item_error_function extends \RD_Obj_Item {



	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) */
	protected function __preparationData($arr) {
//		# Получаем типовой набор данных
//		$arr = parent::__preparationData($arr);
		# Скрываем поля
//		unset($arr['ID']);/**/
		return $arr;
	}/**/





	/** Настройки объекта */
	protected function setting() {
		# Свойства-функции (в процессе работы не могут быть изменены)
		$function = [
			'SUB_FUNC'   => 123,
		];
		foreach ($function as $k => $v) {
			$this->set_gen_data($k, $v);
		}/**/
	}





	/** Заполнение свойств объекта */
	protected function filter($name, $value) {
//		$value = parent::filter($name, $value);
		return $value;
	}





	/** Сохранение записи */
	public function save() {
//		parent::save();
	}



/**/
}
