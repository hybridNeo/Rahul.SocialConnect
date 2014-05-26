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
  use TYPO3\CMS\Core\Messaging\FlashMessage;
    
/**
* Facebook slot class
*
* @Flow\Scope("singleton")
*/
class Notification{  

  /**
  *@var Rahul\SocialConnect\Domain\Factory\FacebookFactory
  */
  public $fb;
  /**
    * Receive Published Nodes
    *
    * @param NodeInterface $node
    * @param mixed $targetWorkspace In case this is triggered during publishing, a Workspace will be passed in
    * @return void
    */  
  public function sendSocialConnect(Node $node,$targetWorkspace = NULL){
      $contentData =$node->getNodeData();
      $content = $contentData->getFullLabel();
      $fb = new Rahul\SocialConnect\Domain\Factory\FacebookFactory();
      //$fbook = $fb->create();
      $fp = fopen($_SERVER['DOCUMENT_ROOT']."/file.txt","wb");
      echo $content;
      fwrite($fp,$content);
      fclose($fp);
  }

}






















?>
