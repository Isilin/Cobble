<?php
	namespace core\router;

	interface IRequest
	{
		public function getMethod(): string;

		public function getService(): string;

		public function getResource(): string;

		public function getParameter(string $keyIn): string;
	}