<?php
$text = "&lt;?php
namespace app\model\\{$db}\\{$table};



/** */
class data extends \RD_Obj_Data {



	/** */
	protected function setting() {
		\$this->table_name   = '{$table}';
	}



	/* * Настройки для ... * /
	private \$_arr_setting_name = [
		1 => ['title' => '...'],
		2 => ['title' => '...'],
	];

	/** Возвращает массив настроек для ... * /
	public function settingsName() {
		return \$this->_arr_setting_name;
	}



	/* * Возвращает список по ... * /
	public function getList(\$where) {
		# Если условий нет
		if (!\$where) { return \$this->newList(); }

		\$sql = \"SELECT :col: FROM :tab: WHERE {\$where}\";
		\$data = \$this->select(\$sql);
		return \$data;
	}



	/* * Возвращает элемент по ... * /
	public function getItem(\$where) {
		# Если условий нет
		if (!\$where) { return NULL; }

		\$sql = \"SELECT :col: FROM :tab: WHERE {\$where}\";
		\$data = \$this->select(\$sql);
		\$data = \$data->first();
		return \$data;
	}



	/* * Возвращает элемент по ... или новый * /
	public function getItem(\$where) {
		\$sql = \"SELECT :col: FROM :tab: WHERE {\$where}\";
		\$data = \$this->select(\$sql);
		\$data = \$data->first();
		if (!\$data) {
			\$data = \$data->newItem();
		}
		return \$data;
	}



/**/
}
";
