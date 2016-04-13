<?php
	namespace core\front;

	interface IBuilder
	{
		public function getContent(array $parametersIn): string;
	}