<?php
$max_name_len = 0;
$max_alias_len = 0;

foreach ($column_arr as $k => $v) {
	$name = "'{$v['name']}'";
	if (strlen($name) > $max_name_len) {
		$max_name_len = strlen($name);
	}
	$alias = "'{$v['alias']}'";
	if (strlen($alias) > $max_alias_len) {
		$max_alias_len = strlen($alias);
	}
}



$max_name_len    += 3;
$max_alias_len   += 3;



$str_column_key = '';
$_arr_col = [];
foreach ($column_arr as $k => $v) {
	$name      = str_pad("'{$v['name']}'",     $max_name_len, ' ');
	$alias     = str_pad("'{$v['alias']}',",   $max_alias_len, ' ');
	$comment   = $v['comment'];

	if ($v['key']) {
		$str_column_key = "# Ключевое поле объекта\r\n\t\t\$this->set_column_id('{$v['name']}');        # {$comment}\r\n";
	}

	$_arr_col[] = "{$name} => {$alias} # {$comment}";
}

$str_column_set = implode("\r\n\t\t\t", $_arr_col);



$text = "&lt;?php
namespace app\model\\{$db}\\{$table};



/** */
class item extends \RD_Obj_Item {



	/* * Подготовка данных к var_dump() и серилизации JSON (JsonSerializable) * /
	protected function __preparationData(array \$arr) {
		\$arr = parent::__preparationData(\$arr);
		return \$arr;
	}



	/** Настройки объекта */
	protected function setting() {
		{$str_column_key}

		# Основные свойства объекта (соответствуют столбцам таблицы)
		\$column = [
			{$str_column_set}
		];

		foreach (\$column as \$k => \$v) {
			\$this->set_column_name(\$k, \$v);
		}

		# Дополнительные свойства объекта (не соответствуют столбцам таблицы)
/*		\$column = [
			'ADD_NAME',
		];
		foreach (\$column as \$k => \$v) {
			\$this->set_add_data(\$v, NULL);
		}/**/

		# Функциональные свойства объекта (не изменяемые)
/*		\$function = [
			'FUNCTIOB_NAME'     => function() {return null;},
		];
		foreach (\$function as \$k => \$v) {
			\$this->set_gen_data(\$k, \$v);
		}/**/

		# Объектные свойства объекта (не изменяемые)
/*		\$object = [
			'OBJECT_NAME'     => new \object\_common\contact\phone(),
		];
		foreach (\$object as \$k => \$v) {
			\$this->set_sub_obj(\$k, \$v);
		}/**/
	}





	/* * Заполнение свойств объекта * /
	protected function filter(\$name, \$value) {
		switch (\$name) {
			case 'ID':
				\$value = (int) \$value;
				break;
			case 'TITLE':
				\$value = trim(\$value);
				break;
		}
		return \$value;
	}





	/* * Сохранение записи * /
	public function save() {
		# Если первое сохранение и ключа ещё нет
		if (!\$this->getKey()) {
			\$this->setProp('CREATED',   date('Y-m-d H:i:s'));
		}
		return parent::save();
	}





	/* * * /
	public function getAssocietedItem() {
		\$item = \factory::call()->getObj('object')->getByKey(\$this->OBJECT_ID);
		return \$item;
	}



/**/
}
";
