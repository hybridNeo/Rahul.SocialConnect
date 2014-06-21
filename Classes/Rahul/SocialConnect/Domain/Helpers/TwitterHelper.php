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
        $params = array(
          'status' => $ovr->getContent()
        );
        $reply = $cb->statuses_update($params);
	}

}

?>