<?php
	namespace core;

	define("BROWSER", 0);
	define("FILE", 1);
	
	class Log
	{
		private static $mode = BROWSER;
		
		public static function setMode($modeIn)
		{
			Log::$mode = $modeIn;
		}
		
		public static function info($stringIn)
		{
			if (Log::$mode == 0) {
				echo '[' . date('Y-m-d H:i:s') . '][INFO] ' . $stringIn;
			} else {
				$file = fopen('../core/log.log', 'a');
				if ($file) {
					fwrite($file, '[' . date('Y-m-d H:i:s') . '][INFO] ' . $stringIn);
				} else {
					echo 'Error : forbidden to write logs.<br>';
				}
				fclose($file);
			}
		}
		
		public static function exception($stringIn)
		{
			if (Log::$mode == 0) {
				throw new \Exception('[' . date('Y-m-d H:i:s') . '][ERROR] ' . $stringIn);
			} else {
				$file = fopen('../core/log.log', 'a');
				if ($file) {
					fwrite($file, '[' . date('Y-m-d H:i:s') . '][ERROR] ' . $stringIn);
				} else {
					echo 'Error : forbidden to write logs.<br>';
				}
				fclose($file);
			}
		}
		
		public static function taggedLog($tagIn, $stringIn)
		{
			if (Log::$mode == 0) {
				echo '[' . date('Y-m-d H:i:s') . '][' . $tagIn . '] ' . $stringIn;
			} else {
				$file = fopen('../core/log.log', 'a');
				if ($file) {
					fwrite($file, '[' . date('Y-m-d H:i:s') . '][' . $tagIn . '] ' . $stringIn);
				} else {
					echo 'Error : forbidden to write logs.<br>';
				}
				fclose($file);
			}
		}
	}