<?php
namespace RusaDrako\model_obj\object;

/**
 * Работа с дополнительными внешними объектами
 */
trait trait__link_obj {

	protected $arr_link_obj   = [];





	/** Очищает присоединённый объект */
	final function cleanLinkObj($name) {
		unset($this->arr_link_obj[$name]);
	}





	/** дополнительные объекты */
	final public function getLinkObj($name) {
		if (\array_key_exists($name, $this->arr_link_obj)) {
			return $this->arr_link_obj[$name];
		}
		return null;
	}





	/** Добавляет объект как элемент */
	final public function setLinkObj($name, $value) {
		$this->arr_link_obj[$name] = $value;
		return $this->arr_link_obj[$name];
	}





	/** Добавляет объект как элемент массива */
	final public function setLinkObjArr($name, $value) {
		$this->arr_link_obj[$name][] = $value;
		return $this->arr_link_obj[$name];
	}





/**/
}
