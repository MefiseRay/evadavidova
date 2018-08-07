<?php

include('TinkoffMerchantAPI.php');

class ModelExtensionPaymentTinkoff extends Model
{
    public function getMethod($address, $total)
    {
        $this->language->load('extension/payment/tinkoff');
        return array(
            'code' => 'tinkoff',
            'terms' => "",
            'title' => $this->language->get('text_title'),
            'sort_order' => $this->config->get('sagepay_us_sort_order')
        );
    }

    /**
     * After calling initPayment()
     */
    const STATUS_NEW = 'NEW';

    /**
     * After calling cancelPayment()
     * Not Implemented here
     */
    const STATUS_CANCELED = 'CANCELED';

    /**
     * Intermediate status (transaction is in process)
     */
    const STATUS_PREAUTHORIZING = 'PREAUTHORIZING';

    /**
     * After showing payment form to the customer
     */
    const STATUS_FORMSHOWED = 'FORMSHOWED';

    /**
     * Intermediate status (transaction is in process)
     */
    const STATUS_AUTHORIZING = 'AUTHORIZING';

    /**
     * Intermediate status (transaction is in process)
     * Customer went to 3DS
     */
    const STATUS_THREEDSCHECKING = 'THREEDSCHECKING';

    /**
     * Payment rejected on 3DS
     */
    const STATUS_REJECTED = 'REJECTED';

    /**
     * Payment compete, money holded
     */
    const STATUS_AUTHORIZED = 'AUTHORIZED';

    /**
     * After calling reversePayment
     * Charge money back to customer
     * Not Implemented here
     */
    const STATUS_REVERSING = 'REVERSING';

    /**
     * Money charged back, transaction cmplete
     */
    const STATUS_REVERSED = 'REVERSED';

    /**
     * After calling confirmePayment()
     * Confirm money wright-off
     * Not Implemented here
     */
    const STATUS_CONFIRMING = 'CONFIRMING';

    /**
     * Money written off
     */
    const STATUS_CONFIRMED = 'CONFIRMED';

    /**
     * After calling refundPayment()
     * Retrive money back to customer
     * Not Implemented here
     */
    const STATUS_REFUNDING = 'REFUNDING';

    /**
     * Money is back on the customer account
     */
    const STATUS_REFUNDED = 'REFUNDED';

    const STATUS_UNKNOWN = 'UNKNOWN';

    /**
     * Terminal id, bank give it to you
     * @var int
     */
    private $terminalId;

    public $taxation;

    /**
     * Secret key, bank give it to you
     * @var string
     */
    private $secret;

    /**
     * Read API documentation
     * @var string
     */
    private $paymentUrl;

    /**
     * Current payment status
     * @var string
     */
    private $paymentStatus;

    /**
     * Payment id in bank system
     * @var int
     */
    private $paymentId;

    /**
     * Валята заказа (643 - рубли)
     * @var int
     */
    private $currency = 643;

    public function __construct($registry)
    {
        parent::__construct($registry);

        $this->terminalId = $this->config->get('tinkoff_terminal_key');
        $this->secret = $this->config->get('tinkoff_secret_key');
        $url = $this->config->get('tinkoff_payment_url');
        $this->taxation = $this->config->get('tinkoff_taxation');
        $this->enabled_taxation = $this->config->get('tinkoff_enabled_taxation');

        if ($url[strlen($url) - 1] === '/') {
            $this->paymentUrl = substr($url, 0, -1);
        } else {
            $this->paymentUrl = $url;
        }
        $this->currency = $this->config->get('currency');
    }

    function getTaxClassNameById($tax_class_id)
    {
        $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "tax_class WHERE tax_class_id = '" . (int)$tax_class_id . "'");

        return $query->row;
    }

    /**
     * Return payment link for user redirection and params for it
     *
     * @param array $params
     * @return array
     * @throws TinkoffException
     */
    public function initPayment(array $params)
    {
        $customerEmail = $this->customer->getEmail();
        $userEmail = $customerEmail ? $customerEmail : $this->cart->session->data['guest']['email'];

        $requestParams = array(
            'TerminalKey' => $this->terminalId,
            'Amount' => $params['amount'],
            'OrderId' => $params['orderId'],
            'DATA' => array(
                'Email' => $userEmail,
                'Connection_type' => 'opencart2.3_atol',
            ),
        );

        if ($this->enabled_taxation) {
            $requestParams['Receipt'] = $this->getReceipt($params, $userEmail);
        }

        $tinkoffModel = new TinkoffMerchantAPI($this->terminalId, $this->secret, $this->paymentUrl);
        $request = $tinkoffModel->buildQuery('Init', $requestParams);
        $result = json_decode($request);

        //log
        $log = '[' . date('D M d H:i:s Y', time()) . '] ' . $request . "\r\n";
        file_put_contents(dirname(__FILE__) . "/tinkoff_log.log", $log, FILE_APPEND);

        if (!isset($result->PaymentURL)) {
            die('Не удалось соединиться с платёжным сервисом');
        }

        if ($result->ErrorCode == 8) {
            $log = '[' . date('D M d H:i:s Y', time()) . '] ' . "\r\n" . "ErrorCode=8" . "\r\n" . $result['Details'] . "\r\n";
            file_put_contents(dirname(__FILE__) . 'tinkoff_log.log', $log, FILE_APPEND);
            die($result['Details']);
        }

        $this->isRequestSuccess($result->Success);
        $this->paymentStatus = $result->Status;
        $this->paymentId = $result->PaymentId;
        $this->saveOrder($result->OrderId);

        return array(
            'url' => $result->PaymentURL,
            'params' => array(),
        );
    }

    /**
     * @param array $params
     * @param $email
     * @return array
     */
    function getReceipt(array $params, $email)
    {
        $receiptItems = array();
        $errorTaxMessage = 'Не удается оплатить заказ. Обратитесь к администратору для проверки настроек налога';
        $session = $this->cart->session->data;
        $shipping = $session['shipping_method'];
        $prices = $this->getNormalizePrices($params['amount'], $this->cart->getProducts(), $this->hasShipping() ? $shipping : null);

        //add products data and vat to $receiptItems
        foreach ($this->cart->getProducts() as $product) {
            $vat = $this->getVat($product['price'], $product['tax_class_id']);
            $productPrices = $prices['products'];
            $id = $product['product_id'];

            if (!$vat) {
                die($errorTaxMessage);
            }

            $receiptItems[] = array(
                'Name' => $product['name'],
                'Price' => $productPrices[$id],
                'Quantity' => $product['quantity'],
                'Amount' => $productPrices[$id] * $product['quantity'],
                'Tax' => $vat,
            );
        }

        //add shipping vat to $receiptItems
        if ($shipping && $session['shipping_method']['cost']) {
            $shippingVat = $this->getVat($shipping['cost'], $shipping['tax_class_id']);

            if (!$shippingVat) {
                die($errorTaxMessage);
            }

            if ($prices['shipping']) {
                $receiptItems[] = array(
                    'Name' => $shipping['title'],
                    'Price' => $prices['shipping'],
                    'Quantity' => 1,
                    'Amount' => $prices['shipping'],
                    'Tax' => $shippingVat,
                );
            }
        }

        if (!$this->taxation) {
            die($errorTaxMessage);
        }

        $requestParams = array(
            "Email" => $email,
            "Taxation" => $this->taxation,
            'Items' => $receiptItems,
        );

        return $requestParams;
    }

    /**
     * есть ли небесплатная доставка у заказа
     * @return bool
     */
    function hasShipping()
    {
        return $this->cart->session->data['shipping_method'] && $this->cart->session->data['shipping_method']['cost'];
    }

    /**
     * @param $amount
     * @param $products
     * @param $shipping
     * @return array
     */
    function getNormalizePrices($amount, $products, $shipping)
    {
        $prices = array();
        $realAmount = $this->getRealAmount() * 100;
        $k = ($realAmount != $amount) ? $amount / $realAmount : 1;
        $newRealAmount = 0;

        foreach ($products as $product) {
            $id = $product['product_id'];
            $price = $this->getRoundTaxPrice($product['price'], $product['tax_class_id'], $k);
            $prices['products'][$id] = $price;
            $newRealAmount += $price * $product['quantity'];
        }

        $shippingPrice = $this->getRoundTaxPrice($shipping['cost'], $shipping['tax_class_id'], $k);
        $newRealAmount = $newRealAmount + $shippingPrice;
        $diff = $amount - $newRealAmount;

        if (abs($diff) >= 0.1) {
            $shippingPrice = $shippingPrice + $diff;
        }

        $prices['shipping'] = $shippingPrice;

        return $prices;
    }

    /**
     * цена с ндс в копейках
     * @param $price
     * @param $taxClassId
     * normalize coefficient @param $k
     * @return float
     */
    function getRoundTaxPrice($price, $taxClassId, $k)
    {
        //сумма в копейках
        return round($this->getVatPrice($price, $taxClassId) * $k, 2) * 100;
    }

    /**
     * сумма позиций в цеке (всех товаров и доставки)
     * @return int
     */
    function getRealAmount()
    {
        $realAmount = 0;

        foreach ($this->cart->getProducts() as $product) {
            $price = $this->getVatPrice($product['price'], $product['tax_class_id']);
            $realAmount += $price * $product['quantity'];
        }

        if ($shippingData = $this->cart->session->data['shipping_method']) {
            $shippingPrice = $this->getVatPrice($shippingData['cost'], $shippingData['tax_class_id']);
            $realAmount += $shippingPrice;
        }

        return $realAmount;
    }

    /**
     * цену с учетом ндс
     * @param $price
     * @param $vat
     * @return mixed
     */
    public function getVatPrice($price, $vat)
    {
        return $this->cart->tax->calculate($price, $vat, true);
    }

    /**
     * ндс формата отправки в ТКС
     * @param $price
     * @param $taxClassId
     * @return bool|string
     */
    public function getVat($price, $taxClassId)
    {
        if (!$taxClassId) {
            return 'none';
        } else {
            $taxClassRates = $this->tax->getRates($price, $taxClassId);

            if (count($taxClassRates) > 1) {
                return false;
            }

            $rate = array_shift($taxClassRates);

            if ($rate['type'] != 'P') {
                return false;
            }

            switch ($rate['rate']) {
                case 0:
                    return 'vat0';
                    break;
                case 10:
                    return 'vat10';
                    break;
                case 18:
                    return 'vat18';
                    break;
                default:
                    return false;
                    break;
            }
        }
    }

    /**
     * Check if order is complete and money paid
     *
     * @return bool
     * @throws TinkoffException
     */
    public function isOrderPaid()
    {
        $this->checkStatus();

        return in_array($this->paymentStatus, array(self::STATUS_CONFIRMED, self::STATUS_AUTHORIZED));
    }

    /**
     * Checks if oreder is failed
     *
     * @return bool
     */
    public function isOrderFailed()
    {
        return in_array($this->paymentStatus, array(self::STATUS_CANCELED, self::STATUS_REJECTED, self::STATUS_REVERSED));
    }

    public function saveOrder($orderId)
    {
        $date = new \DateTime();

        $currentDate = $date->format('Y-m-d h:i:s');

        $orders = $this->db->query("
          SELECT `id`
          FROM " . DB_PREFIX . "tinkoff_payments
          WHERE `order_id` = '" . (int)$orderId . "'");

        if ($orders->num_rows > 0) {
            $this->db->query("
			    UPDATE " . DB_PREFIX . "tinkoff_payments
			    SET payment_id = '" . $this->paymentId . "',
				    updated = '" . $currentDate . "',
				    status = '" . $this->paymentStatus . "'
			    WHERE order_id = " . (int)$orderId
            );

            return true;
        }

        $this->db->query("
            INSERT INTO `" . DB_PREFIX . "tinkoff_payments`
            SET order_id = '" . (int)$orderId . "',
			    payment_id = '" . $this->paymentId . "',
			    created = '" . $currentDate . "',
				updated = '" . $currentDate . "',
				status = '" . $this->paymentStatus . "'
        ");

        return true;
    }

    /**
     * Check is status variable is set
     *
     * @throws TinkoffException
     */
    private function checkStatus()
    {
        if (is_null($this->paymentStatus)) {
            $log = '[' . date('D M d H:i:s Y', time()) . '] ';
            $log .= "\r\n";
            $log .= "Статус заказа не определён. Чтобы запросить статус вызовите метод getStatus";
            $log .= "\r\n";
            file_put_contents(dirname(__FILE__) . "/tinkoff_log.log", $log, FILE_APPEND);
            throw new TinkoffException(sprintf('Статус заказа не определён. Чтобы запросить статус вызовите метод getStatus'));
        }

    }

    /**
     * Check bank response format
     *
     * @param $string
     * @return bool
     */
    private function isJson($string)
    {
        json_decode($string);

        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * Generates request signature
     *
     * @param array $params
     * @return string
     */
    private function generateToken(array $params)
    {
        $token = '';
        $args['Password'] = $this->_secretKey;
        ksort($args);

        foreach ($args as $arg) {
            $token .= $arg;
        }

        $token = hash('sha256', $token);

        return $token;
    }

    /**
     * Checks request success
     *
     * @param $success
     * @throws TinkoffException
     */
    private function isRequestSuccess($success)
    {
        if ($success == false) {
            $log = '[' . date('D M d H:i:s Y', time()) . '] ';
            $log .= "Запрос к платежному сервису был отправлен некорректно";
            $log .= "\r\n";
            file_put_contents(dirname(__FILE__) . "/tinkoff_log.log", $log, FILE_APPEND);
            die(sprintf('Запрос к платежному сервису был отправлен некорректно'));
        }
    }
}

/**
 * Class TinkoffException
 */
class TinkoffException extends Exception
{

}