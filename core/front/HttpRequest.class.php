<?php
	namespace core\front;

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

			$this->resource = substr($this->service, strpos($this->service, '/'));
			$this->service = substr($this->service, 0, strpos($this->service, '/')-1);

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