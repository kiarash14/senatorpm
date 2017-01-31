<?php
/*
 __  __                 ____
|  \/  |___  __ _      |  _ \ ___  ___  __ _ _ __
| |\/| / __|/ _` |_____| |_) / _ \/ __|/ _` | '_ \
| |  | \__ \ (_| |_____|  _ <  __/\__ \ (_| | | | |
|_|  |_|___/\__, |     |_| \_\___||___/\__,_|_| |_|
            |___/
*/
define('API_KEY',291779361:AAFZE5_LwRX4RQRq8I_yvouUEYdlCzK3cGw');
//----######------
function makereq($method,$datas=[]){
    $url = "https://api.telegram.org/bot".API_KEY."/".$method;
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch,CURLOPT_POSTFIELDS,http_build_query($datas));
    $res = curl_exec($ch);
    if(curl_error($ch)){
        var_dump(curl_error($ch));
    }else{
        return json_decode($res);
    }
}
//##############=--API_REQ
function apiRequest($method, $parameters) {
  if (!is_string($method)) {
    error_log("Method name must be a string\n");
    return false;
  }
  if (!$parameters) {
    $parameters = array();
  } else if (!is_array($parameters)) {
    error_log("Parameters must be an array\n");
    return false;
  }
  foreach ($parameters as $key => &$val) {
    // encoding to JSON array parameters, for example reply_markup
    if (!is_numeric($val) && !is_string($val)) {
      $val = json_encode($val);
    }
  }
  $url = "https://api.telegram.org/bot".API_KEY."/".$method.'?'.http_build_query($parameters);
  $handle = curl_init($url);
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
  curl_setopt($handle, CURLOPT_TIMEOUT, 60);
  return exec_curl_request($handle);
}
//----######------
//---------
$update = json_decode(file_get_contents('php://input'));
var_dump($update);
//=========
$chat_id = $update->message->chat->id;
$message_id = $update->message->message_id;
$from_id = $update->message->from->id;
$name = $update->message->from->first_name;
$fname = $update->message->from->last_name;
$username = $update->message->from->username;
$textmessage = isset($update->message->text)?$update->message->text:'';
$txtmsg = $update->message->text;
$reply = $update->message->reply_to_message->forward_from->id;
$stickerid = $update->message->reply_to_message->sticker->file_id;
$type = file_get_contents('type.txt');
$txtt = file_get_contents('banlist.txt');
$boolean = file_get_contents('booleans.txt');
$booleans= explode("\n",$boolean);
$step = file_get_contents("data/".$from_id."/step.txt");
$admin = 275387751;

//-------
function SendMessage($ChatId, $TextMsg)
{
 makereq('sendMessage',[
'chat_id'=>$ChatId,
'text'=>$TextMsg,
'parse_mode'=>"MarkDown"
]);
}
function SendSticker($ChatId, $sticker_ID)
{
 makereq('sendSticker',[
'chat_id'=>$ChatId,
'sticker'=>$sticker_ID
]);
}
function Forward($KojaShe,$AzKoja,$KodomMSG)
{
makereq('ForwardMessage',[
'chat_id'=>$KojaShe,
'from_chat_id'=>$AzKoja,
'message_id'=>$KodomMSG
]);
}
function save($filename,$TXTdata)
	{
	$myfile = fopen($filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
//===========
$inch = file_get_contents("https://api.telegram.org/bot".API_KEY."/getChatMember?chat_id=@msgresan&user_id=".$from_id);
	
	if (strpos($inch , '"status":"left"') !== false ) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"با سلام😊👋

💠برای استفاده از  ربات باید در کانال ما عضو شوید تا از اخبار ها مطلع شوید.

💠پس از عضو شدن دوباره به ربات مراجعه و دستور زیر را ارسال کنید.

🎗 /start 🎗",
	'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"ورود به کانال",'url'=>"https://telegram.me/Senator_tea"]
                ]
            ]
        ])
    ]));
}
elseif(isset($update->callback_query)){
    $callbackMessage = '';
    var_dump(makereq('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    if (strpos($data, "del") !== false ) {
    $botun = str_replace("del ","",$data);
    unlink("bots/".$botun."/index.php");
    save("data/$chat_id/bots.txt","");
    save("data/$chat_id/tedad.txt","0");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"✅ ربات شما با موفقیت حذف شد!",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💠 عضویت در کانال ما!",'url'=>"https://telegram.me/Senator_tea"]
                    ]
                ]
            ])
        ])
    );
 }

 else {
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"خطا",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    [
                        ['text'=>"💠 عضویت در کانال ما!",'url'=>"https://telegram.me/Senator_tea"]
                    ]
                ]
            ])
        ])
    );
 }
}

elseif ($textmessage == '🔙 برگشت') {
save("data/$from_id/step.txt","none");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"سلام  😊👋

📩 به سیستم مسیج رسان خوش آمدید.

💠 این سرویس این قابلیت را دارد که به افراد ریپورت که دارای محدود ارسال پیام هستند این امکان را میدهد که با یکدیگر ارتباط برقرار کنند.

💠 برای ساخت ربات از دکمه ی 🔄 ساخت ربات استفاده نمایید.

💠 اگر با ساخت روبات آشنایی ندارید با دکمه ⚠️ راهنما میتوانید آموزش ساخت روبات را دریافت کنید.
@Senator_tea",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔄 ساخت ربات"]
                ],
                 [
                   ['text'=>"🚀 ربات های من"],['text'=>"☢ حذف ربات"]
                ],
                [
                   ['text'=>"⚠️ راهنما"],['text'=>"💠 کانال ما"],['text'=>"🔰 قوانین"]
                ]
                
            	],
            	'resize_keyboard'=>false
       		])
    		]));
}
elseif ($step == 'delete') {
$botun = $txtmsg ;
if (file_exists("bots/".$botun."/index.php")) {

$src = file_get_contents("bots/".$botun."/index.php");

if (strpos($src , $from_id) !== false ) {
save("data/$from_id/step.txt","none");
unlink("bots/".$botun."/index.php");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ ربات شما با موفقیت حذف شده است!
⚠️ یک ربات جدید بسازید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔄 ساخت ربات"],['text'=>"🔙 برگشت"]
                ]
                
            	],
                'resize_keyboard'=>false
       		])
    		]));
}
else {
SendMessage($chat_id,"⛔️ خطا!
⚠️ شما نمیتوانید این ربات را پاک کنید.");
}
}
else {
SendMessage($chat_id,"⛔️ یافت نشد!");
}
}
elseif ($step == 'create bot') {
$token = $textmessage ;

			$userbot = json_decode(file_get_contents('https://api.telegram.org/bot'.$token .'/getme'));
			//==================
			function objectToArrays( $object ) {
				if( !is_object( $object ) && !is_array( $object ) )
				{
				return $object;
				}
				if( is_object( $object ) )
				{
				$object = get_object_vars( $object );
				}
			return array_map( "objectToArrays", $object );
			}

	$resultb = objectToArrays($userbot);
	$un = $resultb["result"]["username"];
	$ok = $resultb["ok"];
		if($ok != 1) {
			//Token Not True
			SendMessage($chat_id,"⛔️ توکن نامعتبر!");
		}
		else
		{
		SendMessage($chat_id,"♻️ در حال ساخت ربات شما ...");
		if (file_exists("bots/$un/index.php")) {
		$source = file_get_contents("bot/index.php");
		$source = str_replace("[*BOTTOKEN*]",$token,$source);
		$source = str_replace("275387751",$from_id,$source);
		save("bots/$un/index.php",$source);	
		file_get_contents("https://api.telegram.org/bot".$token."/setwebhook?url=https://climaxit.net/sample/bots/$un/index.php");

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"  ✅ ربات شما با موفقیت آپدیت شد.

[👆 کلیک برای ورود به ربات.](https://telegram.me/$un)",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                 ['text'=>"🔙 برگشت"]
                ]
                
            	],
                'resize_keyboard'=>false
       		])
    		]));
		}
		else {
		save("data/$from_id/tedad.txt","1");
		save("data/$from_id/step.txt","none");
		save("data/$from_id/bots.txt","$un");
		
		mkdir("bots/$un");
		mkdir("bots/$un/data");
		mkdir("bots/$un/data/btn");
		mkdir("bots/$un/data/words");
		mkdir("bots/$un/data/profile");
		mkdir("bots/$un/data/setting");
		
		save("bots/$un/data/blocklist.txt","");
		save("bots/$un/data/last_word.txt","");
		save("bots/$un/data/pmsend_txt.txt","Message Sent!");
		save("bots/$un/data/start_txt.txt","Hello World!");
		save("bots/$un/data/forward_id.txt","");
		save("bots/$un/data/users.txt","$from_id\n");
		mkdir("bots/$un/data/$from_id");
		save("bots/$un/data/$from_id/type.txt","admin");
		save("bots/$un/data/$from_id/step.txt","none");
		
		save("bots/$un/data/btn/btn1_name","");
		save("bots/$un/data/btn/btn2_name","");
		save("bots/$un/data/btn/btn3_name","");
		save("bots/$un/data/btn/btn4_name","");
		
		save("bots/$un/data/btn/btn1_post","");
		save("bots/$un/data/btn/btn2_post","");
		save("bots/$un/data/btn/btn3_post","");
		save("bots/$un/data/btn/btn4_post","");
	
		save("bots/$un/data/setting/sticker.txt","✅");
		save("bots/$un/data/setting/video.txt","✅");
		save("bots/$un/data/setting/voice.txt","✅");
		save("bots/$un/data/setting/file.txt","✅");
		save("bots/$un/data/setting/photo.txt","✅");
		save("bots/$un/data/setting/music.txt","✅");
		save("bots/$un/data/setting/forward.txt","✅");
		save("bots/$un/data/setting/joingp.txt","✅");
		
		$source = file_get_contents("bot/index.php");
		$source = str_replace("[*BOTTOKEN*]",$token,$source);
		$source = str_replace("275387751",$from_id,$source);
		save("bots/$un/index.php",$source);	
		file_get_contents("https://api.telegram.org/bot".$token."/setwebhook?url=https://website.com/MsgResan/bots/$un/index.php");

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ ربات شما با موفقیت ساخته شد. 

[👆 کلیک برای ورود به ربات.](https://telegram.me/$un)",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔄 ساخت ربات"]
                ],
                 [
                   ['text'=>"🚀 ربات های من"],['text'=>"☢ حذف ربات"]
                ],
                [
                   ['text'=>"⚠️ راهنما"],['text'=>"💠 کانال ما"],['text'=>"🔰 قوانین"]
                ]
                
            	],
            	'resize_keyboard'=>false
       		])
    		]));
		}
}
}
SendMessage($chat_id,"Updated!");*/
}
elseif ($textmessage =="ارسال به همه"  && $from_id == $admin | $booleans[0]=="false") {
  {
          sendmessage($chat_id,"لطفا پیام خودرا ارسال کنید");
  }
      $boolean = file_get_contents('booleans.txt');
      $booleans= explode("\n",$boolean);
      $addd = file_get_contents('banlist.txt');
      $addd = "true";
      file_put_contents('booleans.txt',$addd);

    }
      elseif($chat_id == $admin && $booleans[0] == "true") {
    $texttoall = $textmessage;
    $ttxtt = file_get_contents('data/users.txt');
    $membersidd= explode("\n",$ttxtt);
    for($y=0;$y<count($membersidd);$y++){
      sendmessage($membersidd[$y],"$texttoall");

    }
    $memcout = count($membersidd)-1;
    {
    Sendmessage($chat_id,"پیغام شما به $memcout مخاطب ارسال شد.");
    }
         $addd = "false";
      file_put_contents('booleans.txt',$addd);
      }
elseif($textmessage == '🚀 ربات های من')
{
$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "") {
SendMessage($chat_id,"⛔️ شما هنوز ربات نساخته اید.");
return;
}
 	var_dump(makereq('sendMessage',[
	'chat_id'=>$update->message->chat->id,
	'text'=>"💠 لیست ربات های شما :",
	'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[
        ['text'=>"👉 @".$botname,'url'=>"https://telegram.me/".$botname]
	]
	]
	])
	]));
}
elseif ($textmessage == '/htcb') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 آموزش ساخت روبات :
[👆 کلیک برای دیدن آموزش.](https://telegram.me/Senator_tea/178)
",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
                'resize_keyboard'=>true
       		])
    		]));
}
	elseif ($textmessage == 'آمار کاربران' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"`👤 اعضای ربات` : `".$usercount."`");
	}

elseif ($textmessage == '🔰 قوانین') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"1⃣ اطلاعات ثبت شده در ربات های ساخته شده توسط مسیج رسان از قبیل اطلاعات پروفایل نزد مدیران مسیج رسان محفوظ است و در اختیار اشخاص حقیقی یا حقوقی قرار نخواهد گرفت.

2⃣ ربات هایی که اقدام به انشار تصاویر یا مطالب مستهجن کنند و یا به مقامات ایران ، ادیان و اقوام و نژادها توهین کنند مسدود خواهند شد.

3⃣ ایجاد ربات با عنوان های مبتذل و خارج از عرف جامعه که برای جذب آمار و فروش محصولات غیر متعارف باشند ممنوع می باشد و در صورت مشاهده ربات مورد نظر حذف و مسدود میشود.

4⃣ مسئولیت پیام های رد و بدل شده در هر ربات با مدیر آن ربات میباشد و مسیج رسان هیچ گونه مسئولیتی قبول نمیکند.

5⃣ رعایت حریم خصوصی و حقوقی افراد از جمله، عدم اهانت به شخصیت های مذهبی، سیاسی، حقیقی و حقوقی کشور و به ویژه کاربران ربات ضروری می باشد.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
                'resize_keyboard'=>true
       		])
    		]));
}
elseif($textmessage == 'آمار ربات ها')
if ($from_id == $admin) {
$number = count(scandir("bots"))-3;
SendMessage($chat_id,"🚀 `ربات های ساخته شده` : `".$number."`");
}
else {
SendMessage($chat_id,"You Are Not Admin");
}


elseif ($textmessage == '/panel' && $from_id == $admin) {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"سلام ادمین عزیز
به پنل مدیریت خوش آمدید
یکی از دکمه هارو انتخاب کن.",
	'parse_mode'=>'MarkDown',
            'reply_markup'=>json_encode([
                'keyboard'=>[
                [
                   ['text'=>"آمار کاربران"],['text'=>"آمار ربات ها"]
                ],
                [
                   ['text'=>"ارسال به همه"]
                ],
                 [
                   ['text'=>"🔙 برگشت"]
                ]
                
                ],
                'resize_keyboard'=>false
            ])
            ]));
}

elseif ($textmessage == '💠 کانال ما') {
var_dump(makereq('sendMessage',[
        'chat_id'=>$update->message->chat->id,
        'text'=>"⚠️ ورود به کانال ما جهت دریافت اخبار ربات!",
	'parse_mode'=>'MarkDown',
        'reply_markup'=>json_encode([
            'inline_keyboard'=>[
                [
                    ['text'=>"ورود",'url'=>"https://telegram.me/Senator_tea"]
                ]
            ]
        ])
    ]));
}

elseif($textmessage == '/start')
{

if (!file_exists("data/$from_id/step.txt")) {
mkdir("data/$from_id");
save("data/$from_id/step.txt","none");
save("data/$from_id/tedad.txt","0");
save("data/$from_id/bots.txt","");
$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");	
fwrite($myfile2, "$from_id\n");
fclose($myfile2);
}

var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"سلام  😊👋

📩 به سیستم مسیج رسان خوش آمدید.

💠 این سرویس این قابلیت را دارد که به افراد ریپورت که دارای محدود ارسال پیام هستند این امکان را میدهد که با یکدیگر ارتباط برقرار کنند.

💠 برای ساخت ربات از دکمه ی 🔄 ساخت ربات استفاده نمایید.

💠 اگر با ساخت روبات آشنایی ندارید با دکمه ⚠️ راهنما میتوانید آموزش ساخت روبات را دریافت کنید.
@Senator_tea",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔄 ساخت ربات"]
                ],
                 [
                   ['text'=>"🚀 ربات های من"],['text'=>"☢ حذف ربات"]
                ],
                [
                   ['text'=>"⚠️ راهنما"],['text'=>"💠 کانال ما"],['text'=>"🔰 قوانین"]
                ]
                
            	],
            	'resize_keyboard'=>false
       		])
    		]));
}
elseif ($textmessage == '⚠️ راهنما') {
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 آموزش ساخت ربات :
➖➖➖
1⃣ ابتدا وارد ربات زیر شوید
@BotFather
2⃣ دستور /newbot را ارسال کنید.
از شما نامی برای ربات میخواهد. انرا ارسال نمایید.
3⃣ حال شما باید آیدی وارد کنید.
ایدی که وارد میکنید اخر ان باید عبارت
Bot
وجود داشته باشد.
4⃣ یک توکن به شما میدهد مانند:
123456:asdjhasjkdhjaksdhjasdlasjkdh
5⃣ وارد ربات ما یعنی @senatorPmresanbot شوید و سپس دکمه 🔄 ساخت ربات را انتخاب کنید.
و توکن دریافتی را ارسال نمایید تا ربات شما نصب شود.
",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
                'resize_keyboard'=>true

       		])
    		]));
}
elseif ($textmessage == '☢ حذف ربات') {
if (file_exists("data/$from_id/step.txt")) {

}
$botname = file_get_contents("data/$from_id/bots.txt");
if ($botname == "") {
SendMessage($chat_id,"⛔️ شما هنوز هیچ رباتی نساخته اید!");

}
else {
//save("data/$from_id/step.txt","delete");


 	var_dump(makereq('sendMessage',[
	'chat_id'=>$update->message->chat->id,
	'text'=>"💠 یکی از ربات های خود را انتخاب کنید :",
	'parse_mode'=>'MarkDown',
	'reply_markup'=>json_encode([
	'inline_keyboard'=>[
	[
	['text'=>"👉 @".$botname,'callback_data'=>"del ".$botname]
	]
	]
	])
	]));

/*
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 یکی از ربات های خود را جهت پاک کردن انتخاب کنید : ",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
            	[
            	['text'=>$botname]
            	],
                [
                   ['text'=>"🔙 برگشت"]
                ]
                
            	],
                'resize_keyboard'=>false
       		])
    		])); */
}
}
elseif (strpos($textmessage , "/seta") !== false && $chat_id == $admin) {
$result = str_replace("/seta ","",$textmessage);
save("bots/adad.txt",$adad."".$result);
SendMessage($chat_id,"$result seted!");
}
elseif ($textmessage == '🔄 ساخت ربات') {

$tedad = file_get_contents("data/$from_id/tedad.txt");
if ($tedad >= 1) {
SendMessage($chat_id,"⛔️ تعداد ربات های ساخته شده شما به یک عدد رسیده است!
⚠️از آنجا که محدودیت ساخت یک عدد است اول باید یک ربات را پاک کنید!");
return;
}
save("data/$from_id/step.txt","create bot");
var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 توکن را وارد کنید.. : ",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔙 برگشت"]
                ]
                
            	],
            	'resize_keyboard'=>false
       		])
    		]));
}

else
{
SendMessage($chat_id,"⛔️` Command Not Found!`
⛔️ دستور مورد نظر یافت نشد!");
}
?>
