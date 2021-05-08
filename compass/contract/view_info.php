<?
include_once("../../DB/functions.php");
$func = new database_func();
if(!empty($_GET['ID']) && isset($_GET['ID'])){
    $id = $_GET['ID'];
    $url = $_GET['url'];
    $sorov = "select * from new_contract WHERE nc_id='".$id."'";
    $func->queryMysql($sorov);
    $InfoContract = $func->result->fetch_array(MYSQL_ASSOC);
    $company = $InfoContract['company'];
    $total = $InfoContract['product_total']+$InfoContract['service_total'];
    $buyer_id = $InfoContract['buyer_id'];
    $sorov = "select * from buyers WHERE buyers_id='".$buyer_id."'";
    $func->queryMysql($sorov);
    $row = $func->result->fetch_array(MYSQL_ASSOC);
    $buyer_name = $row['buyers_name'];
    $sorov = "select * from new_contract_datails WHERE nc_id='".$id."'";
    $func->queryMysql($sorov);
    $num=0;
    while($InfoProduct = $func->result->fetch_array(MYSQL_ASSOC)){
        $service_name[$num] = $InfoProduct['sp_name'];
        $service_count[$num] = $InfoProduct['sp_count'];
        $service_price[$num] = $InfoProduct['sp_price'];
        $num++;
    }
    ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <style>
        body{
            background: #CDCDCD;
            margin: 0px;
            padding: 0px;
        }
        .container{
            background: white;
            width: 900px;
            border: 1px #ccc solid;
            margin: 0px auto 20px;
            padding-left: 70px;
            padding-right: 70px;
            padding-top: 20px;
            padding-bottom: 100px;
        }
        .center{
            text-align: center;
        }
        p{
            font-size: 20px;
            text-align: justify;
            margin-top: 0px;
            margin-bottom: 0px;
        }
        u{
            margin-top: 0px;
            display: block;
            font-size: 20px;
            font-weight: 900;
        }
        strong{
            font-size: 20px;
        }
        h2{
            margin: 0px;
        }
        div.menu{
            background: #E7E7E7;
            text-align: center;
            padding: 10px 50px;
            top:0px;
            left: 50%;
            position:sticky;
            width: 100%;
            box-sizing: border-box;
            margin-bottom: 20px;
        }
        div.menu a{
            text-decoration: none;
            display: inline-block;
            color: white;
            padding: 14px 16px;
            background: #6600FF;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <div class="menu">
        <a href="#" onclick="download1()">Yuklab olish</a>
        <input type="hidden" value="<? echo $url; ?>" id="url">
        <textarea style="display: none;" id="hidden" cols="30" rows="10"><? echo $_POST['values']; ?></textarea>
    </div>
    <div class="container" style="border-top: none;padding-top: 100px;height: 1000px">
        <h2 class="center">ДОГОВОР  № <span id="doc_nomer"><? echo $_GET['ID'] ?></span></h2>
        <p class="center" style="font-size: 18px;">на оказание услуги по техническому обслуживанию и ремонту оргтехники</p>
        <div style="display: flex;justify-content: space-between;padding-top: 20px;padding-bottom: 20px;"><div>г.Навои</div> <div> <span id="doc_date"><? echo $InfoContract['check_date']; ?></span> г.</div></div>
        <p style="text-indent: 100px;">
            Общество с ограниченной ответственностью
            <strong id="doc_comp_name" style="text-transform: capitalize;"><? echo $company; ?> </strong>(здесь и далее именуемый «ИСПОЛНИТЕЛЬ»),
            в лице директора <strong>Г. О. Авезова</strong>  с одной стороны, и <strong id="doc_user_name"><? echo $buyer_name; ?></strong> в лице _____________________
            (здесь и далее именуемый «ЗАКАЗЧИК»), с другой стороны,
            заключили настоящий ДОГОВОР о нижеследующем:
        </p>
        <u>1. Предмет договора </u>
        <p>1.1. Заказчик поручает, а И0441полнитель  оказывает услуги по техническому обслуживанию и ремонту оргтехники.</p>
        <u>2.  Права и обязанности Сторон</u>
        <strong>Заказчик обязуется:</strong>
        <p>2.1. Заказчик обязуется оплатить расходы, связанные с проведением услуг на основании статьи 4 настоящего договора.</p>
        <strong>Исполнитель обязуется: </strong>
        <p>2.2. Исполнитель обязуется выполнять работы качественно, не нарушая срок выполнения работ</p>
        <u> 3. Срок выполнения работ</u>
        <p>3.1. Срок выполнения работ  по соглосование стороны.</p>
        <u>4.Стоимость работы и порядок расчетов</u>
        <p>
        4.1.Сумма договора составляет   <span id="doc_summa"><? echo $total; ?></span> <strong>сумов</strong>.
         <span style="display: block;margin-left: 650px;font-weight: 100;font-size: 16px;">сумма прописью</span>
        4.2. Стоимость услуг по ремонту оргтехники, заправке и восстановлению картриджей
            перечислена в <strong>Приложении №1</strong> к настоящему Договору.
            <br/>4.3. Оплата оказанных услуги производится Заказчиком на основании счета, предъявленного Исполнителем, и акта выполненных работ, подписанного сторонами, в течение 3 (трех) рабочих дней с момента подписания акта выполненных работ путем перечисления денежных средств на расчетный счет Исполнителя.
            <br/>4.4. В случае изменения стоимости обслуживания оборудования Исполнитель обязан предупредить об этом Заказчика не позднее, чем за 14 (четырнадцать) календарных дней до момента предполагаемого изменения.
        </p>
        <u>5. Материальная ответственность сторон</u>
        <p>5.1. Если в ходе выполнения своих обязательств по настоящему Договору одной из Сторон были получены сведения, являющиеся коммерческой тайной другой стороны, то получившая такую информацию Сторона не вправе сообщать ее третьим лицам без согласия другой Стороны.
            <br/>5.2.  Все споры, возникающие между Сторонами при исполнении настоящего Договора, разрешаются путем переговоров, а в случае не достижения согласия между Сторонами спор передается на рассмотрение суда, согласно подведомственности и подсудности, установленным законодательством Узбекистана.
            <br/>5.3. Все изменения, не оговоренные в п.1.1 настоящего договора оговаривается и оплачивается отдельным договором.
        </p>
    </div>
    <div class="container" style="padding-top:100px;height: 1000px;">
        <u>6. Форс-мажор</u>
        <p>6.1. При невозможности полного или частичного выполнения любой из Сторон обязательств по настоящему Договору вследствие обстоятельств форс-мажора срок исполнения обязательств отодвигается на период времени, в течение которого будут действовать такие обстоятельства.</p>
        <u>7. Прочие условия</u>
        <p>7.1. Настоящий Договор вступает в силу с момента его подписания Сторонами и действует до полного выполнения обязательств.
            <br>7.2. Каждая из Сторон может в любое время отказаться от исполнения настоящего Договора, предварительно уведомив другую Сторону не позднее, чем за три дня до даты расторжения. В этом случае Стороны производят все взаимные расчеты, в  том числе, за фактически выполненные к этому моменту услуги.
            <br>7.3. Все Приложения, дополнения и изменения к настоящему Договору действительны в том случае, если они составлены в письменной форме и подписаны обеими Сторонами и являются его неотъемлемыми частями.
            <br>7.4. Вопросы, не урегулированные настоящим Договором, регулируются действующим законодательством Узбекистана.
            <br>7.5. Настоящий Договор составлен в 2-х экземплярах по одному для каждой из Сторон. Оба экземпляра имеют одинаковую юридическую силу.
        </p>
        <u style="font-size: 18px;">8. Юридические адреса, платежные реквизиты сторон.</u>
        <table border="1" style="border-collapse: collapse; width: 100%;margin-top: 10px;">
            <tr>
                <td style="width: 50%">
                    <div style="padding-left: 20px;padding-right: 20px;" id="doc_type_name">
                        <h4 class="center" style="margin-top: 0px;">ИСПОЛНИТЕЛЬ</h4>
                        <h3 class="center" style="margin-top: -10px;margin-bottom: 10px;">ООО «COMPASS GROUP»</h3>
                        <p style="margin-top: -10px;">Почтовые реквизиты: 210100, г. Навои,
                            <br/>ул. Нурафшон 5А
                            <br/>Тел:(+99890) 618-98-88
                            <br/>Банковские реквизиты: Узнацбанк, г. Навои
                            <br/>код банка:  00196  ИНН:  303080310
                            <br/>ОКОНХ 84500
                            <br/>р/с:20208-000-9-00400610-001
                        </p>
                        <p style="margin: 50px 0px 50px 20px;">_________________________ Авезов Г.О.</p>
                        <p style="margin-left: 20px;">М.П.</p>
                    </div>
                </td>
                <td style="width: 50%">
                    <div style="padding-left: 20px;padding-right: 20px;">
                        <h4 class="center" style="margin-top: 0px;">ИСПОЛНИТЕЛЬ</h4>
                        <p style="margin-top: -15px;">__________________________________________
                            <br/>Почтовые реквизиты: _____________________
                            <br/>________________________________________
                            <br/>________________________________________
                            <br/>________________________________________
                            <br/>________________________________________
                            <br/>________________________________________
                            <br/>________________________________________
                        </p>
                        <br/>
                        <br/>
                        <p style="margin-left: 35px;margin-top: 10px;">_____________________ _______________</p>
                        <p style="margin-left: 20px;margin-top: 50px">М.П.</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>
    <div class="container" style="padding-top:80px;height: 1000px">
        <h3 class="center">ПРИЛОЖЕНИЕ №1 К ДОГОВОРУ № <span id="doc_nomer_1"><? echo $doc_id; ?></span> от <span id="doc_date_1"><? echo $check_date; ?></span>г.</h3>
        <table border="1" style="border-collapse: collapse;width: 100%">
            <tr>
                <th style="padding: 20px;text-align: center;font-size: 20px;">№</th>
                <th style="padding: 20px;text-align: center;font-size: 20px;">Наименование услуги</th>
                <th style="padding: 20px;text-align: center;font-size: 20px;">Количество</th>
                <th style="padding: 20px;text-align: center;font-size: 20px;">ЦЕНА</th>
            </tr>
            <?
                for($i=0;$i<count($service_name);$i++){
            ?>
            <tr>
                <td style="padding: 10px;text-align: center;font-size: 20px;"><? echo $i+1; ?></td>
                <td style="padding: 10px;text-align: center;font-size: 20px;"><? echo $service_name[$i]; ?></td>
                <td style="padding: 10px;text-align: center;font-size: 20px;"><? echo $service_count[$i]; ?></td>
                <td style="padding: 10px;text-align: center;font-size: 20px;"><? echo $service_count[$i]*$service_price[$i]; ?></td>
            </tr>
            <?}?>
        </table>
        <div style="display: flex;justify-content: space-between;font-weight: 900;margin-top: 50px;">
            <div>ИСПОЛНИТЕЛЬ________________ </div>
            <div>ЗАКАЗЧИК________________</div>
        </div>
        <div style="display: flex;justify-content: space-between;font-weight: 900;margin-top: 50px;text-align: center;">
            <div style="width: 200px; ">М . П .</div>
            <div style="width: 215px;">М . П .</div>
        </div>
    </div>
    <script src="../assets/js/jquery-1.11.3.min.js"></script>

    <script>
            function download1(){
                var id = document.getElementById("url").value;
//                alert(id);
                window.open('/compass/contract/created/contract_comp_' + id + '.docx', '_blank');
                window.close();
            }
    </script>
</body>
</html>
<?}?>