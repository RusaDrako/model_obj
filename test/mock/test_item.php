<?php
namespace test;


/**
 *
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

		# Генерируемые свойства объекта
		$function = [
			'STR_DATA_1'   => function() {return ':::' . $this->DATA_1 . ':::';},
		];
		foreach ($function as $k => $v) {
			$this->set_gen_data($k, $v);
		}/**/

		# Дополнительные объекты работы с данными
		$object = [
/*			'LIST_TEST_2'        => \factory::call()->getObj('test_2'),/**/
/*			'OBJ_ADDRESS'        => new \object\_common\contact\address(),/**/
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
