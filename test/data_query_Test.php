<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item.php');
require_once(__DIR__ . '/mock/test_data_query.php');
//require_once(__DIR__ . '/mock/stub_db.php');





/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class data_query_Test extends TestCase {
	/** */
	private $class_name_data = 'test\test_data_query';
	private $class_name_item = 'test\test_item';
	private $class_name_item_control = 'RusaDrako\\model_obj\\object_item';
	private $class_name_list_control = 'RusaDrako\\model_obj\\object_list';
	/** Тестируемый объект */
	private $_test_object = null;
	/** Объект-заглушка для БД */
	private $_test_db_mock = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$class_name = $this->class_name_data;
		$this->_test_object = new $class_name($this->mock_db(),  $this->class_name_item);
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Генератор заглушки элемента */
	public function mock_db() {
		$mock = $this->getMockBuilder('db')
			->setMethods(['select'])
			->setMethods(['insert'])
			->setMethods(['update'])
			->getMock();
		// Настроить заглушку.
		$this->_test_db_mock = $mock;
		return $this->_test_db_mock;
	}



	/** Проверяет получение данных по ключу */
	public function test_getByKey() {
		$id = 888;
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo('SELECT test_1.id, test_1.data_1, test_1.data_2 FROM test_1 WHERE test_1.id = 888'))
			->willReturn([['id' => '234']]);

		$result = $this->_test_object->getByKey($id);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->ID, 234, 'Кол-во элементов не совпадает');
	}



	/** Проверяет получение данных по ключу */
	public function test_getByKey_null() {
		$id = 0;
		$this->_test_db_mock->expects($this->never())
			->method('select')
			->willReturn([['id' => '234']]);

		$result = $this->_test_object->getByKey($id);
		$this->assertNull($result, 'Проверка на объект');
	}



	/** Проверяет получение всех данных */
	public function test_getAll() {
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo('SELECT test_1.id, test_1.data_1, test_1.data_2 FROM test_1'))
			->willReturn([['id' => '234']]);

		$result = $this->_test_object->getAll();
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_list_control), 'Класс элемента не найден');
		$this->assertEquals($result->count(), 1, 'Кол-во элементов не совпадает');
	}



	/** Проверяет получение данных по массиву ключей */
	public function test_getByKeyArray() {
		$id = [888, 999];
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo('SELECT test_1.id, test_1.data_1, test_1.data_2 FROM test_1 WHERE test_1.id IN (888, 999)'))
			->willReturn([['id' => '234'], ['id' => '235']]);

		$result = $this->_test_object->getByKeyArray($id);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_list_control), 'Класс элемента не найден');
		$this->assertEquals($result->count(), 2, 'Кол-во элементов не совпадает');

	}



	/** Проверяет получение данных по массиву ключей */
	public function test_getByKeyArray_null() {
		$id = [];
		$this->_test_db_mock->expects($this->never())
			->method('select')
			->willReturn([['id' => '234'], ['id' => '235']]);

		$result = $this->_test_object->getByKeyArray($id);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_list_control), 'Класс элемента не найден');
		$this->assertEquals($result->count(), 0, 'Кол-во элементов не совпадает');

	}



	/** Проверяет получение данных по ключу */
	public function test_getByKeyOrNew() {
		$id = 888;
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo("SELECT test_1.id, test_1.data_1, test_1.data_2 FROM test_1 WHERE test_1.id = 888"))
			->willReturn([['id' => '234']]);

		$result = $this->_test_object->getByKeyOrNew($id);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->ID, 234, 'Кол-во элементов не совпадает');
	}



	/** Проверяет получение данных по ключу */
	public function test_getByKeyOrNew_new() {
		$id = 888;
		$this->_test_db_mock->expects($this->once())
			->method('select')
			->with($this->equalTo("SELECT test_1.id, test_1.data_1, test_1.data_2 FROM test_1 WHERE test_1.id = 888"))
			->willReturn([]);

		$result = $this->_test_object->getByKeyOrNew($id);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->ID, null, 'Кол-во элементов не совпадает');
	}



/**/
}
