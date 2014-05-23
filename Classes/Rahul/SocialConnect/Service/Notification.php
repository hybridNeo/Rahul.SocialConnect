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
      $config = array(
      'appId' => '300704070093400',
      'secret' => '392d3e6cf62daa323b1303904bec0037',
      'fileUpload' => false, // optional
      'allowSignedRequest' => false, // optional, but should be set to false for non-canvas apps
      );
      $contentData =$node->getNodeData();
      $content = $contentData->getFullLabel();
      $fb = new Rahul\SocialConnect\Fbook\Facebook($config);
      $fp = fopen($_SERVER['DOCUMENT_ROOT'] . "/myxt.txt","wb");
      echo $content;
      fwrite($fp,$content);
      fclose($fp);
      $params = array(
      "access_token" => "CAACEdEose0cBAMm4h8ut9bkNssMQnczu0AViTN6ZBbS8NttZCKhxZAAZBbeWOUCHq5zj2ads2Nnf8Abw5c1WkzGZAGmhOGnzZCpehUMsgpcC4zagp69FU5eX8ZCVNzZAkSikQuEGsYQmQKcjpIMDv4dD52jT8Hl5HxZAb1vzZC0eXfn6ZBODV7ZAVQ1bBr74zcyte28ZD", // see: https://developers.facebook.com/docs/facebook-login/access-tokens/ or https://developers.facebook.com/tools/explorer/
      "message" => "Hello",
      "link" => "http://www.paranoha.site90.com",
      "picture" => "http://i.imgur.com/lHkOsiH.png",
      "name" => "TYPO3 Auto Post",
      "caption" => "www.paranoha.site90.com",
      "description" => "Automatically post on Facebook with PHP using Facebook PHP SDK. How to create a Facebook app. Obtain and extend Facebook access tokens. Cron automation.");
       try {
         $ret = $fb->api('/1060110920/feed', 'POST', $params);
      } catch(Exception $e) {
        echo $e->getMessage();
      }
     
  }
}






















?>
