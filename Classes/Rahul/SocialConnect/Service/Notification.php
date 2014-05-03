<?php
  namespace Rahul\SocialConnect\Service;
  use TYPO3\Flow\Annotations as Flow;
  use TYPO3\TYPO3CR\Domain\Model\NodeInterface;
  /**
 * A Notification Class to receive Signals from the PublishingService.
 *
 * @Flow\Scope("singleton")
 */	
  class Notification{
  /**
  *Slot to receive notification.
  *@param NodeInterface $node
  *@param Workspace $targetWorkspace
  *@return void
  *@Flow\Signal
  */
   public function sendSocialConnect(NodeInterface $node,Workspace $targetWorkspace = NULL){
      $content = "Nanananan";
      $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myText.txt","wb");
      echo $content;
      fwrite($fp,$content);
      fclose($fp);
  
    }
  }
?>
