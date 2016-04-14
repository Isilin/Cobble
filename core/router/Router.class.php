<?php
	namespace core\router;

	use core\Log;
	use core\router\HttpRequest;
	use core\router\Web;
	use core\controller\FrontController;

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
		}

		public function processRequest()
		{
			if($this->request->getService() == 'admin') {
				if($this->coreWays->existsWay($this->request->getResource())) {
					$controller = new FrontController();
					$view = $this->coreWays->getView($this->request->getResource());
					$controller->process($request, $view);
				} else {
					header('Location: /404?resource=' . $this->request->getResource());
				}
			} else {
				if($this->appWays->existsWay($this->request->getResource())) {
					$controller = new FrontController();
					$view = $this->appWays->getView($this->request->getResource());
					$controller->process($request, $view);
				} else {
					header('Location: /404?resource=' . $this->request->getResource());
				}
			}
		}
	}