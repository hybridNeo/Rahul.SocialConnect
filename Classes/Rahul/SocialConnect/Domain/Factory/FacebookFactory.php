<?php
namespace Rahul\SocialConnect\Domain\Factory;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Rahul.SocialConnect".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 * of the License, or (at your option) any later version.                 *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
use TYPO3\Flow\Annotations as Flow;

/**
 * Facebook factory for Facebook package
 *
 * @Flow\Scope("prototype")
 */
class FacebookFactory{

	/**
	* @var array
	*/
	public $config;

	public function __construct(){
		
	}

	/**
	 * Factory method which creates a Facebook instance.
	 *
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @return \Facebook\PHP\Facebook
	 * @api
	 */
	public function create(){
		 $config = array(
      	 'appId' => '300704070093400',
      	 'secret' => '392d3e6cf62daa323b1303904bec0037',
      	 'fileUpload' => false, 
     	 'allowSignedRequest' => false, );
		$object = new \Facebook\PHP\Facebook($config);
		return $object;
	}
}












?>