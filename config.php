<?php
date_default_timezone_set('PRC');//设置时区

//TOKEN
define('BOT_TOKEN', 'TOKEN');


$bot_id="@fanxiaoyibot";//机器人ID

//读取传入信息
$update = json_decode(file_get_contents('php://input') ,true);

include ROOT_PATH.'/inc/function.php';



//语言
$language=[
	'中文'=>'zh-CN',
	'chinese'=>'zh-CN',
	'汉语'=>'zh-CN',

	'英语'=>'en',
	'英文'=>'en',
	'english'=>'en',

	'韩语'=>'ko',
	'korean'=>'ko',
	'한국어'=>'ko',

	'日语'=>'ja',
	'japanese'=>'ja',
	'日本語'=>'ja',

	'德语'=>'de',
	'德文'=>'de',
	'german'=>'de',
	'deutsch'=>'de',

	'俄语'=>'ru',
	'русский'=>'ru',
	'俄文'=>'ru',
	'russian'=>'ru',

	'法语'=>'fr',
	'lefrançais'=>'fr',
	'french'=>'fr',

	'菲律宾语'=>'tl',
	'pilipino'=>'tl',
	'filipino'=>'tl',
];	