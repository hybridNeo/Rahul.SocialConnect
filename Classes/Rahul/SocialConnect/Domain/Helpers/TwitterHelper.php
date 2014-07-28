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
use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
use TYPO3\TYPO3CR\Domain\Model\Node;
use Codebird\Codebird;
use Rahul\SocialConnect\Exception;
use Rahul\SocialConnect\Logging\SocialLogger;


/**
 * Twitter Helper class to post on Twitter
 * @Flow\Scope("prototype")
 */
class TwitterHelper{

	/**
 	 * @var array
 	 */	
	protected $settings;

	/**
	 * @var NodeInterface
	 */
	protected $node;

	/**
 	 * @var string 
 	 */	
	protected $tweet;

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
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
	}

	/**
	 * Helper method to post to Facebook.
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @param NodeInterface $node 
	 * @return void
	 * @api
	 */
	public function post(){
		Codebird::setConsumerKey( $this->settings['twitter']['apiKey'],$this->settings['twitter']['apiSecret']);
        $cb = Codebird::getInstance();
        $cb->setToken($this->settings['twitter']['token'], $this->settings['twitter']['tokenSecret']);
        $ovr = new \Rahul\SocialConnect\Domain\Override\TwOverride($this->node);
        $factory = new \Rahul\SocialConnect\Domain\Factory\TwitterFactory($this->node);
		$nodeType = $this->node->getNodeType()->getName();
		$ovr =$factory->create($nodeType);
		$img = $ovr->getImage();
		SocialLogger::twitterLog($img);
		if($img == null){
			$params = array(
    	      'status' => $ovr->getContent(),
        	);
        	
         	$reply = $cb->statuses_update($params);
         	$this->statusAnalyze($reply->httpstatus);
		}	
		else{
			$params = array(
    	      'status' => $ovr->getContent(),
	          'media[]' => $img
        	);
        	
         	$reply = $cb->statuses_updateWithMedia($params);
         	$this->statusAnalyze($reply->httpstatus);
		}
	}    
	public function statusAnalyze($httpCode){
		switch($httpCode){
			case 200:
				SocialLogger::twitterLog('Successfully posted to Twitter.');
				break;
			case 304:
				SocialLogger::twitterLog('304 Not Modified:There was no new data to return. ');
				break;
			case 400:
				SocialLogger::twitterLog('400 Bad Request:.The request was invalid or cannot be otherwise served.');
				break;
			case 401:
				SocialLogger::twitterLog('401 Unauthorized:Authentication credentials were missing or incorrect.Check your access token');
				break;
			case 403:
				SocialLogger::twitterLog('403 Forbidden:The request is understood, but it has been refused or access is not allowed.');
				break;
			case 404:
				SocialLogger::twitterLog('404:Resource Not Found');
				break;
			case 406:
				SocialLogger::twitterLog('406:Not Acceptible invalid format.');
				break;
			case 410:
				SocialLogger::twitterLog('410 Resource Gone:Api is outdated Download new version of Social Connect ');
				break;
			case 420:
				SocialLogger::twitterLog('420 :Enhance Your Calm');
				break;
			case 422:
				SocialLogger::twitterLog('422 : Unprocessable Entry');
				break;
			case 429:
				SocialLogger::twitterLog('429:Too many requests');
				break;
			case 500:
				SocialLogger::twitterLog('500: Internal server error');
				break;
			case 502:
				SocialLogger::twitterLog('502: Bad Gateway ,Twitter may be down');
				break;
			case 503:
				SocialLogger::twitterLog('503: Service Unavailable Error with twitter servers.');
				break;
			case 504:
				SocialLogger::twitterLog('504:Gateway timeout');
				break;
			default:
				SocialLogger::twitterLog('Check your connection and credentials');

		}
	}
}

?>

