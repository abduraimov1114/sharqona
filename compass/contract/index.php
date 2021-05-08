<?
require_once("vendor/autoload.php");
include_once("../../DB/functions.php");
date_default_timezone_set('Asia/Tashkent');
$func = new database_func();
if(!empty($_POST['values']) && isset($_POST['values'])){
//    echo $_POST['values'];
    $reg_date = date("Y-m-d H-i-s");
    $json_data = json_decode($_POST['values']);
    $type = $func->secur($json_data->type);
    $company = $func->secur($json_data->company);
    $doc_nomer_id = $func->secur($json_data->doc_nomer_id);
    $check_date = $func->secur($json_data->check_date);
    $user_name = $func->secur($json_data->user_name);
    $new_user_name = $func->secur($json_data->new_user_name);
    $new_user_contact = $func->secur($json_data->new_user_contact);

    $product_name = $json_data->product_name;
    $product_count = $json_data->product_count;
    $product_price = $json_data->product_price;

    $product_total = $func->secur($json_data->product_total);

    $service_name = $json_data->service_name;
    $service_count = $json_data->service_count;
    $service_price = $json_data->service_price;

    $service_total = $func->secur($json_data->service_total);
    $contract_type = $func->secur($json_data->contract_type);
    $user_id = $user_name;

    $sorov = "select * from new_contract WHERE `nc_id`='".$doc_nomer_id."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    if(($row['nc_id'])==""){
//    $comp_id = $user_name;
//    NEW CODE FOR INSERTING
//    DETECTING NEW USERS FOR AND INSERT BUYERS
    if(!empty($new_user_name)){
        $sorov = "insert into
              buyers
              (
                  `buyers_name`,
                  `buyers_budget`,
                  `buyers_contact`,
                  `buyers_safety`
              )VALUES(
                  '$new_user_name',
                  '0',
                  '$new_user_contact',
                  '0'
              )";
        $result = $func->queryMysql($sorov);
        if(empty($result)){
            $user_id=$func->qr_id();
        }else{
            $user_id=$user_name;
        }
    }
//    SQL INSERTING INTO NEW_CONTRACT
    $TYPE = "";
    if(!empty($product_name)){
        $TYPE .= "P";
    }
    if(!empty($service_name)){
        $TYPE .= "S";
    }
    $sorov = "insert into
              new_contract
              (
                  `buyer_id`,
                  `check_date`,
                  `company`,
                  `product_total`,
                  `service_total`,
                  `type`,
                  `description`,
                  `reg_date`,
                  `doc_url`,
                  `pay_date`,
                  `active_date`,
                  `close_date`,
                  `cancel_date`,
                  `contract_type`
              )VALUES(
                  '$user_id',
                  '$check_date',
                  '$company',
                  '$product_total',
                  '$service_total',
                  '$TYPE',
                  '$desc',
                  '$reg_date',
                  '$reg_date',
                  '$reg_date',
                  '$reg_date',
                  '$reg_date',
                  '$reg_date',
                  '$contract_type'
              )";
    $result = $func->queryMysql($sorov);
    $doc_id=$func->qr_id();
    if(!empty($result)){
        echo "Buldie";
    }else{
        if (!empty($product_name) || !empty($service_name)) {
            $both_select=0;
            if (!empty($product_name) && !empty($service_name)) {
                $both_select=1;
            }

            $values = "";
            $sorov = "insert into new_contract_datails(`sp_name`,`sp_price`,`sp_count`,`sp_type`,`nc_id`)VALUES";
//            for product
            if (!empty($product_name)) {
                for ($i = 0; $i < count($product_name); $i++){
                    $product_name_sql = $product_name[$i];
                    $product_price_sql = $product_price[$i];
                    $product_count_sql = $product_count[$i];
                    if ($i != (count($product_name)-1+$both_select)){
                        $values .= "(
                  '$product_name_sql',
                  '$product_price_sql',
                  '$product_count_sql',
                  'P',
                  '$doc_id'
                  ),";
                    }else{
                        $values .= "(
                  '$product_name_sql',
                  '$product_price_sql',
                  '$product_count_sql',
                  'P',
                  '$doc_id'
                  )";
                    }
                }
            }
//            for service
            if (!empty($service_name)){
                for ($j = 0; $j <count($service_name); $j++) {
                    $service_name_sql = $service_name[$j];
                    $service_price_sql = $service_price[$j];
                    $service_count_sql = $service_count[$j];
                    if ($j!=(count($service_name)-1)){
                        $values .= "(
                  '$service_name_sql',
                  '$service_price_sql',
                  '$service_count_sql',
                  'S',
                  '$doc_id'
              ),";
                    }else{
                        $values .= "(
                  '$service_name_sql',
                  '$service_price_sql',
                  '$service_count_sql',
                  'S',
                  '$doc_id'
              )";
                    }
                }
            }
            $sorov = $sorov.$values;
            $result = $func->queryMysql($sorov);
//            var_dump($QR_ID);
            if (!empty($result)){
            }else{
                echo $reg_date;
            }
        }
    }
    if($user_name!="def"){
        $buyer_id=$user_name;
    }else{
        $buyer_id = $user_id;
            if($buyer_id!=NULL){
                var_dump($buyer_id);
            }
    }
    $sorov = "select * from buyers WHERE buyers_id='".$buyer_id."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    $comp_name = $row['buyers_name'];
    if(empty($comp_name)){
        $comp_name = " ________________________________________ ";
    }
//    var_dump($comp_name);
//    var_dump($buyer_id);
//    ENDING CODE FOR INSERTING
//////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////frameworks//////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////
    $document_with_table = new PhpOffice\PhpWord\PhpWord();
    $section = $document_with_table->addSection();
    $table = $section->addTable('table', [
        'borderSize' => 6,
        'borderColor' => 'F73605',
        'afterSpacing' => 0,
        'Spacing' => 0,
        'cellMargin' => 0
    ]);
    if(!empty($service_name)){
        for ($r = 1; $r <= count($service_name)+1; $r++) {
            $table->addRow();
            for ($c = 1; $c <= 4; $c++) {
                $id=$r-1;
                if ($r == 1 && $c == 1) {
                    $table->addCell(2000, [
                        'borderSize' => 6
                    ])->addText("№", [
                        'name' => 'Arial',
                        'size' => '14',
                        'color' => '000000',
                        'width' => '25%',
                        'bold' => true,
                        'italic' => false
                    ]);
                } elseif ($r == 1 && $c == 2) {
                    $table->addCell(2500, [
                        'borderSize' => 6
                    ])->addText("Наименование услуги", [
                        'name' => 'Arial',
                        'size' => '14',
                        'color' => '000000',
                        'width' => '25%',
                        'bold' => true,
                        'italic' => false
                    ]);
                } elseif ($r == 1 && $c == 3) {
                    $table->addCell(2500, [
                        'borderSize' => 6
                    ])->addText("Количество", [
                        'name' => 'Arial',
                        'size' => '14',
                        'color' => '000000',
                        'width' => '25%',
                        'bold' => true,
                        'italic' => false
                    ]);
                } elseif ($r == 1 && $c == 4) {
                    $table->addCell(2500, [
                        'borderSize' => 6
                    ])->addText("ЦЕНА", [
                        'name' => 'Arial',
                        'size' => '14',
                        'color' => '000000',
                        'width' => '25%',
                        'bold' => true,
                        'italic' => false
                    ]);
                } else {
                    if ($c == 1){
                        $table->addCell(2500, [
                            'borderSize' => 6
                        ])->addText("$id", [
                            'name' => 'Arial',
                            'size' => '12',
                            'color' => '000000',
                            'bold' => false,
                            'italic' => false
                        ]);
                    }elseif($c== 2){
                        $table->addCell(2500, [
                            'borderSize' => 6
                        ])->addText($service_name[$r-2], [
                            'name' => 'Arial',
                            'size' => '12',
                            'color' => '000000',
                            'bold' => false,
                            'italic' => false
                        ]);
                    }elseif($c== 3){
                        $table->addCell(2500, [
                            'borderSize' => 6
                        ])->addText($service_count[$r-2], [
                            'name' => 'Arial',
                            'size' => '12',
                            'color' => '000000',
                            'bold' => false,
                            'italic' => false
                        ]);
                    }elseif($c== 4){
                        $table->addCell(2500, [
                            'borderSize' => 6
                        ])->addText($service_price[$r-2], [
                            'name' => 'Arial',
                            'size' => '12',
                            'color' => '000000',
                            'bold' => false,
                            'italic' => false
                        ]);
                    }
                }
            }
        }
    }
// Create writer to convert document to xml
    $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($document_with_table, 'Word2007');

// Get all document xml code
    $fullxml = $objWriter->getWriterPart('Document')->write();

// Get only table xml code
    $tablexml = preg_replace('/^[\s\S]*(<w:tbl\b.*<\/w:tbl>).*/', '$1', $fullxml);

//Open template with ${table}
    $template_document = new \PhpOffice\PhpWord\TemplateProcessor('resource/service_original_doc.docx');
    $today=date("Y-m-d");
// Replace mark by xml code of table
$template_document->setValue('TABLE', $tablexml);
//SetValue into doc ${value}
$template_document->setValue('DOC_ID', $doc_id);
    $template_document->setValue('TODAY_DATE', $today);
    $template_document->setValue('DATE', $check_date);
    $template_document->setValue('COMP_NAME', $comp_name);
    $template_document->setValue('PRICE', $service_total);
//save template with table
//    $reg_date_to_save = date("Y-m-d:H-i-s");
    $template_document->saveAs('created/contract_comp_'.$reg_date.'.docx');

    }
}