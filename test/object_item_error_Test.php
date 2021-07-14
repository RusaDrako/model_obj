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



	/** Проверяет ошибку при попытке присваить значение не определённому свойству */
	public function test_error_set_prop() {
		$result = null;
		try {
			$obj = new \test\test_item($this->mock_data());
			$obj->setProp('ERROR_DATA', 123);
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Вызов неизвестного свойства объекта: test\test_item->ERROR_DATA->123', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку при попытке получить значение не определённого свойства */
	public function test_error_get_prop() {
		$result = null;
		try {
			$obj = new \test\test_item($this->mock_data());
			$obj->getProp('ERROR_DATA');
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Вызов неизвестного свойства объекта: test\test_item->ERROR_DATA', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку при попытке получить значение не определённого свойства */
	public function test_error_get_prop_2() {
		$result = null;
		try {
			$obj = new \test\test_item($this->mock_data());
			$obj->ERROR_DATA_2;
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Вызов неизвестного свойства объекта: test\test_item->ERROR_DATA_2', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку в формировании callback свойства */
	public function test_error_prop_function() {
		$result = null;
		try {
			$obj = new \test\test_item_error_function($this->mock_data());
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Значение свойства формируемого методом set_gen_data должно иметь тип callable: test\test_item_error_function->SUB_FUNC', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку при попытке присваить значение callback свойству */
	public function test_error_set_prop_func() {
		$result = null;
		try {
			$obj = new \test\test_item($this->mock_data());
			$obj->setProp('SUB_FUNC', 123);
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Свойство заблокировано для изменения: test\test_item->SUB_FUNC', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку в формировании объектного свойства */
	public function test_error_prop_object() {
		$result = null;
		try {
			$obj = new \test\test_item_error_object($this->mock_data());
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Значение свойства формируемого методом set_sub_obj должно иметь тип object: test\test_item_error_object->SUB_OBJ', 'Должен выдать ошибку');
	}



	/** Проверяет ошибку при попытке присваить значение объектному свойству */
	public function test_error_set_prop_obj() {
		$result = null;
		try {
			$obj = new \test\test_item($this->mock_data());
			$obj->setProp('SUB_OBJ', 123);
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Свойство заблокировано для изменения: test\test_item->SUB_OBJ', 'Должен выдать ошибку');
	}



/**/
}
