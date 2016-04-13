<?php
	namespace core\front;

	use core\Contract;

	class HttpScanner implements IScanner
	{
		private $requestURI;
		private $get = array();
		private $post = array();

		public function __construct()
		{
			$this->requestURI = $_SERVER['REQUEST_URI'];
			$this->get = $_GET;
			$this->get= $_POST;

			Contract::assert(is_string($this->requestURI), 'This variable should be a string.');
			Contract::assert(is_array($this->get), 'This variable should be an array.');
			Contract::assert(is_array($this->post), 'This variable should be an array.');
		}

		public function scan(): bool
		{
			$isValid = true;
			$isValid = $isValid and (strpos($this->requestURI, '?') == false) and (strpos($this->requestURI, '&') == false);
			if ($isValid) {
				if (array_key_exists('method', $this->post) && isset($this->post['method'])) {
					$isValid = $isValid &&  ($this->post['method'] == 'GET' || $this->post['method'] == 'HEAD' || $this->post['method'] == 'POST' || $this->post['method'] == 'PUT'
											 || $this->post['method'] == 'TRACE' || $this->post['method'] == 'DELETE' || $this->post['method'] == 'CONNECT' 
											 || $this->post['method'] == 'OPTIONS');
				}
			}
			return $isValid;
		}
	}