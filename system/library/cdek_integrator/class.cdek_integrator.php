<?php

class cdek_integrator
{

        private static $ext_dir; // Базовый URL API
    public $error; //URL API для ajax запросов
    protected $base_url = 'https://integration.cdek.ru/'; // Учетная запись
    protected $ajax_url = 'https://api.cdek.ru/'; // Cекретный код
protected $account;
protected $secure_password; // Версия модуля
    protected $date;
private $version = "1.0"; // Ошибки при выполнении метода

    public function __construct($account = '', $secure_password = '', $date = '')
    {

        if (!empty($account) && !empty($secure_password)) {
            $this->setAuth($account, $secure_password);
        }

        if (!$date) {

            $default_timezone = date_default_timezone_get();

            date_default_timezone_set('UTC');

            $date = date('Y-m-d', time() + 10800);

            date_default_timezone_set($default_timezone);

        }

        $this->setDate($date);

        $this->init();
    }

    /**
     * Авторизация ИМ
     *
     * @param string $account логин
     * @param string $secure_password пароль
     */
    public function setAuth($account, $secure_password)
    {
        $this->account = $account;
        $this->secure_password = $secure_password;
    }

    /**
     * Установка планируемой даты отправки
     *
     * @param string $date дата планируемой отправки, например '2014-06-25'
     */
    public function setDate($date)
    {
        $this->date = $date;
    }

    private function init()
    {

        spl_autoload_register(array($this, 'autoloader'));
        spl_autoload_extensions('.php');

        self::$ext_dir = dirname(__FILE__);
    }

    static public function autoloader($class_name)
    {
        if (class_exists($class_name)) return;

        $folders = array(DIR_SYSTEM . 'library/cdek_integrator/', DIR_SYSTEM . 'library/cdek_integrator/components/');

        foreach ($folders as $folder) {

            foreach (array('class', 'interface') as $type) {

                $file_name = $folder . $type . '.' . $class_name . '.php';

                if (file_exists($file_name)) {
                    return require_once $file_name;
                }
            }

        }
    }

    public function loadComponent($component)
    {
        if (!class_exists($component)) return null;
        return new $component($this->account, $this->secure_password, $this->date);
    }

    public function sendData(exchange $component)
    {

        $action = $this->base_url . $component->getMethod();
        $parser = method_exists($component, 'getParser') ? $component->getParser() : new parser_xml();

        $response = $this->getURL($action, $parser, $component->getData());

        // Обнуление массива ошибок
        $this->error = array();

        return method_exists($component, 'prepareResponse') ? $component->prepareResponse($response, $this->error) : $response;
    }

    protected function getURL($url, response_parser $parser, $data = array())
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, 20);

        if (!empty($data)) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }

        $out = curl_exec($ch);
        curl_close($ch);

        $parser->setData($out);

        return $parser->getData();
    }

    public function getMethod()
    {
        return $this->method;
    }

    /**
     * Защифрованный пароль для передачи на сервер
     *
     * @return string
     */
    protected function getSecure()
    {
        return md5($this->date . '&' . $this->secure_password);
    }

}

?>