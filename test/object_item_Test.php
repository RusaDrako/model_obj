<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item.php');





/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
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



	/** */
	public function test_control_data() {
		$this->assertEquals($this->_test_object->ID, 99, 'Проверка ID');
		$this->assertEquals($this->_test_object->DATA_1, 'data 1 - 99', 'Проверка DATA_1');
		$this->assertEquals($this->_test_object->DATA_2, 'data 2 - 99', 'Проверка DATA_2');
		$this->assertEquals($this->_test_object->STR_DATA_1, ':::data 1 - 99:::', 'Проверка STR_DATA_2');
	}



	/** */
	public function test_getKey() {
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка getKey()');
	}



	/** */
	public function test_getProp() {
		$this->assertEquals($this->_test_object->getProp('ID'), 99, 'Проверка ID');
		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'data 1 - 99', 'Проверка DATA_1');
		$this->assertEquals($this->_test_object->getProp('DATA_2'), 'data 2 - 99', 'Проверка DATA_2');
		$this->assertEquals($this->_test_object->getProp('STR_DATA_1'), ':::data 1 - 99:::', 'Проверка STR_DATA_1');
	}



	/** */
	public function test_setProp() {
		$this->_test_object->setProp('DATA_1', 'new');
		$this->assertEquals($this->_test_object->getProp('DATA_1'), 'new', 'Проверка изменения DATA_1');
		$this->assertEquals($this->_test_object->getProp('STR_DATA_1'), ':::new:::', 'Проверка изменения STR_DATA_1');
	}



	/** */
	public function test_set_key() {
		$this->_test_object->setProp('ID', '88');
		$this->assertEquals($this->_test_object->getProp('ID'), 88, 'Проверка изменения ID');
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка изменения key');
	}



	/** */
	public function test_save() {
		$arr_data = $this->arr_data;
		$arr_data['data_2'] = 'TEST'; // ['id' => 99, 'data_1' => 'data 1 - 99', 'data_2' => 'TEST'];
		$this->_test_data_mock->expects($this->exactly(1))
			->method('update')
			->with($this->equalTo($arr_data))
			->willReturn(true);

		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 99, 'Проверка изменения key');
		$this->assertEquals($this->_test_object->ID, 99, 'Проверка изменения key');
	}



	/** */
	public function test_save_new() {
		$arr_data = ['id' => null, 'data_1' => null, 'data_2' => 'TEST'];
		$this->_test_data_mock->expects($this->exactly(1))
			->method('insert')
			->with($this->equalTo($arr_data))
			->willReturn(999);

		$class_name = $this->class_name_item;
		$this->_test_object = new $class_name($this->_test_data_mock);
		$this->assertNull($this->_test_object->getKey(), 'Ключ до сохранения');
		$this->_test_object->setProp('DATA_2', 'TEST');
		$this->_test_object->save();
		$this->assertEquals($this->_test_object->getKey(), 999, 'Ключ после сохранения');
	}



/**/
}
