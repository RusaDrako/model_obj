<?php

if (class_exists('RD_Obj_Object', false)) {
    return;
}

$classMap = [
	'RusaDrako\\model_obj\\factory'       => 'RD_Obj_Factory',
	'RusaDrako\\model_obj\\data'          => 'RD_Obj_Data',
	'RusaDrako\\model_obj\\data_query'    => 'RD_Obj_Data_Query',
	'RusaDrako\\model_obj\\object_list'   => 'RD_Obj_List',
	'RusaDrako\\model_obj\\object_item'   => 'RD_Obj_Item',
];

foreach ($classMap as $class => $alias) {
    class_alias($class, $alias);
}

/*interface RD_Obj_Intf_BD implements RusaDrako\\model_obj\\intf_data {
}/**/
