<?php
namespace RusaDrako\model_obj\object;

/**
 * Работа с дополнительными внешними объектами (не заданными изначально)
 */
trait trait__link_obj {

	protected $arr_link_obj   = [];



	/** Очищает присоединённый объект */
	final public function cleanLinkObj($name) {
		return $this->clean_link_obj($name);
	}



	/** Очищает присоединённый объект
	 * @param string $name Имя объекта
	 */
	final public function clean_link_obj($name) {
		unset($this->arr_link_obj[$name]);
	}



	/** Возвращает присоединённый объект */
	final public function getLinkObj($name) {
		return $this->get_link_obj($name);
	}



	/** Возвращает присоединённый объект
	 * @param string $name Имя объекта
	 */
	final public function get_link_obj($name) {
		if (\array_key_exists($name, $this->arr_link_obj)) {
			return $this->arr_link_obj[$name];
		}
		return null;
	}



	final public function setLinkObj($name, $value) {
		return $this->set_link_obj($name, $value);
	}



	/** Добавляет объект как отдельный элемент
	 * @param string $name Имя объекта
	 * @param object $value Объект
	 */
	final public function set_link_obj($name, $value) {
		$this->arr_link_obj[$name] = $value;
		return $this->arr_link_obj[$name];
	}



	final public function setLinkObjArr($name, $value) {
		return $this->set_link_obj_arr($name, $value);
	}



	/** Добавляет объект как элемент массива
	 * @param string $name Имя объекта
	 * @param object $value Объект
	 */
	final public function set_link_obj_arr($name, $value) {
		$this->arr_link_obj[$name][] = $value;
		return $this->arr_link_obj[$name];
	}



/**/
}
