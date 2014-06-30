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
class TwPageOverride extends TwOverride{

	/**
	 * Headline nodename
	 */
	const HEADLINE = 'TYPO3.Neos.NodeTypes:Headline';

	/**
	 * Text nodename
	 */
	const TEXT = 'TYPO3.Neos.NodeTypes:Text';

	/**
	 * Returns the content for the post
	 * @return string
	 */
	public function getContent(){
		$textNode = $this->textFinder($this->node,self::HEADLINE);
		if($textNode == null)
			$textNode = $this->textFinder($this->node,self::TEXT);
		$content = $textNode->getNodeData()->getFullLabel();
		$link = $this->getLink();
		$content = trim($content,'\t\n');	
			if((strlen($content)+strlen($link)-1)>self::MAX_COUNT){
				$len = self::MAX_COUNT - strlen($link) - 3;		
				$content = substr($content,0,$len).'..';
			}
        $this->tweet = $content.' '.$link;
		return $this->tweet;
	}

	/**
   	 * Returns the address to the page
     *
     * @param NodeInterface $node
   	 * @return base path
  	 */
  	public function basePath($node){
   		$page = $node;
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
		$link = $this->settings['twitter']['link'];
		if($this->basePath($this->node) != null)
			$link = $link.$this->basePath($this->node).'.html';
		return $link;
	}


	
}




?>