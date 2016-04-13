<?php
	namespace core\router;

	use core\router\IRequest;

	class HttpRequest implements IRequest
	{
		private $method;
		private $service;
		private $resource;
		private $parameters;


		public function __construct()
		{
			if (array_key_exists('method', $_POST) && isset($_POST['method'])) {
				$this->method = $_POST['method'];
			} else {
				$this->method = 'GET';
			}

			$this->service = substr($_SERVER['REQUEST_URI'], 1);

			if(strpos($this->service, '/')) {
				$this->resource = substr($this->service, strpos($this->service, '/')+1);
				if(strpos($this->resource, '?')) {
					$this->resource = substr($this->resource, 0, strpos($this->resource, '?'));
				}

				$this->service = substr($this->service, 0, strpos($this->service, '/'));
			} else {
				$this->resource = "";
			}
			$this->service = "/" . $this->service;

			if($this->method == 'GET') {
				$this->parameters = $_GET;
			} else {
				$this->parameters = $_POST;
				unset($this->parameters['method']);
			}
		}

		public function getMethod(): string
		{
			return $this->method;
		}

		public function getService(): string
		{
			return $this->service;
		}

		public function getResource(): string
		{
			return $this->resource;
		}

		public function getParameter(string $keyIn): string
		{
			return $this->parameters[$keyIn];
		}
	}