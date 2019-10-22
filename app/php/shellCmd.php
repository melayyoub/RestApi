<?php

namespace App\php;

class shellCmd {
 public static function shellGet($cmd){

	  $results = shell_exec($cmd);

	return $results;
	}
}
