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
use TYPO3\Eel\FlowQuery\FlowQuery;


/**
 * Default Override class for Twitter Post Parameters
 * Non Defined NodeTypes Default to this
 * @Flow\Scope("prototype")
 */
class TwOverride{
	/**
	 * @var NodeInterface
	 */
	protected $node;

    /**
	 * Maximum Character count for tweets
	 */
	const MAX_COUNT = 140;

	/**
 	 * @var string 
 	 */	
	protected $tweet;

	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
	}

	/**
 	 * Inject settings
 	 *
 	 * @param array $settings
 	 * @return void
 	 */
	public function injectSettings(array $settings) {
	    $this->settings = $settings;
	}


	/**
	 * Returns the content label
	 * @return string
	 */
	public function getContent(){
		$contentData =$this->node->getNodeData();
        $this->tweet = $contentData->getFullLabel();
		return $this->tweet;
	}

 	/**
  	 * Find the first Text Node matching the grammar description
   	 * @param NodeInterface $node
     * @param string $grammar
     * @return NodeInterface
     */
 	public function textFinder($node,$grammar){
	    $q = new FlowQuery(array($node));
    	$element = $q->find('[instanceof '.$grammar.']')->get(0);
     	return $element;
	 }

	/**
   	 * Returns the address to the page
     *
     * @param NodeInterface $node
   	 * @return base path
  	 */
  	public function basePath($node){
   		$page = $this->parent;
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