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
		Codebird::setConsumerKey("eEM91ImngwXqzUeRgeSeQtPS5", "6zjmNqm4sYC4BL5danFeR7Neyrft8gzTToeOgJxtS7AhIqFRZ5");
        $cb = Codebird::getInstance();
        $cb->setToken("2449177514-8E3jbUr8Wd1RJbI5kqNedi72SXsz9wmPSMBHlDt", "sZHWHQ8VENajpQjRpdNQwAt3BqvsfP1ofA6FUazpgbKtI");
        $params = array(
          'status' => ' another test post 2#php #twitter'
        );
        $reply = $cb->statuses_update($params);
	}

}

?>