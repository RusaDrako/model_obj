<?php
namespace RusaDrako\model_obj;

/**
 *
 */
class data_query {

	/** Объект подключения к БД */
	protected $obj_db                = null;





	/** */
	public function __construct($db) {
		$this->obj_db = $db;
	}



	/** */
	public function __debugInfo() {return [get_called_class()];}



/**/
}
