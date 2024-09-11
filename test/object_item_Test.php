<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item.php');





/**
 * @author Петухов Леонид <rusadrako@yandex.ru>
 */
class object_item_Test extends TestCase {
	/** */
	private $class_name_item = 'test\test_item';
	private $arr_data = ['id' => 99, 'data_1' => "data 1 - 99", 'data_2' => "data 2 - 99"];
//	private $token = '0123456789ABCDEF';
	/** Тестируемый объект */
	private $_test_object = null;
	/** Тестируемый объект */
	private $_test_data_mock = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$class_name = $this->class_name_item;
		$this->_test_object = new $class_name($this->mock_data());
		$this->_test_object->setDataArrDB($this->arr_data);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Генератор заглушки элемента */
	public function mock_data() {
		$this->_test_data_mock = $this->createMock(RD_Obj_Data::class);
		return $this->_test_data_mock;
	}



	/** Проверяет получение знвчения ключевого столбца */
	public function test_getKey() {
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка getKey()');
	}



	/** Проверяет получение имени ключевого столбца */
	public function test_getKeyName() {
		$this->assertEquals($this->_test_object->getKeyName(), 'id', 'Проверка getKeyName()');
	}



	/** Проверяет получение свойств объекта (напрямую и через getProp)*/
	public function testt_control_data() {
		$this->assertEquals($this->_test_object->getProp('ID'), 99, 'Проверка getProp(ID)');
		$this->assertEquals($this->_test_object->ID, 99, 'Проверка ID');
		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'data 1 - 99', 'Проверка getProp(DATA_1)');
		$this->assertEquals($this->_test_object->DATA_1, 'data 1 - 99', 'Проверка DATA_1');
		$this->assertEquals($this->_test_object->getProp('DATA_2'), 'data 2 - 99', 'Проверка getProp(DATA_2)');
		$this->assertEquals($this->_test_object->DATA_2, 'data 2 - 99', 'Проверка DATA_2');

		$this->assertEquals($this->_test_object->getProp('SUB_DATA_1'), 'sub_test_data_1', 'Проверка getProp(SUB_DATA_1)');
		$this->assertEquals($this->_test_object->SUB_DATA_1, 'sub_test_data_1', 'Проверка SUB_DATA_1');

		$this->assertEquals($this->_test_object->getProp('SUB_FUNC'), ':::data 1 - 99:::', 'Проверка getProp(SUB_FUNC)');
		$this->assertEquals($this->_test_object->SUB_FUNC, ':::data 1 - 99:::', 'Проверка SUB_FUNC');

		$this->assertEquals($this->_test_object->getProp('SUB_OBJ')->PROP_1, 'test_sub_obj_data_1', 'Проверка getProp(SUB_OBJ)->PROP_1');
		$this->assertEquals($this->_test_object->SUB_OBJ->PROP_1, 'test_sub_obj_data_1', 'Проверка SUB_OBJ->PROP_1');
		$this->assertEquals($this->_test_object->getProp('SUB_OBJ')->method_1('test_sub_obj_method_1'), 'test_sub_obj_method_1', 'Проверка getProp(SUB_OBJ)->method_1()');
		$this->assertEquals($this->_test_object->SUB_OBJ->method_1('test_sub_obj_method_1'), 'test_sub_obj_method_1', 'Проверка SUB_OBJ->method_1()');
	}



	/** Проверяет "смену" ключа */
	public function test_set_key() {
		$this->_test_object->setProp('ID', '88');
		$this->assertEquals($this->_test_object->getProp('ID'), 88, 'Проверка изменения ID');
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка изменения key');
	}



	/** Проверяет смену ключа */
	public function test_setProp() {
		$this->_test_object->setProp('DATA_1', 'new');
		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'new', 'Проверка изменения DATA_1');
		$this->assertEquals($this->_test_object->getProp('SUB_FUNC'), ':::new:::', 'Проверка изменения SUB_FUNC');

		$this->_test_object->setProp('SUB_DATA_1', 'new');
		$this->assertEquals($this->_test_object->SUB_DATA_1, 'new', 'Проверка изменения SUB_DATA_1');
	}



	/** Проверяет установку параметров цепочкой */
	public function test_setProp_chain_execution() {
		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'data 1 - 99', 'Проверка изменения DATA_1');
		$this->assertEquals($this->_test_object->getProp('DATA_2'), 'data 2 - 99', 'Проверка изменения DATA_2');
		# Должен вернуть текущий объект
		$obj = $this->_test_object->setProp('DATA_1', 'new1')->setProp('DATA_2', 'new2');
		$this->assertEquals($this->_test_object, $obj, 'Несовпадение объектов');

		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'new1', 'Проверка изменения DATA_1');
		$this->assertEquals($this->_test_object->getProp('DATA_2'), 'new2', 'Проверка изменения DATA_2');
	}





	/** Проверяет смену ключа */
	public function test_setProp_exception() {
		$result = null;
		try {
			$this->_test_object->setProp('SUB_FUNC', 'new');
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Свойство заблокировано для изменения: test\test_item->SUB_FUNC', 'Должен выдать ошибку');
		$result = null;
		try {
			$this->_test_object->setProp('SUB_OBJ', 'new');
		} catch (\Exception $e) {
			$result = $e->getMessage();
		}
		$this->assertEquals($result, 'Свойство заблокировано для изменения: test\test_item->SUB_OBJ', 'Должен выдать ошибку');
	}



	/** Проверяет генерацию столбцов для БД */
	public function test_getDBColumnList() {
		$this->assertEquals($this->_test_object->getDBColumnList(), ':tab:.id, :tab:.data_1, :tab:.data_2', 'Проверка списка столбцов');
	}



	/** Проверяет сохранение существующего элемента (ключ - число) */
	public function test_save() {
		$this->_test_data_mock->expects($this->exactly(1))
			->method('update')
			->with(
				$this->equalTo(['data_2' => 'TEST']),
				$this->equalTo("id = 99")
			)
			->willReturn(true);

		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка изменения key');
		$this->assertEquals($this->_test_object->ID, 99, 'Проверка изменения key');
	}



	/** Проверяет сохранение существующего элемента (ключ - строка) */
	public function test_save_2() {
		$data_arr = ['id' => 'TEST_ID', 'data_2' => 'TEST_34'];
		$this->_test_object->setDataArrDB($data_arr);
		$this->_test_data_mock->expects($this->exactly(1))
			->method('update')
			->with(
				$this->equalTo(['data_2' => 'TEST']),
				$this->equalTo("id = 'TEST_ID'")
			)
			->willReturn(true);

		$this->_test_object->setDataArrDB($data_arr);
		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->setProp('ID', 'TEST_ID');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 'TEST_ID', 'Проверка изменения key');
		$this->assertEquals($this->_test_object->ID, 'TEST_ID', 'Проверка изменения key');
	}



	/** Проверяет сохранение нового элемента (ключ - число) */
	public function test_save_new() {
		$arr_data = ['data_2' => 'TEST'];
		$this->_test_data_mock->expects($this->exactly(1))
			->method('insert')
			->with(
				$this->equalTo($arr_data)
			)
			->willReturn(999);

		$class_name = $this->class_name_item;
		$this->_test_object = new $class_name($this->_test_data_mock);
		$this->assertNull($this->_test_object->getKey(), 'Ключ до сохранения');

		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 999, 'Ключ после сохранения');
	}



	/** Проверяет сохранение нового элемента (ключ - строка) */
	public function test_save_new_2() {
		$arr_data = ['id' => 'TEST_ID', 'data_2' => 'TEST'];
		$this->_test_data_mock->expects($this->exactly(1))
			->method('insert')
			->with(
				$this->equalTo($arr_data)
			)
			->willReturn('TEST_ID');

		$class_name = $this->class_name_item;
		$this->_test_object = new $class_name($this->_test_data_mock);
		$this->assertNull($this->_test_object->getKey(), 'Ключ до сохранения');

		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->setProp('ID', 'TEST_ID');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 'TEST_ID', 'Ключ после сохранения');
	}



	/** Проверяет установку дополнительного свойства через массив данных */
	public function test_add_att_data() {
		$this->assertEquals($this->_test_object->getProp('SUB_DATA_1'), 'sub_test_data_1', 'Данные не записаны');
		$new_arr = $this->arr_data;
		$this->arr_data['SUB_DATA_1'] = 'test new data';
		$this->_test_object->setDataArrDB($this->arr_data);

		$this->assertEquals($this->_test_object->getProp('SUB_DATA_1'), 'test new data', 'Данные не записаны');
	}



/**/
}
