<?php
	namespace core\front;

	interface IScanner
	{
		public function scan(): bool;
	}