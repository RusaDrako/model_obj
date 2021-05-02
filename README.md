# RusaDrako\\model_obj
Модели объектов

## Подключение

Для подключения библиотеки к проекту подключите файл `src/autoload.php`

## Доступные классы

| Псевдоним | Полное имя класса |
| :---: | :--- |
| RD_Obj_Factory | RusaDrako\\model_obj\\factory |
| RD_Obj_Data | RusaDrako\\model_obj\\data |
| RD_Obj_List | RusaDrako\\model_obj\\object_list |
| RD_Obj_Item | RusaDrako\\model_obj\\object_item |

## Начало работы

```php
	$data = new $class($obj_db, $class_obj_name, $class_obj_list_name);
```

- **$class** - Имя класса, наследующего класс `RD_Obj_Data`
- **$obj_db** - Объект подключения к БД, наследующий класс `\RD_DB` (проект `rusadrako\driver_db`)
- **$class_obj_name** - Имя класса, наследующего класс `RD_Obj_Item`
- **$class_obj_list_name** - Имя класса, наследующего класс `RD_Obj_List`


## Настройка объекта RD_Obj_Data


```php
namespace \test;

/** Класс data */
class data extends \RD_Obj_Data {

	/** Настройки объекта */
	protected function setting() {
		$this->table_name   = 'table_test';   # Имя таблицы в БД
	}

	/** Пример получения объекта со списком записей */
	public function getList(...$args) {
		# ... Дополнительные настройки
		$sql = "SELECT :col: FROM :tab: WHERE {$where}";
		$data = $this->select($sql);
		return $data;
	}

	/** Пример получения объекта записи */
	public function getItem(...$args) {
		# ... Дополнительные настройки
		$sql = "SELECT :col: FROM :tab: WHERE id = {$where}";
		$data = $this->select($sql);
		$data = $data->first();
		return $data;
	}

	# ... Методы расширения класса

}

```

### Методы объекта RD_Obj_Data

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| select(*string* $sql) | public | Возвращает объект со списком объектов записей из запроса |
| insert($arr_data) | public | Добавляет запись |
| update($arr_data, $id) | public | Обновляет запись |
| replace_column($sql) | protected | Обновляет запроса - замена маркеров |
| newItem() | public | Создаёт новый объект |
| getByKey(int $id) | public | Возвращает запись по id |
| getAll() | public | Возвращает все записи |

## Настройка объекта RD_Obj_Item

```php
namespace \test;

/** Класс item */
class item extends \RD_Obj_Item {

	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) * /
	protected function __preparationData($arr) {
		$arr = parent::__preparationData($arr);   # Получение массива для вывода
		# ... Дополнительные настройки
		return $arr;
	}/**/

	/** Настройки объекта */
	protected function setting() {

		# Ключевое поле объекта
		$this->set_column_id('id');        # ID записи

		# Столбцы таблицы => gctdljybv
		$column = [
			'id'        => 'ID',        # ID записи
			'title'     => 'TITLE',     # Заголовок
			'updated'   => 'UPDATED',   # Дата обновления
			'created'   => 'CREATED',   # Дата создания
		];
		foreach ($column as $k => $v) {
			$this->set_column_name($k, $v);
		}

		# Дополнительные свойства объекта (изменяются в процессе работы)
		$function = [
			'ADD_NAME'   => null,
		];
		foreach ($function as $k => $v) {
			$this->set_add_data($k, $v);
		}

		# Генерируемые свойства объекта (в процессе работы не могут быть изменены)
		$function = [
			'NAME'   => function() {return $this->TITLE . $this->ID;},
		];
		foreach ($function as $k => $v) {
			$this->set_gen_data($k, $v);
		}

		# Свойства-объекты (в процессе работы не могут быть изменены)
		$object = [
			'OBJ_ADDRESS'        => new \test\new_class(),
		];
		foreach ($object as $k => $v) {
			$this->set_sub_obj($k, $v);
		}
	}

	/** Фильтры при заполнении свойств объекта */
	protected function filter($name, $value) {
		switch ($name) {
			case 'ID':
				$value = (int) $value;
				break;
		}
		return $value;
	}

	/** Сохранение записи */
	public function save() {
		# ... Дополнительные настройки
		parent::save();   # Сохранения записи
	}

	# ... Методы расширения класса

}

```

### Методы объекта RD_Obj_Data

#### trait__data__set

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| set_column_id($name) | protected | Задаёт имя ключевого поля |
| set_column_name($name, $alias = null) | protected | Задаёт имя и псевдоним поля |
| set_gen_data($name, $func) | protected | Задаёт связанную со свойством функцию |
| set_sub_obj($name, $obj) | protected | Задаёт связанный со свойством объект |


#### trait__data_preparation

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| __preparationData($arr) | protected | Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) |


#### trait__data

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| getKey() | public | Возвращает ключ элемента |
| getKeyName() | public | Возвращает имя ключевого поля |
| getProp(*string* $name) | public | Возвращает значение свойства |
| setProp(*string* $name, $value) | public | Задаёт значение свойства |
| filter($name, $value) | protected | Фильтр обновления данных |


#### trait__link_obj

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| cleanLinkObj($name) | public |Очищает присоединённый объект |
| getLinkObj($name) | public | Возвращает присоединённый объект |
| setLinkObj($name, $value) | public | Добавляет объект как элемент |
| setLinkObjArr($name, $value) | public | Добавляет объект как элемент массива |


#### trait__data__db

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
|  setDataArrDB(*array* $arr_data) | public | Присваевает свойства из массива (Данные из БД) |
| getDBColumnList(*int* $id) | public | Возвращает список столбцов |
| save() | public | Сохраняет элемент |


## Настройка объекта RD_Obj_List

```php
namespace \test;

/** Класс list_t */
class list_t extends \RD_Obj_List {

	/** Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) * /
	protected function __preparationData($arr) {
		$arr = parent::__preparationData($arr);   # Получение массива для вывода
		# ... Дополнительные настройки
		return $arr;
	}/**/

	# ... Методы расширения класса

}

```

### Методы объекта RD_Obj_List

| Метод | Доступ | Описание |
| ---: | :---: | :--- |
| add(*\RusaDrako\model_obj\object_item* $item) | public | Добавляет элемент в список |
| item(*int* $num) | public | Возвращает указанный элемент |
| first() | public | Возвращает первый элемент |
| last() | public | Возвращает последний элемент |
| iterator() | public | Осуществляет перебор элементов |
| next() | public | Возвращает следующий элемент |
| back() | public | Возвращает предыдущий элемент |
| count() | public | Возвращает число элементов |
| step() | public | Возвращает номер шага |
| step_first() | public | Устанавливает номер шага на первый элемент |
| step_last() | public | Устанавливает номер шага на последний элемент |
