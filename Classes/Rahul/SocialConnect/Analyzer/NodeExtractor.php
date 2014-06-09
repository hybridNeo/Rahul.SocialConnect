<?php
namespace Rahul\SocialConnect\Analyzer;
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
 * TODO
 * Class to determine the Child Nodes of a class Node and to extract the right content from it
 * @Flow\Scope("prototype")
 */

class NodeExtractor{


	/**
 	 * @var NodeInterface
 	 */	
	protected $node;

	/**
	 * @var integer
	 */
	protected $nodeHeight;
	
	/**
	 *
	 * @param NodeInterface $node 
	 * @return void
	 */
	public function __costruct($node){
		$this->nodeHeight = 0;
		$this->node = $node;
		
	}


	/**
	 * Returns the height of the node Tree starting at the given point
	 * @param NodeInterface $node 
	 * @return int 
	 */
	public function treeHeight($node){
		if($node->hasChildNodes())
		{
			$this->nodeHeight++;
			$this->treeHeight($node->getPrimaryChildNode());
		}
		return $this->nodeHeight;
		
	}

	/**
	 * Returns if the given Node is Supported by Social Connect
	 * @param NodeInterface
	 * @return boolean
	 */
	public function isSupported($node){
		if($node->hasProperty('articleType'))
			return true;
		else
			return false;
	}
}
?>