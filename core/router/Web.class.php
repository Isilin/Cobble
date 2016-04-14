<?php
	namespace core\router;

	use core\Log;
	use core\util\JsonBuilder;
	use core\Contract;

	class Web
	{
		private $root = "";
		private $ways = null;

		public function __construct(string $file)
		{
			$builder = new JsonBuilder();
			$content = $builder->loadContent("../core/config/router.json");
			if(!array_key_exists('root', $content)) {
				Log::exception('The config file should contain a root member.');
			}
			if(!array_key_exists('ways', $content)) {
				Log::exception('The config file should contain a ways member.');
			}

			$this->root = $content['root'];
			$this->ways = $content['ways'];
		}

		public function existsWay(string $way) : bool
		{
			return array_key_exists($way, $this->ways);
		}

		public function getView(string $way) : string
		{
			if(!array_key_exists(way, $this->way)) {
				Log::exception('THis way doesn\'t exist. You should have to check before getting the view.');
			}
			return $this->ways[$way];
		}

		public function getRoot() : string
		{
			return $this->root;
		}
	}