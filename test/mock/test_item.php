<?php
namespace test;


/**
 * Тестовый класс
 */
class test_item extends \RD_Obj_Item {



	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) */
	protected function __preparationData($arr) {
		# Получаем типовой набор данных
		$arr = parent::__preparationData($arr);
		# Скрываем поля
//		unset($arr['ID']);/**/
		return $arr;
	}/**/





	/** Настройки объекта */
	protected function setting() {
		# Ключевое поле объекта
		$this->set_column_id('id');

		# Основные свойства объекта (соответствуют столбцам таблицы)
		$column = [
			'id'        => 'ID',        #
			'data_1'    => 'DATA_1',    #
			'data_2'    => 'DATA_2',    #
		];
		foreach ($column as $k => $v) {
			$this->set_column_name($k, $v);
		}

		# Дополнительные свойства объекта (изменяются в процессе работы)
		$function = [
			'SUB_DATA_1'   => 'sub_test_data_1',
		];
		foreach ($function as $k => $v) {
			$this->set_add_data($k, $v);
		}/**/

		# Свойства-функции (в процессе работы не могут быть изменены)
		$function = [
			'SUB_FUNC'   => function() {return ':::' . $this->DATA_1 . ':::';},
		];
		foreach ($function as $k => $v) {
			$this->set_gen_data($k, $v);
		}/**/

		# Свойства-объекты (в процессе работы не могут быть изменены)
		$object = [
			'SUB_OBJ'        => new sub_class(),/**/
		];
		foreach ($object as $k => $v) {
			$this->set_sub_obj($k, $v);
		}/**/
	}





	/** Заполнение свойств объекта */
	protected function filter($name, $value) {
		$value = parent::filter($name, $value);
		return $value;
	}





	/** Сохранение записи */
	public function save() {
		parent::save();
	}



/**/
}




/**
 * Дополнительный тестовый класс
 */
class sub_class {
	public $PROP_1 = 'test_sub_obj_data_1';
	public function method_1($a) { return $a;}
}
