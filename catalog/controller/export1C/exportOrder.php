<?php
class ControllerExport1CExportOrder extends Controller {

	public function index() {
		
	}
	public function exportOrder($mydata){
		$this->load->model('extension/module/Import1C');
		
		date_default_timezone_set( 'Europe/Moscow' );
       
        $pwd = $this->request->server['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'Exchange1C'.DIRECTORY_SEPARATOR.'order'.DIRECTORY_SEPARATOR;
        $file_path = $pwd.'order'.$mydata['order_id'].'.xml';
        fopen($file_path, "w");
        
        $dateforxml = $mydata['date']."T".$mydata['time'];
        
        $content = '<?xml version="1.0" encoding="UTF-8"?>
        <КоммерческаяИнформация xmlns="urn:1C.ru:commerceml_2" xmlns:xs="http://www.w3.org/2001/XMLSchema" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" ВерсияСхемы="2.09" ДатаФормирования="'. $dateforxml.'" Ид="1">
		<Контейнер>
        <Документ>
		</Документ>
        </Контейнер>
        </КоммерческаяИнформация>';
        file_put_contents($file_path, $content);
        
        $xml = simplexml_load_file($file_path);
        
        $xml->Контейнер->Документ->addChild('Ид', $mydata['order_id']); 
        $xml->Контейнер->Документ->addChild('НомерВерсии', ' ');
        $xml->Контейнер->Документ->addChild('ПометкаУдаления', 'false');
        $xml->Контейнер->Документ->addChild('Номер', $mydata['order_id']);
        $xml->Контейнер->Документ->addChild('Номер1С', '');
        $xml->Контейнер->Документ->addChild('Дата', $mydata['date']);
        $xml->Контейнер->Документ->addChild('Дата1С', '');
        $xml->Контейнер->Документ->addChild('Время', $mydata['time']);
        $xml->Контейнер->Документ->addChild('ХозОперация', 'Заказ товара');
      
        $xml->Контейнер->Документ->addChild('Контрагенты', ' ');
        $xml->Контейнер->Документ->Контрагенты->addChild('Контрагент', '');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Ид', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('НомерВерсии', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('ПометкаУдаления', 'false');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Наименование', $mydata['firstname'] . ' ' . $mydata['lastname']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('ПолноеНаименование', $mydata['firstname'] . ' ' . $mydata['lastname']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Роль', 'Покупатель');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('ИНН', '');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('КПП', '');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('КодПоОКПО', '');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Представители', '');
       
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Адрес', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->addChild('Представление', $mydata['country'] . ', ' . $mydata['zone'] . ', ' . $mydata['city'] . ', ' . $mydata['address']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[0]->addChild('Тип', 'Страна');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[0]->addChild('Значение', $mydata['country']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[1]->addChild('Тип', 'Регион');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[1]->addChild('Значение', $mydata['zone']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[2]->addChild('Тип', 'Город');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Адрес->АдресноеПоле[2]->addChild('Значение', $mydata['city']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('АдресРегистрации', ' '); 
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->addChild('Представление', $mydata['country'] . ', ' . $mydata['zone'] . ', ' . $mydata['city'] . ', ' . $mydata['address']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[0]->addChild('Тип', 'Страна');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[0]->addChild('Значение', $mydata['country']);
		$xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[1]->addChild('Тип', 'Регион');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[1]->addChild('Значение', $mydata['zone']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->addChild('АдресноеПоле', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[2]->addChild('Тип', 'Город');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->АдресРегистрации->АдресноеПоле[2]->addChild('Значение', $mydata['city']);
       
        $xml->Контейнер->Документ->Контрагенты->Контрагент->addChild('Контакты', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->addChild('Контакт', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->Контакт->addChild('Тип', 'Телефон рабочий');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->Контакт->addChild('Значение', $mydata['telephone']);
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->addChild('Контакт', ' ');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->Контакт[1]->addChild('Тип', 'Электронная почта');
        $xml->Контейнер->Документ->Контрагенты->Контрагент->Контакты->Контакт[1]->addChild('Значение', $mydata['email']);
        
        $xml->Контейнер->Документ->addChild('Склады', ' ');
        $xml->Контейнер->Документ->Склады->addChild('Склад', ' ');
        $xml->Контейнер->Документ->Склады->Склад->addChild('Ид', '');
        $xml->Контейнер->Документ->Склады->Склад->addChild('Наименование', 'Основной склад');
       
        $xml->Контейнер->Документ->addChild('Валюта', 'RUB');
        $xml->Контейнер->Документ->addChild('Курс', '1.0000');
        $xml->Контейнер->Документ->addChild('Сумма', $mydata['total']);
        $xml->Контейнер->Документ->addChild('Роль', 'Покупатель');
        $xml->Контейнер->Документ->addChild('Комментарий', '');
        
        $summa_nds = (int)$mydata['total'];
        $summa_nds = $summa_nds*18/118;
        $summa_nds = round($summa_nds, 1);
        $xml->Контейнер->Документ->addChild('Налоги', ' ');
        $xml->Контейнер->Документ->Налоги->addChild('Налог', ' ');
        $xml->Контейнер->Документ->Налоги->Налог->addChild('Наименование', 'НДС');
        $xml->Контейнер->Документ->Налоги->Налог->addChild('УчтеноВСумме', 'true');
        $xml->Контейнер->Документ->Налоги->Налог->addChild('Сумма', $summa_nds);
        
        $xml->Контейнер->Документ->addChild('ЗначенияРеквизитов', ' ');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита->addChild('Наименование', 'ПометкаУдаления');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита->addChild('Значение', 'false');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Наименование', 'Проведен');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Значение', 'true');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита[2]->addChild('Наименование', 'Статуса заказа ИД');
        $xml->Контейнер->Документ->ЗначенияРеквизитов->ЗначениеРеквизита[2]->addChild('Значение', 'N');
        $xml->Контейнер->Документ->addChild('Товары', ' '); 
        $i = 0;
        
        foreach ($mydata['products'] as $product){
            
               $product_data = $this->model_extension_module_Import1C->get1CProductId($mydata['order_id'], $product['order_product_id'], $product['product_id'], $product['price']);

               $xml->Контейнер->Документ->Товары->addChild('Товар', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Ид', $product_data['id']);
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Наименование', $product_data['name']);
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('СтавкиНалогов', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->addChild('СтавкаНалога', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->СтавкаНалога->addChild('Наименование', 'НДС');
               $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->СтавкаНалога->addChild('Ставка', '18');
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('ЗначенияРеквизитов', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[0]->addChild('Наименование', 'ВидНоменклатуры');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[0]->addChild('Значение', 'Товар упаковками');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Наименование', 'ТипНоменклатуры');
               $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Значение', 'Товар');
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Единица', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('Ид', '796');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('НаименованиеКраткое', 'шт');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('Код', '796');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('НаименованиеПолное', 'Штука');
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Коэффициент', '1');
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Количество', $product['quantity']);
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Цена', $product_data['price']);
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Сумма', $product_data['price']*$product['quantity']);
               $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Налоги', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->addChild('Налог', ' ');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Наименование', 'НДС');
               $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('УчтеноВСумме', 'true');
               $sum_nds = (int)$product['total'];
               $sum_nds = $sum_nds*18/118;
               $sum_nds = round($sum_nds, 1);
               $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Сумма', $sum_nds);
               $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Ставка', '18');


               if($product_data['special']){
				   
				   $sale = $product['price'] - $product_data['price'];
				   
				   $percent = (1 - $product['price'] / $product_data['price']) * 100;
				   
                   $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Скидки', ' ');
                   $xml->Контейнер->Документ->Товары->Товар[$i]->Скидки->addChild('Скидка', ' ');
                   $xml->Контейнер->Документ->Товары->Товар[$i]->Скидки->Скидка->addChild('Наименование', $product_data['special']);
                   $xml->Контейнер->Документ->Товары->Товар[$i]->Скидки->Скидка->addChild('Сумма', $sale);
                   $xml->Контейнер->Документ->Товары->Товар[$i]->Скидки->Скидка->addChild('Процент', $percent);
                   $xml->Контейнер->Документ->Товары->Товар[$i]->Скидки->Скидка->addChild('УчтеноВСумме', 'true');
               }
              
               $i++; 
            
        }
        
        $delivery_data = $this->model_extension_module_Import1C->getDeliveryInfo($mydata['order_id']);
        
        $xml->Контейнер->Документ->Товары->addChild('Товар', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Ид', '77223422-41b8-11e6-81ba-14dae9e311d7');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Наименование', 'Доставка');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('СтавкиНалогов', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->addChild('СтавкаНалога', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->СтавкаНалога->addChild('Наименование', 'НДС');
        $xml->Контейнер->Документ->Товары->Товар[$i]->СтавкиНалогов->СтавкаНалога->addChild('Ставка', '18');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('ЗначенияРеквизитов', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[0]->addChild('Наименование', 'ВидНоменклатуры');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[0]->addChild('Значение', 'Товар упаковками');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->addChild('ЗначениеРеквизита', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Наименование', 'ТипНоменклатуры');
        $xml->Контейнер->Документ->Товары->Товар[$i]->ЗначенияРеквизитов->ЗначениеРеквизита[1]->addChild('Значение', 'Товар');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Единица', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('Ид', '796');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('НаименованиеКраткое', 'шт');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('Код', '796');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Единица->addChild('НаименованиеПолное', 'Штука');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Коэффициент', '1');
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Количество', 1);
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Цена', round($delivery_data['value'],0));
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Сумма', round($delivery_data['value'],0));
        $xml->Контейнер->Документ->Товары->Товар[$i]->addChild('Налоги', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->addChild('Налог', ' ');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Наименование', 'НДС');
        $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('УчтеноВСумме', 'true');     
        $sum_nds = (int)$delivery_data['value'];
        $sum_nds = $sum_nds*18/118;
        $sum_nds = round($sum_nds, 1);
        $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Сумма', $sum_nds);
        $xml->Контейнер->Документ->Товары->Товар[$i]->Налоги->Налог->addChild('Ставка', '18');    
                  
        //> Форматирование
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        //<//
        file_put_contents($file_path, $dom->saveXML());

    }
    public function exportPayOrder($mydata){
        date_default_timezone_set( 'Europe/Moscow' );
        $pwd = DIR_UPLOAD.'status_pay'.DIRECTORY_SEPARATOR;
        $file_path = $pwd.'order'.$mydata['order-number'].'.xml';
        fopen($file_path, "w");
        $content = '<?xml version="1.0" encoding="UTF-8"?>
        <xml><Order>
        </Order>
        </xml>';
        file_put_contents($file_path, $content);
        
        $xml = simplexml_load_file($file_path);
        
        $xml->Order->addChild('Order-number', $mydata['order-number']);
        $xml->Order->addChild('online-pay', $mydata['online-pay']);
        $xml->Order->addChild('intellect-mony-invoice', $mydata['intellect-mony-invoice']);
        $xml->Order->addChild('payMethod', $mydata['payMethod']);
        //> Форматирование
        $dom = new DOMDocument("1.0");
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;
        $dom->loadXML($xml->asXML());
        //<//
        file_put_contents($file_path, $dom->saveXML());

    }

}
?>
