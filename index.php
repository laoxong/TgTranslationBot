<?php
define('ROOT_PATH',dirname(__FILE__));

include ROOT_PATH.'/config.php';

if (isset($_GET['token'])) {

//如果需要设置回调
//第一次请访问:https://你的域名/目录/?token=输入你的token

    if (isset($_GET['setWebhook'])) {
        $res =array('url' => "https://{$_SERVER['SERVER_NAME']}/?token={$_GET['token']}");
		$res =curl('setWebhook',$res);
        if ($res) {
            echo 'Tg setWebhook设置成功!';
        } else {
            echo 'Tg setWebhook设置失败!';
        }
        exit();
    }



	//判断是否存在默认语言
	if(file_exists('user/'.$user_id.'.txt')){
		$lang_user_name=file_get_contents('user/'.$user_id.'.txt');//读取用户设置
		$lang_user_name=strtolower(trim($lang_user_name,'\0\t\x0B '));//小写,去除前后特殊符号
		$to=$language[$lang_user_name];	//用户设置语言
	}else{
		$lang_user_name='中文';//系统默认
		$to=$language[$lang_user_name];//系统默认翻译
	}



	if($type=='supergroup' AND !$tgbot){
		//tg群组
		
		if(!is_null($reply_to_message)){
			
			//回复模式
			
			$fy=mb_substr($text, 0, 2, 'utf-8');
			
			
			if($fy==='翻译' or $language[$fy]){
				//匹配群聊前两字符为翻译
				if(!$language[$fy]){
					//preg_match("/翻译(.*?)翻译/is", $text.'翻译',$lang_cmd);
					$lang_cmd=str_replace('翻译',"",$text);
					$lang_cmd=strtolower(trim($lang_cmd['1'],'\0\t\x0B '));//转小写，去除前后特殊符号
					if($language[$lang_cmd]){
						//命令模式下
						$to=$language[$lang_cmd];
					}
				}else{
					//回复翻译语种
					$to=$language[$fy];
				}
					
				//去除已经翻译后At的人	
				$reply_text=explode("\n @", $reply_text);
				
				//翻译结果
				$fanyi=fanyi($reply_text['0'],'',$to);
				
				//组成信息
				$to_chat=array(
					'chat_id' => $chat_id,
					"text" => $fanyi."\n @".$username,
					//"reply_to_message_id" => $message_id,
				);
				
				//发送信息
				$sendmessage=curl('sendmessage',$to_chat);
			}
			
		}

	}elseif($type=='private'){
		//私聊
		
		if($text[0]==="/"){
			//命令模式
			//$ml=explode('/', $text);//截取/号后面的字符串
			$ml=str_replace('/',"",$text);
			$ml=strtolower(trim($ml));//全部小写，并且去除空格以及特殊符号
			
			include ROOT_PATH.'/inc/mingling.php';
			
		}else{
			//非命令回复
			
			if($reply_text){
				//回复模式

				if($language[$text]){
					//如果包含翻译指令
					$to=$language[$text];
					$text=$reply_text;
					$text=fanyi($text,'',$to);//翻译
				}else{
					$text='您需要翻译的语言暂时不支持！请查看支持的语言(/default)';
				}

			}
		}
		
		//组成信息
		$to_chat=array(
			'chat_id' => $chat_id,
			"text" => $text,
			);
			
		//发送信息
		$sendmessage=curl('sendmessage',$to_chat);
		
	}
	
}
