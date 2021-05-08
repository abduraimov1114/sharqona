<?php


function imageUrlFilter($text)
{
    $text2 = "";
    $textln = strlen($text);
    for($i = 0;$i < $textln; $i++)
    {
        if($text[$i] == ' ')
        {
            $text2.="%20";
        }
        else
        {
            $text2.=$text[$i];
        }
    }
    return $text2;
}
    //--------------------- Admin side ------------------------------
    function isAdmin($username, $user_id, $chat_id, $db){
        $uname = mysqli_query($db, "SELECT uname FROM agro_admin WHERE uname = '".$username."'");
        $n = mysqli_num_rows($uname);
        if($n > 0){
            mysqli_query($db, "UPDATE agro_admin SET id = $user_id, chat = $chat_id WHERE uname = '".$username."'");
            return true;
        }
        else return false;
    }
    
    function addAdmin($text, $db){
        $add = mysqli_query($db, "INSERT INTO agro_admin (uname) VALUES ('".$text."')");
        if($add)
            return true;
        else return false;
    }

    function delAdmin($text, $db){
        $del = mysqli_query($db, "DELETE FROM agro_admin WHERE uname = '".$text."'");
        if($del)
            return true;
        else return false;
    }
    
    function adminList($chat_id, $db){
        $uname = mysqli_query($db, "SELECT uname FROM agro_admin");
        if($uname){
            $list = '';
            foreach($uname as $i){
                $list .= $i['uname']."\n";
            }
            sendSimpleMessage($chat_id, $list);
        }
        else sendSimpleMessage($chat_id, "Adminlar topilmadi");
    }
    
    function adminKeyboard($chat_id, $text, $username){
        if($username == "okhundev"){
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Buyurtmalarni ko`rish"], ['text' => "Katalogni o`zgartirish"]],
                    [['text' => "Administrator qo`shish"],['text' => "Administratorni o`chirish"]],
                    [['text' => "Administratorlar ro`yxati"]]
                ]
            ]);
        }
        else {
             $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Buyurtmalarni ko`rish"]]
                ]
            ]);
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $json
        ]);
    }
    
    function addProduct($text, $con, $db){
        if($con == 1) {
            mysqli_query($db, "INSERT INTO agro_catalog (name) VALUES ('".$text."')");
        }
        else if ($con == 2){
            $id = mysqli_query($db, "SELECT id FROM agro_catalog WHERE id > 0 ORDER BY id DESC LIMIT 1");
            $i = mysqli_fetch_array($id);
            $upd = mysqli_query($db, "UPDATE agro_catalog SET file = '".$text."' WHERE id = '".$i['id']."' LIMIT 1");
            if($upd) return true;
            else return false;
        }
    }

    function katalogKey($chat_id){
        $text = "Katalog ma`lumotlarini o`zgartirish";
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Yangi mahsulot qo`shish"], ['text' => "⬅️Ortga"]
                ]]])
        ]);
    }

    function showCatalog($chat_id, $db){
        $pr = mysqli_query($db, "SELECT * FROM agro_catalog");
        $n = mysqli_num_rows($pr);
        if($n > 0){
            foreach($pr as $i){
                bot('sendPhoto',[
                    'chat_id' => $chat_id,
                    'photo' => $i['file'],
                    'caption' => $i['name'],
                    'reply_markup' => json_encode([
                        'inline_keyboard' => [
                            [['text' => "❌O`chirish", 'callback_data' => $i['id']]]
                    ]])
                ]);
                sendSimpleMessage($chat_id, $i['id']);
            }
        }
    }
    function delProduct($data, $db){
        $del = mysqli_query($db, "DELETE FROM agro_catalog WHERE id = $data");
        if($del) return true;
        else return false;
    }
    //-------------------------------------end--------------------------
    
    //-------------------------- Navigate History ----------------------
    function addHistory($chat_id, $text, $db){
        $add = mysqli_query($db, "INSERT INTO agro_history (chat, msg) VALUES ($chat_id, '".$text."')");
    }
    
    function lastNav($chat_id, $db){
        $add = mysqli_query($db, "SELECT msg FROM agro_history WHERE chat = $chat_id ORDER BY id DESC LIMIT 1");
        $d = mysqli_fetch_array($add);
        if($add)
            return $d['msg'];
        else return false;
    }
    
    function delHistory($chat_id, $db, $con){
        if($con == 1)
            mysqli_query($db, "DELETE FROM agro_history WHERE chat = $chat_id ORDER BY id DESC LIMIT 1");
        else if($con == 2)
            mysqli_query($db, "DELETE FROM agro_history WHERE chat = $chat_id");
    }
    //----------------------------------end------------------------------
    
    //---------------------------------Order-----------------------------
    function orderList($chat_id, $db){
        $list = mysqli_query($db, "SELECT * FROM compass_order WHERE deliver='wait'");
        $row = mysqli_num_rows($list);
        if($row > 0)
        foreach($list as $i){
            bot('sendMessage', [
                'chat_id' => $chat_id,
                'text' => "FISh: ".$i['name']." ".$i['sname']."\nViloyati: ".$i['region']."\nTel. raqami: ".$i['phone']."\nMaxsulot: ".$i['product']."\nMiqdor: ".$i['amount'],
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "🆗Qabul qilindi", 'callback_data' => $i['id']], ['text' => "❌O`chirib tashlash", 'callback_data' => "-".$i['id']]]]])
            ]);
        }
        else sendSimpleMessage($chat_id, 'Hozircha buyurtmalar yo`q');
    }
    
    function manage($username, $text, $db, $chat_id){
        if($text > 0){
            $upd = mysqli_query($db, "UPDATE compass_order SET deliver = '".$username."' WHERE id = $text");
            if($upd) return true;
            else return false;
        }
        else{
            $text = -1 * $text;
            $del = mysqli_query($db, "DELETE FROM compass_order WHERE id = $text");
            if($del) return true;
            else return false;
        }
    }
    //---------------------------------end-----------------------------------
    
    //------------------------------Language + Region---------------------------------
    function  Reg($chat_id, $db){
        $isReg = mysqli_query($db, "SELECT FROM agro_lan WHERE id = $chat_id");
        if(!$isReg)
            mysqli_query($db, "INSERT INTO agro_lan (id) VALUES ($chat_id)");
    }
    
    function setLan($chat_id, $lan, $db){
        mysqli_query($db, "UPDATE agro_lan SET lang = $lan WHERE id = $chat_id");
    }
    
    function setRegion($chat_id, $region, $db){
        mysqli_query($db, "UPDATE agro_lan SET region = '".$region."' WHERE id = $chat_id");
    }
    
    function getInfo($chat_id, $con, $db){
        $lan = mysqli_query($db, "SELECT * FROM agro_lan WHERE id = $chat_id");
        $e = mysqli_fetch_array($lan);
        if($con == 1)
            return $e['lang'];
        else if($con == 2) return $e['region'];
    }

    function delInfo($chat_id, $con, $db){
      
        if($con == 1)
            mysqli_query($db, "UPDATE agro_lan SET lang = NULL WHERE id = $chat_id");
        else if($con == 2)
            mysqli_query($db, "UPDATE agro_lan SET region = NULL WHERE id = $chat_id");
    }
    //--------------------------------end------------------------------------
    //------------------------------User Keyboard----------------------------
    function userKey($chat_id, $lan){
        if($lan == 1){
            $text = "Sizga qanday yordam berishim mumkin?";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "🛍Katalog"], ['text' => "📞Bog`lanish"]],
                    [['text' => "📡Manzilimiz"],['text' => "🛒Savatcha"]],
                    [['text' => "📮Fikringizni qoldiring"], ['text' => "⚙️Sozlamalar"]]
                ]
            ]);
        }
        else  if($lan == 2){
            $text = "Как я могу вам помочь?";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "🛍Каталог"], ['text' => "📞Контакты"]],
                    [['text' => "📡Локация"],['text' => "🛒Корзинка"]],
                    [['text' => "📮Оставьте отзыв"], ['text' => "⚙Настройки"]]
                ]
            ]);
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $json
        ]);
    }
    
    function regionKey($chat_id, $lan, $text){
        if($lan == 1){
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Andijon"], ['text' => "Buxoro"], ['text' => "Jizzax"]],
                    [['text' => "Farg`ona"], ['text' => "Qoraqalpog`iston Respublikasi"]],
                    [['text' => "Sirdaryo"], ['text' => "Surxondaryo"]],
                    [['text' => "Samarqand"], ['text' => "Qashqadaryo"]]
                ]
            ]);
        }
        else if($lan == 2){
           $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Андижан"], ['text' => "Бухара"], ['text' => "Джиззак"]],
                    [['text' => "Фергана"], ['text' => "Республика Каракалпакстан"]],
                    [['text' => "Сырдарья"], ['text' => "Сурхандарья"]],
                    [['text' => "Самарканд"], ['text' => "Кашкадарья"]]
                ]
            ]);
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $json
        ]);
    }
    
    function lanKey($chat_id){
        $text = "Xizmat ko`rsatish tilini tanlang\n_________________________\nВыберите язык сервиса";
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "O`zbekcha"], ['text' => "Русский"]],
                ]
            ])
        ]);
    }
    
    function backKey($chat_id, $lan){
        if($lan == 1){
            $text = "Biz uchun sizning fikringiz juda muhim!";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "⬅️Ortga"]]
                ]
            ]);
        }
        else if($lan == 2){
            $text = "Ваше мнение очень важно для нас!";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "⬅️Назад"]]
                ]
            ]);
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $json
        ]);
    }

    function settingsKey($chat_id, $lan){
        if($lan == 1){
            $text = "Sozlamani tanlang";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Tilni o`zgartirish"], ['text' => "Viloyatni o`zgartirish"]],
                    [['text' => "Bosh menyu"]]
                ]
            ]);
        }
        else if($lan == 2){
            $text = "Выберите настройку";
            $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Изменить язык"], ['text' => "Изменить регион"]],
                    [['text' => "Главное меню"]]
                ]
            ]);
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $json
        ]);
    }

    function myOrder($chat_id, $lan, $db){
        $list = mysqli_query($db, "SELECT * FROM compass_order WHERE deliver='wait' AND chat='".$chat_id."'");
        $row = mysqli_num_rows($list);
        if($lan == 1){
            if($row > 0)
                foreach($list as $i){
                    bot('sendMessage', [
                        'chat_id' => $chat_id,
                        'text' => "FISh: ".$i['name']." ".$i['sname']."\nTel. raqami: ".$i['phone']."\nMaxsulot: ".$i['product']."\nMiqdor: ".$i['amount'],
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [['text' => "❌Bekor qilish", 'callback_data' => "-".$i['id']]]]])
                    ]);
                }
            else{
                sendSimpleMessage($chat_id, 'Hozircha buyurtmalar yo`q');
                userKey($chat_id, $lan);
            }
        }
        else if($lan == 2){
            if($row > 0)
                foreach($list as $i){
                    bot('sendMessage', [
                        'chat_id' => $chat_id,
                        'text' => "ФИО: ".$i['name']." ".$i['sname']."\nТел. Номер: ".$i['phone']."\nПродукт: ".$i['product']."\nКоличество: ".$i['amount'],
                        'reply_markup' => json_encode([
                            'inline_keyboard' => [
                                [['text' => "❌Отменить", 'callback_data' => "-".$i['id']]]]])
                    ]);
                }
            else{
                sendSimpleMessage($chat_id, 'Ваша корзинка пуста');
                userKey($chat_id, $lan); 
            } 
        }
    }

    //---------------------------------end-----------------------------------
    //-------------------------------Catalog---------------------------------

    $json = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "Изменить язык"], ['text' => "Изменить регион"]],
                    [['text' => "Главное меню"]]
                ]
            ]);
    function mainKey($chat_id, $lan, $text){
        if($lan == 1){
            $text = "Kategoriyalardan birini tanlang";
            $button = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "💻 NOUTBUKLAR"]],
                    [['text' => "🖥 KOMPYUTERLAR"]],
                    [['text' => "📱 SMARTFONLAR"]],
                    [['text' => "🖨 PRINTERLAR"]],
                    [['text' => "⬅️"]]
            ]]);
       
            // $text = "O`zingizga maqul mahsulotni topasiz degan umiddamiz";
            // $t = "Bosh menu";
        }
        else if($lan == 2){
            $text = "Выберите категории";
            $button = json_encode([
                'resize_keyboard' => true,
                'keyboard' => [
                    [['text' => "💻 НОУТБУКИ"]],
                    [['text' => "🖥 КОМПЬЮТЕРЫ"]],
                    [['text' => "📱 СМАРТФОНЫ"]],
                    [['text' => "🖨 ПРИНТЕРЫ И МФУ"]],
                    [['text' => "⬅️"]]
            ]]);
        
            // $text = "Мы надеемся, что вы найдете подходящий продукт для себя";
            // $t = "Главное меню";
        }
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => $text,
            'reply_markup' => $button
        ]);
    }

    function messageTo($chat_id)
    {
        bot('sendMessage',[
            'chat_id' => $chat_id,
            'text' => "Done"
        ]);
    }

    function showCatalogue($chat_id, $lan, $last, $db){
        $dollar_select = "SELECT * FROM dollar WHERE dollar_id = 1";
        $dollar_me = mysqli_query($db, $dollar_select);
        $dollar_you = mysqli_fetch_row($dollar_me);
        $dollar = $dollar_you[1];
        $sum = $dollar;
        $site_url = "https://vosxod.uz/";
        
        if($lan == 1){
            $text = "Buyurtma qilish";
        }
        else if($lan == 2){
            $text = "Заказать";
        }
        $k = 0;
        if($last >= 0){
            $pr = mysqli_query($db, "SELECT products.*, product_category.*, mother_categories.* FROM products LEFT JOIN product_category ON (products.product_category_id=product_category.pcat_id) LEFT JOIN mother_categories ON (mother_categories.mother_cat_id = product_category.mother_category) WHERE mother_categories.mother_cat_id=7 AND products.product_id > $last AND product_count > 0 LIMIT 2");    
            $i = mysqli_fetch_array($pr);
            $n = mysqli_num_rows($pr);
            $l = 0;
            if($n > 1){
                if($last == 0){
                    $json = json_encode([
                                'inline_keyboard' => [
                                    [['text' => $text, 'callback_data' => $i['product_id']]],
                                    [['text' => "➡️", 'callback_data' => '+']]
                            ]]);
                }
                else {
                    $json = json_encode([
                                'inline_keyboard' => [
                                    [['text' => $text, 'callback_data' => $i['product_id']]],
                                    [['text' => "⬅️", 'callback_data' => '-'], ['text' => "➡️", 'callback_data' => '+']]
                            ]]);
                }
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => $json
                        ]);
                    }
                        
                    $l++;
                }
            }
            else {
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "⬅️", 'callback_data' => '-']]
                                ]])
                        ]);
                    }
                    $l++;
                }
            }
        }
        else{
            $lt = -1 * $last;
            $pr = mysqli_query($db, "SELECT products.*, product_category.*, mother_categories.* FROM products LEFT JOIN product_category ON (products.product_category_id=product_category.pcat_id) LEFT JOIN mother_categories ON (mother_categories.mother_cat_id = product_category.mother_category) WHERE mother_categories.mother_cat_id=7 AND products.product_id < $lt AND product_count > 0 ORDER BY products.product_id DESC LIMIT 2");
            $i = mysqli_fetch_array($pr);
            echo $i;
            $n = mysqli_num_rows($pr);
            $l = 0;
            if($n > 1){
                foreach($pr as $j){
                    if($l == 1){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",          
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "⬅️", 'callback_data' => '-'], ['text' => "➡️", 'callback_data' => '+']]
                                ]])
                        ]);
                    }
                    $l++;
                }
            }
            else {
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'text' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "➡️", 'callback_data' => '+']]
                                ]])
                        ]);
                    }   
                    $l++;
                }
            }
        }
        
        return $k;
    }

    function showcom($chat_id, $lan, $last=3, $db)
    {
        $dollar_select = "SELECT * FROM dollar WHERE dollar_id = 1";
        $dollar_me = mysqli_query($db, $dollar_select);
        $dollar_you = mysqli_fetch_row($dollar_me);
        $dollar = $dollar_you[1];
        $sum = $dollar;
        $site_url = "https://vosxod.uz/";
        
        if($lan == 1){
            $text = "Buyurtma berish";
        }
        else if($lan == 2){
            $text = "Заказать";
        }
        $k = 0;
        if($last >= 0){
            $pr = mysqli_query($db, "SELECT products.*, product_category.*, mother_categories.* FROM products LEFT JOIN product_category ON (products.product_category_id=product_category.pcat_id) LEFT JOIN mother_categories ON (mother_categories.mother_cat_id = product_category.mother_category) WHERE mother_categories.mother_cat_id=4 AND products.product_id > $last AND product_count > 0 LIMIT 2");    
            $i = mysqli_fetch_array($pr);
            $n = mysqli_num_rows($pr);
            $l = 0;
            if($n > 1){
                if($last == 0){
                    $json = json_encode([
                                'inline_keyboard' => [
                                    [['text' => $text, 'callback_data' => $i['product_id']]],
                                    [['text' => "➡️", 'callback_data' => '+']]
                            ]]);
                }
                else {
                    $json = json_encode([
                                'inline_keyboard' => [
                                    [['text' => $text, 'callback_data' => $i['product_id']]],
                                    [['text' => "⬅️", 'callback_data' => '-'], ['text' => "➡️", 'callback_data' => '+']]
                            ]]);
                }
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => $json
                        ]);
                    }
                        
                    $l++;
                }
            }
            else {
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "⬅️", 'callback_data' => '-']]
                                ]])
                        ]);
                    }
                    $l++;
                }
            }
        }
        else{
            $lt = -1 * $last;
            $pr = mysqli_query($db, "SELECT products.*, product_category.*, mother_categories.* FROM products LEFT JOIN product_category ON (products.product_category_id=product_category.pcat_id) LEFT JOIN mother_categories ON (mother_categories.mother_cat_id = product_category.mother_category) WHERE mother_categories.mother_cat_id=4 AND products.product_id < $lt AND product_count > 0 ORDER BY products.product_id DESC LIMIT 2");
            $i = mysqli_fetch_array($pr);
            echo $i;
            $n = mysqli_num_rows($pr);
            $l = 0;
            if($n > 1){
                foreach($pr as $j){
                    if($l == 1){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'caption' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",          
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "⬅️", 'callback_data' => '-'], ['text' => "➡️", 'callback_data' => '+']]
                                ]])
                        ]);
                    }
                    $l++;
                }
            }
            else {
                foreach($pr as $j){
                    if($l == 0){
                        $k = $j['product_id'];
                        bot('sendPhoto',[
                                'chat_id' => $chat_id,
                                'photo' => $site_url."images/".imageUrlFilter($i['product_img']),
                                'text' => "<b>".$i['product_name']."</b>"
                                ."\r\n💰 <b>".number_format($i['product_prise_out'] * $sum, 0, '.', ' ')." UZS</b>\r\n",
                                'parse_mode' => 'HTML',
                                'reply_markup' => json_encode([
                                    'inline_keyboard' => [
                                        [['text' => $text, 'callback_data' => $i['product_id']]],
                                        [['text' => "➡️", 'callback_data' => '+']]
                                ]])
                        ]);
                    }   
                    $l++;
                }
            }
        }
        
        return $k;
    }
           
     
        function confirmOrder($chat_id, $data, $step, $db){
        $p = mysqli_query($db, "SELECT product_name FROM products WHERE product_id = $data");
        $prod = mysqli_fetch_array($p);
        $i = mysqli_query($db, "SELECT id FROM compass_order ORDER BY id DESC LIMIT 1");
        $id = mysqli_fetch_array($i);
        if($p && $step == 0){
            $region = getInfo($chat_id, 2, $db);
            $add = mysqli_query($db, "INSERT INTO compass_order (chat, product, region) VALUES ('".$chat_id."', '".$prod['product_name']."', '".$region."')");
        }
        else if($step == 1)
            mysqli_query($db, "UPDATE compass_order SET amount='".$data."' WHERE id = '".$id['id']."'");
        else if($step == 2)
            mysqli_query($db, "UPDATE compass_order SET name='".$data."' WHERE id = '".$id['id']."'");
        else if($step == 3)
            mysqli_query($db, "UPDATE compass_order SET sname='".$data."' WHERE id = '".$id['id']."'");
        else if($step == 4)
            mysqli_query($db, "UPDATE compass_order SET phone='".$data."' WHERE id = '".$id['id']."'");
    }

    function location($chat_id, $lan){
        if($lan == 1){
            $text = "Bizning Google xaritadagi joylashuvimiz";
        }
        else if($lan == 2){
            $text = "Наше местоположение на Google Maps";
        }
        sendSimpleMessage($chat_id, $text);
        bot("sendLocation", [
            'chat_id' => $chat_id,
            'latitude' => 40.099871,
            'longitude' => 65.379527
        ]);
    }

    function sendPhoto($chat_id, $photo){
        bot("sendPhoto", [
            'chat_id' => $chat_id,
            'photo' => $photo
        ]);
    }
    function sendSimpleMessage($chat_id, $text){
        bot('sendMessage', [
            'chat_id' => $chat_id,
            'text' => $text
        ]);
    }
    
    function delMessage($chat_id, $msg_id){
        bot('deleteMessage', [
            'chat_id' => $chat_id,
            'message_id' => $msg_id
        ]);
    }
    function sendReview($username, $text, $db){
        $chat = mysqli_query($db, "SELECT chat FROM agro_admin");
        foreach($chat as $i){
            sendSimpleMessage($i['chat'], $username." Fikr bildirdi:\n".$text);
        }
    }
    function alertOrder($chat_id, $db){
        $list = mysqli_query($db, "SELECT * FROM compass_order WHERE chat=$chat_id ORDER BY id DESC LIMIT 1");
        $row = mysqli_num_rows($list);
        $i = mysqli_fetch_array($list);
        $chat = mysqli_query($db, "SELECT chat FROM agro_admin");
        if($row > 0)
        foreach($chat as $k){
            bot('sendMessage', [
                'chat_id' => $k['chat'],
                'text' => "FISh: ".$i['name']." ".$i['sname']."\nViloyati: ".$i['region']."\nTel. raqami: ".$i['phone']."\nMaxsulot: ".$i['product']."\nMiqdor: ".$i['amount'],
                'reply_markup' => json_encode([
                    'inline_keyboard' => [
                        [['text' => "🆗Qabul qilindi", 'callback_data' => $i['id']], ['text' => "❌O`chirib tashlash", 'callback_data' => "-".$i['id']]]]])
            ]);
        }
    }
?>