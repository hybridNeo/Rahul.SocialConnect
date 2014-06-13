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
 * The specific override class for Headline data type
 *
 * @Flow\Scope("prototype")
 */
class FbHeadlineOverride extends FbOverride{


	/**
	 * This the Page Node which the headline is contained in 
	 * @var NodeInterface
	 */
	protected $parent;


	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
		$this->parent = $node->getParent()->getParent();
	}

	/**
	 * Returns the caption
	 * @return string
	 */
	public function getName(){
		$contentData = $this->parent->getNodeData();
        $cap = $contentData->getFullLabel();
        $this->caption =  $cap;
		return $this->caption;
	}





}

?>