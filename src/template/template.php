<?php

namespace RusaDrako\model_obj\template;

require_once('data.php');



class template {


	private $_obj_data = null;
	private $_template = [
		'native_tmp_obj_data'   => 'Шаблон DATA-объекта',
		'native_tmp_obj_item'   => 'Шаблон ITEM-объекта',
//		'native_tmp_obj_list'   => 'Шаблон LIST-объекта',
	];


	/** */
 	public function __construct($db) {
		$this->_obj_data = new data($db);
 	}



	/** */
	public function getTemplapeArray() {
		return $this->_template;
	}



	/** */
	public function getDbArray() {
		return $this->_obj_data->getDbArray();
	}



	/** */
	public function getTableArray() {
		return $this->_obj_data->getTableArray();
	}



	/** */
	public function createTemplateObj($template, $db, $table) {
		$list_column = $this->_obj_data->getColumnArrayFull($db, $table);

		$table_control = "{$table}_";
		$str_count = strlen($table_control);

		$column_arr = [];
		foreach ($list_column as $v) {
			$key = ($v['COLUMN_KEY'] == 'PRI')
					? 1
					: 0;
			$alias = (substr($v['COLUMN_NAME'], 0, $str_count) == $table_control)
					? substr($v['COLUMN_NAME'], $str_count)
					: $v['COLUMN_NAME'];
			$alias = ($v['COLUMN_KEY'] == 'PRI')
					? 'ID'
					: $alias;
			$column_arr[] = [
				'key'       => $key,
				'name'      => $v['COLUMN_NAME'],
				'alias'     => mb_strtoupper($alias),
				'comment'   => $v['COLUMN_COMMENT'],
			];
		}

		require_once(__DIR__ . "/{$template}.php");
		return $text;
	}



/**/
}
