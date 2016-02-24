<?php
	namespace core\front;

	interface IRequest
	{
		public function getMethod(): string;

		public function getService(): string;

		public function getResource(): string;

		public function getParameter(string $keyIn): string;
	}