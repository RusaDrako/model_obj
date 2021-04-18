<?php

namespace RusaDrako\model_obj;

$arr_load = [
	'/object/trait__data__set.php',
	'/object/trait__data__db.php',
	'/object/trait__data.php',
	'/object/trait__data_preparation.php',
	'/object/trait__link_obj.php',
	'/factory.php',
	'/data.php',
	'/data_query.php',
	'/object_list.php',
	'/object_item.php',
];

foreach($arr_load as $k => $v) {
	require_once(__DIR__ . '/' . $v);
}



require_once('aliases.php');
