<?php

    include "bot_api.php";
    include "controller.php";
   // include "getprinters.php";
    include "baza.php";
     $API_KEY = '1065408611:AAGm7yzJqRaKbk7kpl_Pqs-IvDQwvAVIu0Q';
    define(API_KEY, $API_KEY);

    $update = json_decode(file_get_contents("php://input"));
    $message = $update->message;
    $chat_id = $message->chat->id;
    $mid = $message->message_id;
    $text = $message->text;
    $username = $message->from->username;
    $user_id = $message->from->id;
    $photo = $message->photo[1]->file_id;

    $data = $update->callback_query->data;
    $chat_id2 = $update->callback_query->message->chat->id;
    $mid2 = $update->callback_query->message->message_id;
    $username2 = $update->callback_query->from->username;
    $user_id2 = $update->callback_query->from->id;
    
    $admin = isAdmin($username, $user_id, $chat_id, $db);
    if($data)
    $admin = isAdmin($username2, $user_id2, $chat_id2, $db);
    if($admin){
        if($text == "Buyurtmalarni ko`rish"){
            orderList($chat_id, $db);
            addHistory($chat_id, "list", $db);
        }
        else if(lastNav($chat_id2, $db) == "list" && $data){
            //sendSimpleMessage($chat_id2, "111");
            $d = manage($username2, $data, $db, $chat_id2);
            if($d) delMessage($chat_id2, $mid2);
        }
        else if($user_id == 891744546 || $user_id2 == 891744546){
            if($data){
                $d = delProduct($data, $db);
                if($d) delMessage($chat_id2, $mid2);
                addHistory($chat_id, "katalog", $db);
            }
            else if($text == "⬅️Ortga"){
                $text = "O`zgartiriladigan ma`lumotlarni tanlang";
                adminKeyboard($chat_id, $text, $username);
                delHistory($chat_id, 2, $db);
            }
            else if($text == 'Yangi mahsulot qo`shish' && lastNav($chat_id, $db) == 'katalog'){
                sendSimpleMessage($chat_id, "Mahsulot nomini kirting");
                addHistory($chat_id, "nom", $db);
            }
            else if(lastNav($chat_id, $db) == "nom"){
                addProduct($text, 1, $db);
                sendSimpleMessage($chat_id, "Mahsulot suratini yuboring");
                addHistory($chat_id, "surat", $db);
            }
            else if(lastNav($chat_id, $db) == "surat"){
                $add = addProduct($photo, 2, $db);
                if($add){
                    sendSimpleMessage($chat_id, "Mahsulot katalogga qo`shildi");    
                }
                delHistory($chat_id, 2, $db);
                addHistory($chat_id, "katalog", $db);
            }
            else if($text == "Katalogni o`zgartirish"){
                katalogKey($chat_id);
                showCatalog($chat_id, $db);
                addHistory($chat_id, "katalog", $db);
            }
            
            else if($text == "Administratorlar ro`yxati")
                adminList($chat_id, $db);
                
            else if($text == "Administrator qo`shish" || $text == "Administratorni o`chirish"){
                if($text == "Administratorni o`chirish")
                adminList($chat_id, $db);
                sendSimpleMessage($chat_id, "Foydalanuvchining telegramdagi nomi(username)ni kiriting");
                addHistory($chat_id, $text, $db);
            }
            
            else if(lastNav($chat_id, $db) == "Administrator qo`shish"){
                $add = addAdmin($text, $db);
                if($add) {
                    $text = "Administrator muvoffaqiyatli qo`shildi";
                    adminKeyboard($chat_id, $text, $username);
                }
                else {
                    $text = "Administrator qo`shilmadi. Qaytadan urinib ko`ring";
                    adminKeyboard($chat_id, $text, $username);
                    
                }
                delHistory($chat_id, $db, 2);
            }
            
            else if(lastNav($chat_id, $db) == "Administratorni o`chirish"){
                if($username != $text){
                    $del = delAdmin($text, $db);
                    if($del) {
                        $text = "Administrator o`chirildi";
                        adminKeyboard($chat_id, $text, $username);
                    }
                    else {
                        $text = "Administrator o`chirilmadi. Qaytadan urinib ko`ring";
                        adminKeyboard($chat_id, $text, $username);
                    }
                }
                else sendSimpleMessage($chat_id, "Siz o`zingizni administratorlikdan o`chiraolmaysiz!");
                
                delHistory($chat_id, $db, 2);
            }

            else {
                $text = "O`zgartiriladigan ma`lumotlarni tanlang";
                adminKeyboard($chat_id, $text, $username);
            }
        }
        else{
            $text = "O`zgartiriladigan ma`lumotlarni tanlang";
            adminKeyboard($chat_id, $text, $username);
        }
    }
    
    else{
        
        if(!isset($chat_id))
        $chat_id = $chat_id2;
        Reg($chat_id, $db);
        $lan = getInfo($chat_id, 1, $db);
        $region = getInfo($chat_id, 2, $db);
        
        if(!$lan){
            if($text == "O`zbekcha"){
                setLan($chat_id, 1, $db);
                if(!$region){
                    regionKey($chat_id, 1, "Yashash viloyatingizni tanlang");
                    addHistory($chat_id, "region", $db);
                }
                else userKey($chat_id, 1);
            }
                
            else if($text == "Русский"){
                setLan($chat_id, 2, $db);
                if(!$region){
                    regionKey($chat_id, 2, "Выберите область проживание");
                    addHistory($chat_id, "region", $db);
                }
                else userKey($chat_id, 2);
            }
            else lanKey($chat_id);
        }
        
        else if(!$region){
            //sendSimpleMessage($chat_id, lastNav($chat_id, $db));
            if(lastNav($chat_id, $db) == "region"){
                
                setRegion($user_id, $text, $db);
                userKey($chat_id, $lan);
                delHistory($chat_id, $db);
            }
            else {
                if($lan == 1)
                    $t = "Yashash viloyatingizni tanlang";
                else if($lan == 2)
                    $t = "Выберите область проживание";
                regionKey($chat_id, $lan, $t);
                addHistory($chat_id, "region", $db);
            }
        }
        else if($data){
            if($data < 0){
                $d = manage($username2, $data, $db, $chat_id2);
                if($d) delMessage($chat_id2, $mid2);
            }
            else if($data > 0){
                if($lan == 2){
                    $t = "Сколько? (шт.)";
                }
                else if($lan == 1){
                    $t = "Qancha miqdorda? (dona)";
                }
                addHistory($chat_id, "order", $db);
                sendSimpleMessage($chat_id, $t);
                confirmOrder($chat_id, $data, 0, $db);
            }
            else{
                $last = lastNav($chat_id2, $db);
                if($data == '-')
                    $last = '-'.$last;
                $last = showCatalogue($chat_id2, $lan, $last, $db);
                delMessage($chat_id2, $mid2);
                delHistory($chat_id2, $db, 2);
                addHistory($chat_id2, $last, $db);
            }
        }
        else if($text == "Bosh menyu" || $text == "Главное меню"){
            userKey($chat_id, $lan); 
            delHistory($chat_id, $db, 2);
        }
        else if(lastNav($chat_id, $db) == "order"){
            confirmOrder($chat_id, $text, 1, $db);
            if($lan == 1){
                $t = "Iltimos, siz bilan bog`lanishimiz uchun ma`lumotlaringizni qoldiring.\n Ismingiz? ";
            }
            else if($lan == 2){
                $t = "Пожалуйста, оставьте свои данные, чтобы мы могли связаться с вами.\n Ваше имя? ";
            }
            sendSimpleMessage($chat_id, $t);
            addHistory($chat_id, "ism", $db);
        }
        else if(lastNav($chat_id, $db) == "ism"){
            confirmOrder($chat_id, $text, 2, $db);
            if($lan == 1){
                $t = "Familiyangiz? ";
            }
            else if($lan == 2){
                $t = "Ваша фамиля? ";
            }
            sendSimpleMessage($chat_id, $t);
            addHistory($chat_id, "fam", $db);
        }
        else if(lastNav($chat_id, $db) == "fam"){
            confirmOrder($chat_id, $text, 3, $db);
            if($lan == 1){
                $t = "Telefon raqamingiz? ";
            }
            else if($lan == 2){
                $t = "Ваш номер телефона? ";
            }
            sendSimpleMessage($chat_id, $t);
            addHistory($chat_id, "tel", $db);
        }
        else if(lastNav($chat_id, $db) == "tel"){
            confirmOrder($chat_id, $text, 4, $db);
            if($lan == 1){
                $t = "Sizning buyurtmangiz ro`yxatga olindi. Xodimlarimiz tez orada siz bilan bog`lanishadi.";
            }
            else if($lan == 2){
                $t = "Ваш заказ был зачислен. Наши сотрудники скоро свяжутся с вами.";
            }
            sendSimpleMessage($chat_id, $t);
            alertOrder($chat_id, $db);
            delHistory($chat_id, $db, 2);
        }
        else if($text == "⚙️Sozlamalar" || $text == "⚙Настройки"){
            settingsKey($chat_id, $lan);
            addHistory($chat_id, "sozlamalar",$db);
        }
        else if(lastNav($chat_id, $db) == "sozlamalar"){
            if($text == "Tilni o`zgartirish" || $text == "Изменить язык"){
                delInfo($chat_id, 1, $db);
                lanKey($chat_id);
                delHistory($chat_id, $db, 2);
            }
            else if($text == "Viloyatni o`zgartirish" || $text == "Изменить регион"){
                delInfo($chat_id, 2, $db);
                if($lan == 1)
                    $text = "Yashash viloyatingizni tanlang";
                else if($lan == 2)
                    $text = "Выберите область проживание";
                addHistory($chat_id, "region", $db);
                regionKey($chat_id, $lan, $text);
            }
            
        }

        else if($text == "🛒Корзинка" || $text == "🛒Savatcha"){
            myOrder($chat_id, $lan, $db);
        }

        else if($text == "📡Локация" || $text == "📡Manzilimiz")
            location($chat_id, $lan);

        else if($text == "📮Оставьте отзыв" || $text == "📮Fikringizni qoldiring"){
            addHistory($chat_id, "otziv", $db);
            backKey($chat_id, $lan);
        }

        else if(lastNav($chat_id, $db) == "otziv"){
            if($text == "⬅️Ortga" || $text == "⬅️Назад"){
                delHistory($chat_id, $db, 2);
            }
            else {
                sendReview($username, $text, $db);
                delHistory($chat_id, $db, 2);
            }
            userKey($chat_id, $lan);
        }
        
        else if($text == "📞Bog`lanish" || $text == "📞Контакты"){
            if($lan == 1){
                $contact = "Kontaktlar.\nCOMPASS orgtexnika magazini: (93) 461-31-21\nKompyuterlarni ta`mirlash: (95) 610-31-21\nKartridjlarga rang solish: (95) 611-31-21\n\n_____________________\n\nManzilimiz:\nNavoiy shahri, Abdurahmanov ko`chasi 5A\n_____________________\nBizning telegram kanalimiz:\nt.me/compasstech";
            }
            else if($lan == 2){
                $contact = "Контакты:\nМагазин оргтехники COMPASS: (93) 461-31-21\nРемонт компьютеров: (95) 610-31-21\nЗаправка картриджей: (95) 611-31-21\n\n_____________________\n\nАдрес:\nг.Навои, ул.Абдурахманова 5А\n_____________________\nНаш канал:\nt.me/compasstech";
            }            
            sendSimpleMessage($chat_id, $contact);
        }
        else if($text == "🛍Каталог" || $text == "🛍Katalog"){
            // $last = showCatalogue($chat_id, $lan, 0, $db);
            // addHistory($chat_id, $last, $db);
            mainKey($chat_id, $lan);
        }
        else if ($text == "💻 NOUTBUKLAR" || $text == "💻 НОУТБУКИ")
        {
            $last = showCatalogue($chat_id, $lan, 0, $db);
            addHistory($chat_id, $last, $db);
            //mainKey($chat_id, $lan);
        }
        //    else if ($text == "📱 SMARTFONLAR" || $text == "")
        // {
        //     $ab = showcom($chat_id, $lan, 0, $db);
        //     // addHistory($chat_id, $ab, $db);
        //     //mainKey($chat_id, $lan);
        // }
       else if($text == "📱 SMARTFONLAR" || $text == "📱 СМАРТФОНЫ"){
            showcom($chat_id, $lan, 3, $db);
        }
        else{
            userKey($chat_id, $lan); 
            delHistory($chat_id, $db, 2);
        } 
    }

?>