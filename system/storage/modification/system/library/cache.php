<?php
class Cache {
	private $adaptor;

	public function __construct($adaptor, $expire = 3600) {

                require_once DIR_SYSTEM.'nitro/core/core.php';
                
                if (getNitroPersistence('Enabled') && getNitroPersistence('OpenCartCache.Enabled')) {
                  $nitro_expire = getNitroPersistence('OpenCartCache.ExpireTime');
                  $expire = !empty($nitro_expire) ? $nitro_expire : $expire;
                }
            
		$class = 'Cache\\' . $adaptor;

		if (class_exists($class)) {
			$this->adaptor = new $class($expire);
		} else {
			throw new \Exception('Error: Could not load cache adaptor ' . $adaptor . ' cache!');
		}
	}
	
	public function get($key) {
		return $this->adaptor->get($key);
	}

	public function set($key, $value) {
		return $this->adaptor->set($key, $value);
	}

	public function delete($key) {
		return $this->adaptor->delete($key);
	}
}
