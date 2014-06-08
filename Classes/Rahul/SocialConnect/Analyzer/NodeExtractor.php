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
 * Class to determine the Child Nodes of a class Node and to extract the right content from it
 * @Flow\Scope("prototype")
 */

class NodeExtractor{


	/**
 	 * @var NodeInterface
 	 */	
	protected $node;

	/**
	 * @var int
	 */
	protected $nodeHeight;
	
	/**
	 *
	 * @param NodeInterface $node 
	 */
	function __costruct($node){
		$this->node = $node;
		$this->nodeHeight = 0;
	}

	/**
	 * Returns the height of the node Tree starting at the given point
	 * @param NodeInterface $node 
	 * @return int 
	 */
	public function treeHeight(){
		if($this->node->hasChildNode()){
			$this->node = $this->node->getPrimaryChildNode();
			$this->nodeHeight++;
			treeHeight($this->node);
		}
		return $this->nodeHeight;
	}
}
?>