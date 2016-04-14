<?php
	namespace core\front;

	use core\Contract;

	class HttpScanner implements IScanner
	{
		private $request;

		public function __construct()
		{
			$this->requestURI = null;

			Contract::assert(is_string($this->requestURI), 'This variable should be a string.');
		}

		public function scan(IRequest $request): bool
		{
			$this->request = $request;

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