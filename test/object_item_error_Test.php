<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item_error_function.php');
require_once(__DIR__ . '/mock/test_item_error_object.php');





/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class object_item_error_Test extends TestCase {



	/** Генератор заглушки элемента */
	public function mock_data() {
		$this->_test_data_mock = $this->createMock(RD_Obj_Data::class);
		return $this->_test_data_mock;
	}



	/** Проверяет получение знвчения ключевого столбца */
	public function test_error_prop_function() {
		$result = null;
		try {
			$obj = new \test\test_item_error_function($this->mock_data());
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Значение свойства формируемого методом set_gen_data должно иметь тип callable: test\test_item_error_function->SUB_FUNC', 'Должен выдать ошибку');
	}



	/** Проверяет получение знвчения ключевого столбца */
	public function test_error_prop_object() {
		$result = null;
		try {
			$obj = new \test\test_item_error_object($this->mock_data());
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Значение свойства формируемого методом set_sub_obj должно иметь тип object: test\test_item_error_object->SUB_OBJ', 'Должен выдать ошибку');
	}



/**/
}
