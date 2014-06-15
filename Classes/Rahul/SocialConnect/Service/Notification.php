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
  
    
/**
 * Facebook slot class.Listens to the publishing process.
 *
 * @Flow\Scope("singleton")
 */
class Notification{  

  /**
   * @var Rahul\SocialConnect\Domain\Helpers\FacebookHelper
   * @Flow\Inject
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
      $face = $node->getProperty('facebook');
      if($face == 1)
      {
        $fb = new \Rahul\SocialConnect\Domain\Helpers\FacebookHelper();
        $fb->post($node);
        //ignore after
        /*
        $contentCollecton = $node->getPrimaryChildNode();
        $noda = $contentCollecton->getChildNodes('TYPO3.Neos.NodeTypes:TwoColumn');
        $n = $noda[0];
        $n = $noda[0]->getPrimaryChildNode()->getPrimaryChildNode();
        $nodeType= $n->getNodeType()->getName();
        $textData = $n->getNodeData();
        $text = $textData->getFullLabel();
        $fp = fopen($_SERVER['DOCUMENT_ROOT']."/file.txt","wb");
        fwrite($fp,$text);
        fclose($fp);
        */
      } 
  }
 

}





?>
