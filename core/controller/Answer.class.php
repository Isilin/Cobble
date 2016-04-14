<?php
	namespace core\front;

	class Answer
	{
		private $listElements = array();
		private $statusCode = 200;

		public function addNewElements(array $elementsIn)
		{
			$this->listElements = array_merge($this->listElements, $elementsIn);
		}

		public function setStatusCode(int $statusCodeIn)
		{
			$this->statusCode = $statusCodeIn;
		}

		public function getElements(): array
		{
			return $this->listElements;
		}

		public function getStatusCode(): int
		{
			return $this->statusCode;
		}
	}