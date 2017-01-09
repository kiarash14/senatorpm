//------#######------- [[ترجیح میدم این فایلو ادیت ندید هیچ تبلیغی نداره :دی]]
<?php
	define('API_KEY','[*BOTTOKEN*]');
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
	//---------
	$update = json_decode(file_get_contents('php://input'));
	var_dump($update);
	//=========
	$chat_id = $update->message->chat->id;
	$message_id = $update->message->message_id;
	$from_id = $update->message->from->id;
	$name = $update->message->from->first_name;
	$contact = $update->message->contact;
	$cnumber = $update->message->contact->phone_number;
	$cname = $update->message->contact->first_name;
	
	$photo = $update->message->photo;
	$video = $update->message->video;
	$sticker = $update->message->sticker;
	$file = $update->message->document;
	$music = $update->message->audio;
	$voice = $update->message->voice;
	$forward = $update->message->forward_from;
	
	$username = $update->message->from->username;
	$textmessage = isset($update->message->text)?$update->message->text:'';
	$reply = $update->message->reply_to_message->forward_from->id;
	$stickerid = $update->message->reply_to_message->sticker->file_id;
	//------------
	$_sticker = file_get_contents("data/setting/sticker.txt");
	$_video = file_get_contents("data/setting/video.txt");
	$_voice = file_get_contents("data/setting/voice.txt");
	$_file = file_get_contents("data/setting/file.txt");
	$_photo = file_get_contents("data/setting/photo.txt");
	$_music = file_get_contents("data/setting/music.txt");
	$_forward = file_get_contents("data/setting/forward.txt");
	$_joingp = file_get_contents("data/setting/joingp.txt");
	//------------
	$admin = 275387751;
	$bottype = "gold";
       $adad = file_get_contents("https://climaxit.net/sample/bots/adad.txt");
	$step = file_get_contents("data/".$from_id."/step.txt");
	$type = file_get_contents("data/".$from_id."/type.txt");
	$list = file_get_contents("data/blocklist.txt");
	//---Buttons----
	$btn1_name = file_get_contents("data/btn/btn1_name");
	$btn2_name = file_get_contents("data/btn/btn2_name");
	$btn3_name = file_get_contents("data/btn/btn3_name");
	$btn4_name = file_get_contents("data/btn/btn4_name");
	
	$btn1_post =  file_get_contents("data/btn/btn1_post");
	$btn2_post =  file_get_contents("data/btn/btn2_post");
	$btn3_post =  file_get_contents("data/btn/btn3_post");
	$btn4_post =  file_get_contents("data/btn/btn4_post");
	
	//-----------
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
	$myfile = fopen("data/".$filename, "w") or die("Unable to open file!");
	fwrite($myfile, "$TXTdata");
	fclose($myfile);
	}
	//===========
	if (strpos($list , "$from_id") !== false  ) {
		SendMessage($chat_id,"⛔️ You Are Blocked!");
	}
	elseif(isset($update->callback_query)){
    $callbackMessage = 'آپدیت شد';
    var_dump(makereq('answerCallbackQuery',[
        'callback_query_id'=>$update->callback_query->id,
        'text'=>$callbackMessage
    ]));
    $chat_id = $update->callback_query->message->chat->id;
    $message_id = $update->callback_query->message->message_id;
    $data = $update->callback_query->data;
    //SendMessage($chat_id,"$data");
	
    if ($data == "sticker" && $_sticker == "✅") {
      save("setting/sticker.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "sticker" && $_sticker == "⛔️") {

	 save("setting/sticker.txt","✅");
	     var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
     if ($data == "video" && $_video == "✅") {
      save("setting/video.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
     if ($data == "video" && $_video == "⛔️") {
   save("setting/video.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
    if ($data == "voice" && $_voice == "✅") {
      save("setting/voice.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "voice" && $_voice == "⛔️") {

	   save("setting/voice.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "file" && $_file == "✅") {
      save("setting/file.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
    if ($data == "file" && $_file == "⛔️") {
	  save("setting/file.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
     if ($data == "photo" && $_photo == "✅") {
      save("setting/photo.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
     if ($data == "photo" && $_photo == "⛔️") {
	 save("setting/photo.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
      if ($data == "music" && $_music == "✅") {
      save("setting/music.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
      if ($data == "music" && $_music == "⛔️") {
	       save("setting/music.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
 
       if ($data == "forward" && $_forward == "✅") {
      save("setting/forward.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>"⛔️",'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
       if ($data == "forward" && $_forward == "⛔️") {

	 save("setting/forward.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
                    			
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>"✅",'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 
      if ($data == "joingp" && $_joingp == "✅") {
      save("setting/joingp.txt","⛔️");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
      if ($data == "joingp" && $_joingp == "⛔️") {
	 save("setting/joingp.txt","✅");
    var_dump(
        makereq('editMessageText',[
            'chat_id'=>$chat_id,
            'message_id'=>$message_id,
            'text'=>"به تنظیمات روبات خوش آمدید.

 ⛔️ = قفل شده.
 ✅ = آزاد",
            'reply_markup'=>json_encode([
                'inline_keyboard'=>[
					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
		
                ]
            ])
        ])
    );
 }
 //=========================
}
	
	elseif($textmessage == '')
	{
	//Check Kardan (Media)
	if ($contact  != null && $step== 'Set Contact' && $from_id == $admin) {
	save("profile/number.txt",$cnumber);
	save("profile/cname.txt",$cname);
	SendMessage($chat_id,"شماره ذخیره .
	*$cname *: `$cnumber`");
	}
	
	if ($photo != null) {
	if ($_photo == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		
		}
	}
	}
	
	if ($sticker != null ) {
		if ($_sticker == "⛔️" && $from_id != $admin) {
	SendMessage($chat_id,"Locked!");
		}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($video != null) {
		if ($from_id != $admin && $_video == "⛔️") {
	SendMessage($chat_id,"Locked!");
		}
		else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($music != null ) {
		if ($from_id != $admin && $_music == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($voice != null) {
		if ($from_id != $admin && $_voice == "⛔️") {
	SendMessage($chat_id,"Locked!");
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	
	if ($file != null ){
		if ($from_id != $admin && $_file == "⛔️") {
	SendMessage($chat_id,"Locked!");
		}
		
	}
	else {
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		Forward($reply,$chat_id,$message_id); 
		}
	}
	}
	elseif ($from_id != $chat_id) {
		
	SendMessage($chat_id,"Bye Bye");
makereq('leaveChat',[
	'chat_id'=>$chat_id
	]);
	}
        
	elseif($textmessage == '🏠 صفحه اصلی') {
	save($from_id."/step.txt","none");
	if ($type == "admin") {
	
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"🔁 به منوی `اصلی` خوش آمدید",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                  ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		else {
    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"🔁 به منوی `اصلی` خوش آمدید",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    	}
	}
	elseif ($step == 'set word') {
		save($from_id."/step.txt","set answer");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 کلمه ای که درجواب باید ارسال کنم رو بفرستید.
			مثل: 
			`سلام خوبی؟`",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
			save("words/$textmessaage.txt","Tarif Nashode !");
			save("last_word.txt",$textmessage);
	}
	elseif ($step == 'set answer') {
		save($from_id."/step.txt","none");
		
		$last = file_get_contents("data/last_word.txt");
			$myfile2 = fopen("data/wordlist.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$last\n");
			fclose($myfile2);
			save("words/$last.txt","$textmessage");
		
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ ذخیره شد.
⚠️ یک گزینه را انتخاب کنید.",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'➕ اضافه کردن کلمه'],['text'=>'➖ حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		
			
	}
	
	elseif($step == "del words") {
			unlink("data/words/$textmessage.txt");
			var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ حذف شد.
      ⚠️ یک گزینه را انتخاب کنید.",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'➕ اضافه کردن کلمه'],['text'=>'➖ حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
			save($from_id."/step.txt","none");
	}
	
		elseif ($step== 'Forward' && $type == 'admin') {
			if ($forward != null) {
			$forward_id = file_get_contents("data/forward_id.txt");
			Forward($forward_id,$chat_id,$message_id);
			save($from_id."/step.txt","none");
			SendMessage($chat_id,"فروارد  شد !");
			}
			else {
				SendMessage($chat_id,"یک پیام را فروارد کنید !");
			}
		}
	elseif ($step== 'Set Age' && $type == 'admin') {
	
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ نام شما با موفقیت آپدیت شد.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                 [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                   ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/age.txt","$textmessage");
	}
	
	elseif ($step== 'Set Name' && $type == 'admin') {
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ با موفقیت تغییر یافت.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                 [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                   ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/name.txt","$textmessage");
	}
	
	elseif ($step== 'Set Bio' && $type == 'admin') {
	save($from_id."/step.txt","none");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"✅ با موفقیت تغییر یافت.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                 [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                  ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		save("profile/bio.txt","$textmessage");
	}
	elseif ($step== 'Send To All' && $type == 'admin') {
		SendMessage($chat_id,"پیام در حال `ارسال` میباشد");
		save($from_id."/step.txt","none");
		$fp = fopen( "data/users.txt", 'r');
		while( !feof( $fp)) {
 			$users = fgets( $fp);
			SendMessage($users,$textmessage);
		}
		SendMessage($chat_id,"✅ پیام شما به تمامی `کاربران رباتتان`ارسال شد.");
		
	}
	elseif ($step== 'Edit Start Text' && $type == 'admin') {
		save($from_id."/step.txt","none");
		save("start_txt.txt",$textmessage);
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"پیام استارت شما تغییر یافت.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                 [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                   ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($step== 'Edit Message Delivery' && $type == 'admin') {
		save($from_id."/step.txt","none");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"پیام پیشفرض شما آپدیت شد.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                 [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                   ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		save("pmsend_txt.txt",$textmessage);
	}
	
	elseif (file_exists("data/words/$textmessage.txt")) {
		SendMessage($chat_id,file_get_contents("data/words/$textmessage.txt"));
		
	}
	
	elseif ($textmessage == '🚆امکانات' && $from_id == $admin) {
		if ($bottype != 'free') {
			var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 به بخش امکانات خوش امدید.",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'🗣 تنظیمات پاسخ خودکار']
                ],
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
        }
		else {
			SendMessage($chat_id,"ربات شما رایگان است .");
		}
	}
	elseif ($textmessage == '➖ حذف کلمه' && $from_id == $admin) {
				save($from_id."/step.txt","del words");

		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 کلمه مورد نظر را وارد کنید.",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	elseif ($textmessage == '🗣 تنظیمات پاسخ خودکار' && $bottype != 'free' && $from_id == $admin) {

		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا یک گزینه را انتخاب کنید.",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				[
                   ['text'=>'➕ اضافه کردن کلمه'],['text'=>'➖ حذف کلمه']
                ],
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		
	}
	elseif ($textmessage == '➕ اضافه کردن کلمه' && $bottype != 'free' && $from_id == $admin) {
				save($from_id."/step.txt","set word");
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 کلمه ای که باید دریافت شود را وارد کنید.
مثل:
سلام",
			'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
				
                 [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '▶️ ویرایش پیام استارت' && $from_id == $admin) {
	$sttxt = file_get_contents("data/start_txt.txt");
	save($from_id."/step.txt","Edit Start Text");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا متن جدید پیام استارت
را ارسال نمایید تا تغییر کند.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '⏸ ویرایش پیام پیشفرض' && $from_id == $admin) {
	$sttxt = file_get_contents("data/pmsend_txt.txt");
	save($from_id."/step.txt","Edit Message Delivery");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا متن جدید بخش پیام ارسال شد! 
را ارسال نمایید تا تغییر کند.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '⚙ تنظیمات' && $from_id == $admin) {
	
	var_dump(makereq('sendMessage',[
			'chat_id'=>$update->message->chat->id,
			'text'=>"به تنظیمات روبات خوش آمدید.
`
 ⛔️ = قفل شده.
 ✅ = آزاد"."`",
			'parse_mode'=>'MarkDown',
			'reply_markup'=>json_encode([
				'inline_keyboard'=>[

					[
						['text'=>"دسترسی فروارد",'callback_data'=>"forward"],['text'=>$_forward,'callback_data'=>"forward"]
					]
				]
			])
		]));
	
	}
	
	elseif ($textmessage == '👁 شماره ی من رو نشون بده' && $from_id == $admin) {
	$anumber = file_get_contents("data/profile/number.txt");
	$aname= file_get_contents("data/profile/cname.txt");
	makereq('sendContact',[
	'chat_id'=>$chat_id,
	'phone_number'=>$anumber,
	'first_name'=>$aname
	]);
	}
	elseif ($textmessage == 'سن' && $from_id == $admin) {
	save($from_id."/step.txt","Set Age");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا سن خود را وارد کنید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == 'نام' && $from_id == $admin) {
	save($from_id."/step.txt","Set Name");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا نام خود را وارد کنید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == 'درباره شما' && $from_id == $admin) {
	save($from_id."/step.txt","Set Bio");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 لطفا بیوگرافی خود را وارد کنید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '☎️  تنظیمات کانتکت' && $from_id == $admin) {
	save($from_id."/step.txt","Set Contact");
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 یک گزینه را انتخاب کنید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🌐 تنظیم شماره تلفن' , 'request_contact' => true]
                ],
              	[
                   ['text'=>'👁 شماره ی من رو نشون بده']
                ],
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	
	elseif ($textmessage == '👥 آمار' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/users.txt", 'r');
	while( !feof( $fp)) {
    		fgets( $fp);
    		$usercount ++;
	}
	fclose( $fp);
	SendMessage($chat_id,"👤` اعضای ربات`: `".$usercount."`");
	}
	
	elseif ($textmessage == '⚫️ لیست سیاه' && $from_id == $admin) {
	$usercount = -1;
	$fp = fopen( "data/blocklist.txt", 'r');
	while( !feof( $fp)) {
    		$line = fgets( $fp);
    		$usercount ++;	
			
			if ($line == '') {
				$usercount = $usercount-1;
			}
	}
	fclose( $fp);
	SendMessage($chat_id,"💂🏿`افراد مسدود شده شما:` `".$usercount."`");
	}
	
	

	
	elseif ($textmessage == '⚓️ راهنما' && $from_id == $admin) {
	$text = "
💠 برای دریافت متن راهنما روی یکی از دکمه های زیر کلیک کنید:
🔰 Buttons : راهنمای دکمه ها
🔰 Comments : راهنمای دستورات
	";
	
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>$text,
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"🔰 Comments"],['text'=>"🔰 Buttons"]
                ],
                [ 
                 ['text'=>"🏠 صفحه اصلی"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
	}
	elseif ($textmessage == '👤 پروفایل') {
		if ($from_id == $admin) {
	var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 پروفایل خود را مدیریت کنید.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"نام"],['text'=>"سن"],['text'=>"درباره شما"]
                ],
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
		else {
			$name = file_get_contents("data/profile/name.txt");
			$age = file_get_contents("data/profile/age.txt");
			$bio = file_get_contents("data/profile/bio.txt");
			$protxt = "";
			if ($name == '' && $age == '' && $bio == '') {
				$protxt = "📕 پروفایل خالی است . . . !";
			}
			if ($name != '') {
				$protxt = $protxt."\nاسم : ".$name;
			}
			
			if ($age != '') {
				$protxt = $protxt."\nسن : ".$age;
			}
			
			if ($bio != '') {
				$protxt = $protxt."\nبیوگرافی : \n".$bio;
			}
			SendMessage($chat_id,$protxt);
		}
	}
	elseif ($textmessage == '🔰 Comments' && $from_id == $admin) {
	$text = " `
	🔰دستورات

- برای پاسخ با پیام های کاربران روی ان ها ریپلای کنید و پیام خود را ارسال کنید.

+ لیست دستورات

  /ban : 
 روی پیام رپلای کنید و  ban/ را ارسال کنید
 برای اضافه کردن کاربر به لیست سیاه


  /unban : 
 روی پیام رپلای کنید و  unban/ را ارسال کنید
 برای پاک کردن کاربر از لیست سیاه

  /forward : 
 روی پیام رپلای کنید و  forward/ را ارسال کنید
 جهت فروارد کردن پیام برای کاربر 
 ابتدا روی شخص ریپلای کنید و forward/ را ارسال کنید و بعد پیام مورد نظرتان را اینجا فروارد کنید


  /share :  
 روی پیام رپلای کنید و  share/ را ارسال کنید
 برای شیر کردن کانتکت(شماره شما) [شما ابتدا باید از بخش تنظیمات کانتکت شماره ی خود را ثبت کنید]
	`";
	SendMessage($chat_id,$text);
	}
	
	elseif ($textmessage == '🔰 Buttons' && $from_id == $admin) {
	$text = "
	🔰دکمه ها

+ Buttons List

  🗣 پیام همگانی :
  ارسال پیام به اعضا و گروه ها.

  ⚙ تنظیمات :
  تنظیمات ربات.

  ▶️ ویرایش پیام استارت :
  ویرایش پیام استارت ربات شما.

  ⏸ ویرایش پیام پیشفرض :
  ویرایش پیام پیشفرض ربات شما.

  👥 آمار :
  مشاهده ی تعداد اعضا و گروه ها.

  ⚫️ لیست سیاه :
  مشاهده ی لیست سیاه.

  ☎️  تنظیمات کانتکت :
  تنظیمات شماره ی شما.

  👤 پروفایل :
  تنظیمات پروفایل شما.
	";
	SendMessage($chat_id,$text);
	}
	
	elseif($textmessage == '/start')
	{
		$txt = file_get_contents("data/start_txt.txt");
		//==============
		if ($type == "admin") {
		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"به روبات خودتون خوش آومدین.",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>"⚓️ راهنما"]
                ],
                [
                   ['text'=>"🗣 پیام همگانی"],['text'=>"⚙ تنظیمات"]
                ],
                [
                   ['text'=>"▶️ ویرایش پیام استارت"],['text'=>"⏸ ویرایش پیام پیشفرض"]
                ],
                [
                   ['text'=>"👥 آمار"],['text'=>"⚫️ لیست سیاه"]
                ],
                [
                   ['text'=>"👤 پروفایل"],['text'=>"🚆امکانات"]
                ],
                [
                   ['text'=>"☎️  تنظیمات کانتکت"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
else {
        if ($bottype == "gold") {

        var_dump(makereq('sendMessage',[
          'chat_id'=>$update->message->chat->id,
          'text'=>$txt,
    'parse_mode'=>'MarkDown',
          'reply_markup'=>json_encode([
              'keyboard'=>[
                [
                ['text'=>"ارسال شماره شما",'request_contact' => true],['text'=>"ارسال لوکیشن شما",'request_location' => true]
                ],
                [
                   ['text'=>"👤 پروفایل"]
                ]
              ],
              'resize_keyboard'=>true
           ])
        ]));
Forward($chat_id,"@msgresan",$adad);
    		}
    		else {
    		var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>$txt,
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                ['text'=>"ارسال شماره شما",'request_contact' => true],['text'=>"ارسال لوکیشن شما",'request_location' => true]
                ],
                [
                   ['text'=>"👤 پروفایل"]
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
    		}
    		}
		//==============
		$users = file_get_contents("data/users.txt");
		if (strpos($users , "$chat_id") !== false)
		{ 
		
		}
		else { 
			$myfile2 = fopen("data/users.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$from_id\n");
			fclose($myfile2);
			mkdir("data/".$from_id);
			save($from_id."/type.txt","member");
			save($from_id."/step.txt","none");
		     }
	}
	elseif ($reply != null && $from_id == $admin) {
		if ($textmessage == '/share') {
		$anumber = file_get_contents("data/profile/number.txt");
		$aname= file_get_contents("data/profile/cname.txt");
		makereq('sendContact',[
		'chat_id'=>$reply,
		'phone_number'=>$anumber,
		'first_name'=>$aname
		]);
		SendMessage($chat_id,"ارسال شد .");
		}
		elseif ($textmessage == '/forward') {
		SendMessage($chat_id,"پیام خود را فروارد کنید !");	
		save($from_id."/step.txt","Forward");
		save("forward_id.txt","$reply");
		}
		elseif ($textmessage == '/ban') {
			$myfile2 = fopen("data/blocklist.txt", "a") or die("Unable to open file!");	
			fwrite($myfile2, "$reply\n");
			fclose($myfile2);
			SendMessage($chat_id,"*User Banned!*");
			SendMessage($reply,"*You Are Banned!*");
		}
		elseif ($textmessage == '/unban') {
			
			$newlist = str_replace($reply,"",$list);
			save("blocklist.txt",$newlist);
			SendMessage($chat_id,"*User UnBanned!*");
			SendMessage($reply,"*You Are UnBanned!*");
		}
		else {
	SendMessage($reply ,$textmessage);
	SendMessage($chat_id,"پیام ارسال شد .");	
		}
	}
	

	elseif ($forward != null && $_forward == "⛔️") {
		SendMessage($chat_id,"Locked!");
	}
	elseif (strpos($textmessage , "/toall") !== false  || $textmessage == "🗣 پیام همگانی") {
		if ($from_id == $admin) {
			save($from_id."/step.txt","Send To All");
				var_dump(makereq('sendMessage',[
        	'chat_id'=>$update->message->chat->id,
        	'text'=>"💠 متن خود را بنویسید :",
		'parse_mode'=>'MarkDown',
        	'reply_markup'=>json_encode([
            	'keyboard'=>[
                [
                   ['text'=>'🏠 صفحه اصلی']
                ]
            	],
            	'resize_keyboard'=>true
       		])
    		]));
		}
		else {
			SendMessage($chat_id,"You Are Not Admin");
		}
	}
	else
	{
		if ($from_id != $admin) {
		$txt = file_get_contents("data/pmsend_txt.txt");
		SendMessage($chat_id,$txt);
		Forward($admin,$chat_id,$message_id); 
		}
		else {
		SendMessage($chat_id,"*Command Not Found!*
		`دستور موردنظر یافت نشد`");
		}
	}
	
	
	?>