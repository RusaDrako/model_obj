<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item.php');
require_once(__DIR__ . '/mock/test_data.php');
//require_once(__DIR__ . '/mock/stub_db.php');





/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class data_Test extends TestCase {
	/** */
	private $class_name_data = 'test\test_data';
	private $class_name_item = 'test\test_item';
	private $class_name_item_control = 'RusaDrako\\model_obj\\object_item';
	private $class_name_list_control = 'RusaDrako\\model_obj\\object_list';
	/** Тестируемый объект */
	private $_test_object = null;
	/** Тестируемый объект */
	private $_test_db_mock = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$class_name = $this->class_name_data;
		$this->_test_object = new $class_name($this->mock_db(),  $this->class_name_item);
//		$arr_data = ['id' => 99, 'data_1' => "data 1 - 99", 'data_2' => "data 2 - 99"];
//		$this->_test_object->setDataArrDB($arr_data);
//		print_r($this->_test_object);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Генератор заглушки элемента */
	public function mock_db() {
		$mock = $this->getMockBuilder('db')
			->setMethods(['select'])
			->setMethods(['insert'])
			->setMethods(['update'])
//			->enableArgumentCloning()
			->getMock();
		// Настроить заглушку.
		$this->_test_db_mock = $mock;
		return $this->_test_db_mock;
	}



	/** */
	public function test_newItem() {
		$result = $this->_test_object->newItem();
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals(\get_class($result), $this->class_name_item, 'Неверный класс');
	}



	/** */
	public function test_select() {
		$sql = '123';
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo($sql))
			->willReturn(
//				[[], [], [],]
				[
					['id' => 1],
					['id' => 2],
					['id' => 3],
				]
			);
		$result = $this->_test_object->select($sql);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_list_control), 'Класс элемента не найден');
		$this->assertEquals($result->count(), 3, 'Кол-во элементов не совпадает');
	}



	/** */
	public function test_insert() {
		$arr_data = ['test_data' => 123];
		$this->_test_db_mock->expects($this->once())
			->method('insert')
			->with($this->equalTo('test_1'), $this->equalTo($arr_data))
			->willReturn(555);
		$result = $this->_test_object->insert($arr_data);
		$this->assertEquals($result, 555, 'Ответ не верен');
	}



	/** */
	public function test_update() {
		$arr_data = ['test_data' => 123];
		$id = 888;
		$this->_test_db_mock->expects($this->once())
			->method('update')
			->with($this->equalTo('test_1'), $this->equalTo($arr_data), $id)
			->willReturn(true);
		$result = $this->_test_object->update($arr_data, $id);
		$this->assertTrue($result, 'Ответ не верен');
	}



/**/
}
