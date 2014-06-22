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
	    if($node->hasChildNodes($grammar)){
	      $kids = $node->getChildNodes($grammar);
	      return $kids[0];
	    }
	    if($node->getPrimaryChildNode()!=null){
	      if($node->getPrimaryChildNode()->getNodeType()->getName() == $grammar)
	        return $node->getPrimaryChildNode();
	      $stud = $this->textFinder($node->getPrimaryChildNode(),$grammar);
	      if($stud!=null){
	        return $stud;
	      }
	    }
	    if($node->hasChildNodes())
	     { 
	      $children = $node->getChildNodes();
	      foreach ($children as $k) {
	            $kid = $this->textFinder($k,$grammar);
	            if($kid != null)
	              return $kid;
	            }
	      }
	    return null;
	 }








}




?>