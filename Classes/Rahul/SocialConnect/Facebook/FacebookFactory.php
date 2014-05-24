<?php
namespace Rahul\SocialConnect;
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
 * @Flow\Scope("singleton")
 */
class FacebookFactory{
	/**
	 * Factory method which creates a Facebook instance.
	 *
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @return \Rahul\SocialConnect\Fb\Facebook
	 * @api
	 */
	public function create(){
	 	$config = array(
     	 'appId' => $this->settings['appid'],
      	 'secret' => $this->settings['secret'],
      	 'fileUpload' => false, // optional
      	 'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
      	);
		$object = new \Rahul\SocialConnect\Fb\Facebook($config);
		return $object;
	}
}












?>