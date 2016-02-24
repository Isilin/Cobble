<?php
	namespace core\front;

	class JsonBuilder implements IBuilder
	{
		public function __construct()
		{

		}

		public function getContent(array $parametersIn): string
		{
			return json_encode($parametersIn);
		}
	}