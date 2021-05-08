<?php 
include 'baza.php';
$pr = mysqli_query($db, "SELECT products.*, product_category.*, mother_categories.* FROM products LEFT JOIN product_category ON (products.product_category_id=product_category.pcat_id) LEFT JOIN mother_categories ON (mother_categories.mother_cat_id = product_category.mother_category) WHERE mother_categories.mother_cat_id=7 AND product_count > 0 LIMIT 2");    
            $i = mysqli_fetch_array($pr);
            $n = mysqli_num_rows($pr);
            $l = 0;
            echo $n;

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
        echo $k;
    }
 ?>