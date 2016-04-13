<?php
	namespace core\router;

	use core\Log;
	use core\router\HttpRequest;
	use core\router\Web;

	class Router
	{
		private $request = null;
		private $coreWays = null;
		private $appWays = null;

		public function __construct()
		{
			$this->coreWays = new Web("../core/config/router.json");
			$this->appWays = new Web("../app/config/router.json");
		}

		public function parseRequest()
		{
			$this->request = new HttpRequest();
			print_r($this->request);
		}

		public function processRequest()
		{
			if($this->request->getService() == 'admin') {
				if($this->coreWays->existsWay($this->request->getResource())) {

				} else {
					//header('Location: /404');
				}
			} else {
				if($this->appWays->existsWay($this->request->getService() . '/' .$this->request->getResource())) {

				} else {
					//header('Location: /404');
				}
			}
		}
	}