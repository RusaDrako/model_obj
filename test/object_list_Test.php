<?php

use PHPUnit\Framework\TestCase;

require_once(__DIR__ . '/../src/autoload.php');
require_once(__DIR__ . '/mock/test_item.php');





/**
 * @author Петухов Леонид <l.petuhov@okonti.ru>
 */
class object_list_Test extends TestCase {
	/** */
	private $class_name_item = 'test\test_item';
	private $class_name_item_control = 'RusaDrako\\model_obj\\object_item';
	/** Тестируемый объект */
	private $_test_object = null;



	/** Вызывается перед каждым запуском тестового метода */
	protected function setUp() : void {
		$this->_test_object = $this->newList(10);
	}



	/** Вызывается перед каждым запуском тестового метода */
	protected function newList($count) {
		$obj_list = new RD_Obj_List();
		for($i=0; $i<$count; $i++) {
			$j = $i + 1;
			$obj = $this->stub_item($i);
			$obj_list->add($obj);
		}
		return $obj_list;
	}



	/** Вызывается после каждого запуска тестового метода */
	protected function tearDown() : void {}



	/** Генератор заглушки элемента */
	public function stub_item($i = 0) {
		$stub_data = $this->createMock(RD_Obj_Data::class);
		$class_name = $this->class_name_item;
		$stub = new $class_name($stub_data);
		$arr_data = ['id' => $i+1, 'data_1' => "data 1 - {$j}", 'data_2' => "data 2 - {$j}"];
		$stub->setDataArrDB($arr_data);
		return $stub;/**/
	}





	/** */
	public function test_count() {
		$result = $this->_test_object->count();
		$this->assertEquals(
			$result, 10, 'Кол-во элементов не соответствует');
		for($i=10; $i<20; $i++) {
			$this->_test_object->add($this->stub_item($i));
		}
		$result = $this->_test_object->count();
		$this->assertEquals(
			$result, 20, 'Кол-во элементов не соответствует');
	}



	/** Контроль первого элемента */
	public function test_first() {
		$result = $this->_test_object->first();
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->getKey(), 1, 'Неверный ключ объекта');
	}



	/** Контроль первого элемента */
	public function test_first_null() {
		$this->_test_object = $this->newList(0);
		$result = $this->_test_object->first();
		$this->assertNull($result, 'Проверка на NULL');
	}



	/** Контроль последнего элемента */
	public function test_last() {
		$result = $this->_test_object->last();
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->getKey(), 10, 'Неверный ключ объекта');
	}



	/** Контроль первого элемента */
	public function test_last_null() {
		$this->_test_object = $this->newList(0);
		$result = $this->_test_object->last();
		$this->assertNull($result, 'Проверка на NULL');
	}



	/** Контроль итератора */
	public function test_iterator() {
		$i = 0;
		foreach($this->_test_object->iterator() as $k => $v) {
			$i = $i + 1;
			$this->assertIsObject($v, 'Проверка на объект' . " - Итерация № {$i}");
			$this->assertTrue(\is_a($v, $this->class_name_item_control), 'Класс элемента не найден' . " - Итерация № {$i}");
			$this->assertEquals($v->getKey(), $i, 'Неверный ключ объекта' . " - Итерация № {$i}");
		}
	}



	/** Контроль получения элемента */
	public function test_item() {
		$result = $this->_test_object->item(0);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->getKey(), 1, 'Неверный ключ объекта');
		$result = $this->_test_object->item(4);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->getKey(), 5, 'Неверный ключ объекта');
		$result = $this->_test_object->item(9);
		$this->assertIsObject($result, 'Проверка на объект');
		$this->assertTrue(\is_a($result, $this->class_name_item_control), 'Класс элемента не найден');
		$this->assertEquals($result->getKey(), 10, 'Неверный ключ объекта');
		$result = $this->_test_object->item(10);
		$this->assertNull($result, 'Проверка на NULL');
	}



	/** */
	public function test_get_array() {
		$result = $this->_test_object->get_array();
		$this->assertEquals(count($result), $this->_test_object->count(), 'Несовпадение количества элементов');
		$this->assertEquals($result[0], $this->_test_object->first(), 'Несовпадение объектов: первый');
		$this->assertEquals($result[count($result)-1], $this->_test_object->last(), 'Несовпадение объектов: последний');
		$i = 0;
		foreach($result as $k => $v) {
			$i = $i + 1;
			$this->assertIsObject($v, 'Проверка на объект' . " - Итерация № {$i}");
			$this->assertTrue(\is_a($v, $this->class_name_item_control), 'Класс элемента не найден' . " - Итерация № {$i}");
			$this->assertEquals($v->getKey(), $i, 'Неверный ключ объекта' . " - Итерация № {$i}");
		}

	}



/**/
}
