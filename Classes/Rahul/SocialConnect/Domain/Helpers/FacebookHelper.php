<?php
namespace Rahul\SocialConnect\Domain\Helpers;
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
use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
		

/**
 * Facebook Helper for Facebook package
 *
 * @Flow\Scope("prototype")
 */
class FacebookHelper{
	
	/**
 	 * @var array
 	 */	
	protected $settings;

	/**
 	 * @var string 
 	 */	
	protected $link;
 	
 	/**
 	 * @var string 
 	 */	
	protected $caption;

	/**
 	 * @var string 
 	 */	
	protected $name;

	/**
 	 * @var string 
 	 */	
	protected $image;

	/**
 	 * @var string 
 	 */	
	protected $description;

	public function intializeParam(){
		$link = $this->settings['facebook']['link'];
		$name = $this->settings['facebook']['name'];
		$caption = $this->settings['facebook']['caption'];
		$description = $this->settings['facebook']['desc'];
	}


	/**
 	 * Inject settings
 	 *
 	 * @param array $settings
 	 * @return void
 	 */
	public function injectSettings(array $settings) {
	    $this->settings = $settings;
	}

	/**
	 * Helper method to post to Facebook.
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @param string 
	 * @return void
	 * @api
	 */
	public function post($content){
     	FacebookSession::setDefaultApplication( $this->settings['facebook']['appid'],$this->settings['facebook']['secret'] );
     	$session = new FacebookSession($this->settings['facebook']['token']);	
     	$this->intializeParam();
     	try {
				$session->validate();
			} catch (FacebookRequestException $ex) {
			  // Session not valid, Graph API returned an exception with the reason.
			    echo $ex->getMessage();
			} catch (\Exception $ex) {
			  // Graph API returned info, but it may mismatch the current app or have expired.
				echo $ex->getMessage();
			}		
		if($session) {
			  try {
				    $response = (new FacebookRequest(
			    	$session, 'POST', '/'.$this->settings['facebook']['user'].'/feed', array(
			        'link' => $this->settings['facebook']['link'],
			        'picture' => $this->settings['facebook']['image'],
			        'description' => $this->settings['facebook']['desc'],
			        'name' => $this->settings['facebook']['name'],
			        'caption' => $this->settings['facebook']['caption'],
			        'message' => $content
			      )
			    ))->execute()->getGraphObject();
			    echo "Posted with id: " . $response->getProperty('id');
			   } catch(FacebookRequestException $e) {
			   		 echo "Exception occured, code: " . $e->getCode();
			   		 echo " with message: " . $e->getMessage();
			    }   

			}
		
	}

}












?>