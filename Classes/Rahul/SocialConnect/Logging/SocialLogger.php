<?php
namespace Rahul\SocialConnect\Logging;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Rahul.SocialConnect".               *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Node;

/**
 * A log class to log all the social media activity
 * @Flow\Scope("singleton")
 */
class SocialLogger{
    const DEVELOPEMENT = true;
    /**
	 * Function to log Facebook activity
	 * @param string
	 * @return void
	 */
	public static function facebookLog($in){
		if(self::DEVELOPEMENT == true){
			$fp = fopen($_SERVER['DOCUMENT_ROOT']."/../Data/Logs/facebook.txt","a+");
			$today = date("Y-m-d H:i:s");          
        	fwrite($fp,$today.'  '.$in.PHP_EOL);
     	   	fclose($fp);
    	}
	}

	/**
	 * Function to log Twitter activity
	 * @param string
	 * @return void
	 */
	public static function twitterLog($in){
		if(self::DEVELOPEMENT == true){
			$fp = fopen($_SERVER['DOCUMENT_ROOT']."/../Data/Logs/twitter.txt","a+");
			$today = date("Y-m-d H:i:s");          
        	fwrite($fp,$today.'  '.$in.PHP_EOL);
     	   	fclose($fp);
    	}
    }
}








?>