<?php
final class Registry {
	private $data = array();

	public function get($key) {
		return (isset($this->data[$key]) ? $this->data[$key] : null);
	}

	public function set($key, $value) {
		$this->data[$key] = $value;

                if ($key == "request" && __FUNCTION__ == "set") {
                    $GLOBALS["registry"] = $this;

                    require_once DIR_SYSTEM . 'nitro/core/core.php';
                }

                if ($key == "language" && __FUNCTION__ == "set") {
                    require_once NITRO_INCLUDE_FOLDER . 'pagecache_top.php';
                }
            
	}

	public function has($key) {
		return isset($this->data[$key]);
	}
}