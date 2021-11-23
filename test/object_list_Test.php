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
		for ($i = 0; $i < $count; $i++) {
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
		for ($i = 10; $i < 20; $i++) {
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



	/** Тестирует метод возврата массива объектов */
	public function test_get_array() {
		$result = $this->_test_object->get_array();
		$this->assertEquals(count($result), $this->_test_object->count(), 'Несовпадение количества элементов');
		$this->assertTrue($result[0] === $this->_test_object->first(), 'Несовпадение объектов: первый');
		$this->assertTrue($result[count($result)-1] === $this->_test_object->last(), 'Несовпадение объектов: последний');
		$i = 0;
		foreach($result as $k => $v) {
			$i = $i + 1;
			$this->assertIsObject($v, 'Проверка на объект' . " - Итерация № {$i}");
			$this->assertTrue(\is_a($v, $this->class_name_item_control), 'Класс элемента не найден' . " - Итерация № {$i}");
			$this->assertEquals($v->getKey(), $i, 'Неверный ключ объекта' . " - Итерация № {$i}");
		}
	}



	/** Тестирует метод объединения списков */
	public function test_addList() {
		$this->_test_object = $this->newList(5);
		$this->assertEquals($this->_test_object->count(), 5, 'Несовпадение количества элементов');
		$result = $this->_test_object->item(5);
		$this->assertNull($result, 'Проверка на NULL');

		# Создаём и добавляем второй массив
		$add_list = $this->newList(5);
		$this->_test_object->addList($add_list);
		$this->assertEquals($this->_test_object->count(), 10, 'Несовпадение количества элементов');

		# Проверяем совпадения массивов
		$this->assertFalse($this->_test_object->item(0) === $add_list->item(4), 'Совпадение объектов');
		# Проверка совпадения объектов из объединённых списков
		$this->assertNotNull($this->_test_object->item(5), 'Несовпадение объектов');
		$this->assertNotNull($add_list->item(0), 'Несовпадение объектов');
		$this->assertTrue($this->_test_object->item(5) === $add_list->item(0), 'Несовпадение объектов');
		# Проверка совпадения объектов из объединённых списков
		$this->assertNotNull($this->_test_object->item(9), 'Несовпадение объектов');
		$this->assertNotNull($add_list->item(4), 'Несовпадение объектов');
		$this->assertTrue($this->_test_object->item(9) === $add_list->item(4), 'Несовпадение объектов');

		# Объединяем список сам с собой
		$this->_test_object->addList($this->_test_object);
		# Объекты 0 и 10 - совпадают
		$this->assertNotNull($this->_test_object->item(0), 'Несовпадение объектов');
		$this->assertNotNull($this->_test_object->item(10), 'Несовпадение объектов');
		$this->assertTrue($this->_test_object->item(0) === $this->_test_object->item(10), 'Несовпадение объектов');
		# Объекты 9 и 19 - совпадают
		$this->assertNotNull($this->_test_object->item(9), 'Несовпадение объектов');
		$this->assertNotNull($this->_test_object->item(19), 'Несовпадение объектов');
		$this->assertTrue($this->_test_object->item(9) === $this->_test_object->item(19), 'Несовпадение объектов');
		# 20 элемент - null
		$this->assertNull($this->_test_object->item(20), 'Несовпадение объектов');
	}



	/** Контроль сохранения элементов */
	public function test_saveAll() {
		// Создать подставной объект для test_item,
		// имитируя только метод save().
		$mock_item = $this->getMockBuilder(test\test_item::class)
				->setConstructorArgs([$this->createMock(RD_Obj_Data::class)])
				->setMethods(['save'])
				->getMock();

		// Настроить ожидание для метода save(),
		// который должен вызваться 2 раза
		$mock_item->expects($this->exactly(2))
				->method('save');

		# Добавляем две тестовые заглушки в список
		$this->_test_object->add($mock_item);
		$this->_test_object->add($mock_item);

		# Выполняем проверку
		$result = $this->_test_object->saveAll();
	}



/**/
}
