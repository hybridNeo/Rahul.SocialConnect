<?php
  namespace Rahul\SocialConnect\Service;
  
  use TYPO3\Flow\Annotations as Flow;
  use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
  use TYPO3\TYPO3CR\Domain\Model\Node;
  use TYPO3\CMS\Core\Messaging\FlashMessage;
  
  /**
 * A Notification Class to receive Signals from the PublishingService.
 *
 * @Flow\Scope("singleton")
 */	
   
  class Notification{
  	
  	
  	
  	
  	
  	
  	
  	
  	/**
    * Receive Published Nodes
    *
    * @param NodeInterface $node
    * @param mixed $targetWorkspace In case this is triggered during publishing, a Workspace will be passed in
    * @return void
    */
    
   public function sendSocialConnect(Node $node,$targetWorkspace = NULL){  
      $new = new Rahul\SocialConnect\Lib\Facebook($config);
      $contentData =$node->getNodeData();
      $content = $contentData->getFullLabel();
     
  }
}






















?>
