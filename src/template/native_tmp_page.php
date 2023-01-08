<?php

//var_dump($_POST);
//print_info($arr_db, $db_name);
//print_info($arr_table, $table_name);
//print_info($arr_template, $template_name);

$arr_text = [];

$arr_text[] = <<<HTML
<h2>Генерация классов</h2>
HTML;

$arr_text[] = <<<HTML
<form method="post">
HTML;



$arr_text[] =  <<<HTML
<select name="db_name">
HTML;
foreach ($arr_db as $k => $v) {
	$selected = $db_name == $v['Database'] ? ' selected="selected"' : '';
	$arr_text[] = <<<HTML
<option value="{$v['Database']}"{$selected}>{$k} - {$v['Database']}</option>
HTML;
}
$arr_text[] =  <<<HTML
</select>
HTML;



$arr_text[] = <<<HTML
<select name="table_name">
HTML;
foreach ($arr_table as $k => $v) {
	$data = array_shift($v);
	$selected = $table_name == $data ? ' selected="selected"' : '';
	$arr_text[] = <<<HTML
<option value="{$data}"{$selected}>{$k} - {$data}</option>
HTML;
}
$arr_text[] =  <<<HTML
</select>
HTML;



$arr_text[] = <<<HTML
<select name="template_name">
HTML;
foreach ($arr_template as $k => $v) {
	$selected = $template_name == $k ? ' selected="selected"' : '';
	$arr_text[] = <<<HTML
<option value="{$k}"{$selected}>{$v}</option>
HTML;
}
$arr_text[] =  <<<HTML
</select>
HTML;



$arr_text[] = <<<HTML
<button type="submit" name="create">Сформировать</button>
HTML;

$arr_text[] = <<<HTML
</form>
HTML;



$str = $this->createTemplateObj($template_name, $db_name, $table_name);
$arr_text[] = <<<HTML
<textarea style="width: 100%; height: 750px;">{$str}</textarea>
HTML;



$text = implode("\r\n", $arr_text);
