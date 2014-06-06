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
	 * Function to initialize defaults from Settings.yaml
	 * @return void
	 */
	public function initDefault(){
		$this->caption = $this->settings['facebook']['caption'];
		$this->image = $this->settings['facebook']['image'];
		$this->description = $this->settings['facebook']['desc'];
		$this->name = $this->settings['facebook']['name'];
		$this->link = $this->settings['facebook']['link'];
	}

	/**
	 * A function to ovveride the title of the link. it is usually set to default.You can change the default arguments in Settings.yaml
	 * This function takes a complex Node and changes the link name to the text of the parent node if it has child nodes.
	 * @return void
	 */
	public function overloadName(){
		
	}

	/**
	 * Helper method to post to Facebook.
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @param string 
	 * @return void
	 * @api
	 */
	public function post($content){
		$this->initDefault();// all the post parameters are set to the default ones mentioned in Settings.yaml
     	FacebookSession::setDefaultApplication( $this->settings['facebook']['appid'],$this->settings['facebook']['secret'] );
     	$session = new FacebookSession($this->settings['facebook']['token']);	
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
			        'link' => $this->link,
					'picture' => $this->image,
					'description' => $this->description,
					'name' => $this->name,
					'caption' => $this->caption,
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