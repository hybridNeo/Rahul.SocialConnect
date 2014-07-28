<?php
  namespace Rahul\SocialConnect\Service;
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
  use Rahul\SocialConnect\Logging\SocialLogger;
  use TYPO3\Media\Domain\Model\ImageVariant;    

  
/**
 * Notification Class for SocialConnect It holds the slot and helpers which listens to the publishing process.
 * @Flow\Scope("singleton")
 */
class Notification{  

  /**
   * @var Rahul\SocialConnect\Domain\Helpers\FacebookHelper
   * @Flow\Inject
   */
  public $fb;

   /**
   * @var Rahul\SocialConnect\Domain\Helpers\TwitterHelper
   * @Flow\Inject
   */
  public $tw;

  /**
    * Receive Published Nodes
    * A Slot to listen to PublishingProcess
    * @param NodeInterface $node
    * @param mixed $targetWorkspace In case this is triggered during publishing, a Workspace will be passed in
    * @return void
    */  
  public function sendSocialConnect(Node $node,$targetWorkspace = NULL){
      $face = $node->getProperty('facebook');
      $twitter = $node->getProperty('twitter');
      if($face == 1)
      { 
        $fb = new \Rahul\SocialConnect\Domain\Helpers\FacebookHelper();
        $fb->post($node);
      }
      if($twitter == 1){
        $tw = new \Rahul\SocialConnect\Domain\Helpers\TwitterHelper($node);
        $tw->post();
        
      }
      /*
      $img = $node->getProperty('image');
      $res = $img->getResource();
      $name = 'test';
      $pub = new \TYPO3\Flow\Resource\Publishing\ResourcePublisher();
      $name = $pub->getPersistentResourceWebUri($res);
      SocialLogger::twitterLog($name);
      */

  }



}

?>
