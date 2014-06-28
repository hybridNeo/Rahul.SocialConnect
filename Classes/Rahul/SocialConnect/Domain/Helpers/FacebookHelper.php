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

use Facebook\FacebookSession;
use Facebook\FacebookRequest;
use Facebook\GraphObject;
use Facebook\FacebookRequestException;
use TYPO3\Flow\Annotations as Flow;
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Node;

/**
 * Facebook Helper class to post on Facebook
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
	protected $content;

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
   	 * @var Rahul\SocialConnect\Domain\Override\FbOverride
     * @Flow\Inject
   	 */
 	public $fb;
	
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
	 * Function to Get values from override Class
	 * @param NodeInterface
	 * @return void
	 */
	public function getParams($node){
		$factory = new \Rahul\SocialConnect\Domain\Factory\FacebookFactory($node);
		$nodeType = $node->getNodeType()->getName();
		$ovr =$factory->create($nodeType);
		//TODO Constructor fails to load settings so separate method is used
		$ovr->init();
		$this->caption = $ovr->getCaption();
		$this->image = $ovr->getImage();
		$this->description = $ovr->getDescription();
		$this->name = $ovr->getName();
		$this->link = $ovr->getLink();
		$this->content = $ovr->getContent();
	}

	/**
	 * Helper method to post to Facebook.
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @param NodeInterface $node 
	 * @return void
	 * @api
	 */
	public function post($node){
		$this->log('start \n');
		$this->getParams($node);
		
     	FacebookSession::setDefaultApplication( $this->settings['facebook']['appid'],$this->settings['facebook']['secret'] );
     	$session = new FacebookSession($this->settings['facebook']['token']);	
     	$this->log('session created');
     	try {	
				$session->validate();
			} catch (FacebookRequestException $ex) {
			  // Session not valid, Graph API returned an exception with the reason.
			    $this->log($ex->getMessage());
			} catch (\Exception $ex) {
			  // Graph API returned info, but it may mismatch the current app or have expired.
				$this->log($ex->getMessage());
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
					'message' => $this->content
			      )
			    ))->execute()->getGraphObject();
			   		 echo "Posted with id: " . $response->getProperty('id');
			   } catch(FacebookRequestException $e) {
			   		 echo "Exception occured, code: " . $e->getCode();
			   		 echo " with message: " . $e->getMessage();
			    }   

			}
		
	}

	/**
	 * Function to log
	 * @param string
	 * @return void
	 */
	public function log($in){
		$fp = fopen($_SERVER['DOCUMENT_ROOT']."/file.txt","a+");
        fwrite($fp,$in.PHP_EOL);
        fclose($fp);
	}


}


?>