<?php
namespace RusaDrako\model_obj;

/**
 *
 */
class object_item implements \JsonSerializable {

	use object\trait__data;
	use object\trait__data_preparation;
	use object\trait__link_obj;





	/** */
	public function __construct(\RusaDrako\model_obj\data $obj_data) {
		$this->obj_data = $obj_data;
		$this->setting();
	}





	/** Подготовка данных к var_dump() */
	public function __debugInfo() {
		$arr = $this->__preparationData([]);
		return $arr;
	}





	/** Подготовка данных к серилизации JSON (JsonSerializable) */
	public function jsonSerialize() {
		$arr = $this->__preparationData([]);
		return $arr;
	}




	/** Настройки класса объекта */
	protected function setting() {}



/**/
}
