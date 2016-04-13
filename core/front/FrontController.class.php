<?php
	namespace core\front;
	
	use core\Log;

	class FrontController
	{
		private $answer = null;

		public function __construct()
		{
			$this->answer = new Answer();
		}

		public function process()
		{
			$scanner = new HttpScanner();
			if ($scanner->scan()) {
				$httpRequest = new HttpRequest();
				if ($this->isExistingService($httpRequest->getService())) {
					$config = parse_ini_file("../application/configs/services/" . $httpRequest->getService() . ".ini", true);
					if($this->isExistingResource($http->getRessource(), $config)) {
						// call controller
					} else {
						$this->prepareError("The ressource that you're asking doesn't exist, please check your request !", 404);
					}
				} else {
					$this->prepareError("The service that you're asking doesn't exist, please check your request !", 404);
				}
			} else {
				$this->prepareError("We detect that this query is a vicious request, please be careful !", 400);
			}

			$this->answer();
		}

		private function prepareError(string $errorIn, int $statusCodeIn)
		{
			$this->answer->setStatusCode($statusCodeIn);
			$this->answer->addNewElements(array("content"=>$errorIn));
		}

		private function isExistingService(string $serviceIn): bool
		{
			return file_exists("../application/configs/services/" . $serviceIn . ".ini");
		}

		private function isExistingResource(string $resourceIn, array $iniFileIn): bool
		{
			return array_key_exists($resourceIn, $iniFileIn);
		}

		private function answer()
		{
			//header("Content-Type: application/json; charset=UTF-8");
			http_response_code($this->answer->getStatusCode());

			$answerBuilder = new JsonBuilder();
			$jsonAnswer = $answerBuilder->getContent($this->answer->getElements());

			Log::info("error " . http_response_code() . "<br>");
			Log::info($jsonAnswer . "<br>");

			//echo $jsonAnswer;
		}
	}