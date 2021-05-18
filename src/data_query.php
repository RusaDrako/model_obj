<?php
namespace RusaDrako\model_obj;



/**
 *
 */
class data_query extends data {

	/** Возвращает запись по id */
	public function getByKey(int $id) {
		if (!$id) { return null;}
		$sql = "SELECT :col: FROM :tab: WHERE :key: = {$id}";
		$data = $this->select($sql);
		$data = $data->first();
		return $data;
	}



	/** Возвращает все записи */
	public function getAll() {
		$sql = "SELECT :col: FROM :tab:";
		$data = $this->select($sql);
		return $data;
	}



	/** Возвращает записи по массиву id */
	public function getByKeyArray(array $arr_id) {
		if (!$arr_id) { return $this->newList(); }
		$str_id = \implode(', ', $arr_id);
		$sql = "SELECT :col: FROM :tab: WHERE :key: IN ({$str_id})";
		$data = $this->select($sql);
		return $data;
	}



/**/
}
