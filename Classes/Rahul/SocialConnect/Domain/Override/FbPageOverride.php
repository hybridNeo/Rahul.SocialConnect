<?php
namespace Rahul\SocialConnect\Domain\Override;
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
 * The specific override class for a Page node type
 *
 * @Flow\Scope("prototype")
 */
class FbPageOverride extends FbOverride{

	/**
	 * This the Page Node which the headline is contained in 
	 * @var NodeInterface
	 */
	protected $contentCollection;

	

	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
		$this->contentCollection = $node->getPrimaryChildNode();
	   
	}


	/**
	 * Returns the content for the post
	 * @return string
	 */
	public function getContent(){
		/*$this->content = null;
		if($this->contentCollection->hasChildNodes(self::HEADLINE)){
			$textNodes = $this->contentCollection->getChildNodes(self::HEADLINE);
			$text = $textNodes[0]->getNodeData()->getFullLabel();
			$this->content = $text;
		}*/
		$textNode = $this->textFinder($this->node,self::HEADLINE);
		$this->content = $textNode->getNodeData()->getFullLabel();
		return $this->content;
	}

	
	/**
	 * Returns the name
	 * @return string
	 */
	public function getName(){
		$contentData = $this->node->getNodeData();
        $cap = $contentData->getFullLabel();
        $this->caption =  $cap;
		return $this->caption;
	}

	/**
   	 * Returns the address to the page
     *
     * @param NodeInterface $node
   	 * @return base path
  	 */
  	public function basePath($node){
   		$page = $this->node;
    	while($node->getParent() != null){
    	    $node= $node->getParent();
     	}
     	$node = $node->getPrimaryChildNode()->getPrimaryChildNode();
     	$nodePath = $node->getPath();
     	$parentPath = $page->getPath();
     	$nodePath = str_replace($nodePath,"",$parentPath);
     	return $nodePath;
    }

    /**
	 * Returns the link
	 * @return string
	 */
	public function getLink(){
		if($this->basePath($this->node) != null)
			$this->link = $this->link.$this->basePath($this->node).'.html';
		return $this->link;
	}


	/**
	 * Returns the caption
	 * Unstable:Fails with content Collection teaser
	 * @return string
	 */
	public function getCaption(){
		$foo = $this->node;
		$textNode = $this->textFinder($foo,self::TEXT);
		$this->caption = $textNode->getNodeData()->getFullLabel();
		return $this->caption;
	}

	
}




?>