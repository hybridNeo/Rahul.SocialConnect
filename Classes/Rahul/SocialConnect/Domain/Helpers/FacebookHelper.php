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
	 * Helper method to post to Facebook.
	 * Specify AppID and secret along with other data in configuration.yaml files under Configuration 
	 * @param string 
	 * @return void
	 * @api
	 */
	public function post($content){
     	FacebookSession::setDefaultApplication( '300704070093400','392d3e6cf62daa323b1303904bec0037' );
     	$session = new FacebookSession('CAACEdEose0cBAHjNOSAn9dqV30hjldE3IasW9YaD68sEtGWHaZBahbPculcZBKTZCPnk8j8ZBxJu8LNK3wNaYA1ARXxNCxpcrmpeNRBD1874A4ba9X4kpaVraEZC1cunuq4oJgntt4BsVTcHaD5tPiHL2JnXppiv791ktBFR6HGg7oFB5fttImtvZBEZBysMUMZD');
		if($session) {
			  try {
				    $response = (new FacebookRequest(
			    	$session, 'POST', '/me/feed', array(
			        'link' => 'www.example.com',
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