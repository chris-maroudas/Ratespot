<?php

class CacheHandler
{

	public $cachefile;
	public $timeCr; // Dev purposes

	function __construct()
	{
		$this->cachefile = "side_and_footer" . '.cache';
		clearstatcache();
		$this->timeCr = microtime(true);    // Dev purposes
	}

	public function start()
	{
		ob_start();
	}

	public function endAndSaveCacheFile()
	{
		$contents = ob_get_contents();
		ob_end_clean();
		$handle = fopen($this->cachefile, "w");
		fwrite($handle, $contents);
		fclose($handle);
		echo "Non cache took : " . (microtime(true) - $this->timeCr);   // Dev purposes
		include($this->cachefile);
	}

	public function checkIfCacheIsLegal()
	{
		if (file_exists($this->cachefile) && filemtime($this->cachefile) > time() - 20) { // good to serve!
			echo "Cache took : " . (microtime(true) - $this->timeCr);   // Dev purposes
			include($this->cachefile);
			exit;
		} else {
			return FALSE;
		}
	}

	public function clearCacheFiles()
	{
		delete($this->cachefile);
	}

}