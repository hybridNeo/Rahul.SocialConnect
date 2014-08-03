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
use TYPO3\Flow\Resource\Publishing\ResourcePublisher;

/**
 * Default Override class for Twitter Post Parameters
 * Non Defined NodeTypes Default to this
 * @Flow\Scope("prototype")
 */
class BgOverride{
	/**
	 * @var NodeInterface
	 */
	protected $node;

	/**
	 * Headline nodename
	 */
	const HEADLINE = 'TYPO3.Neos.NodeTypes:Headline';

	/**
	 * Headline nodename
	 */
	const IMAGE = 'TYPO3.Neos.NodeTypes:Image';

	/**
	 * Text nodename
	 */
	const TEXT = 'TYPO3.Neos.NodeTypes:Text';

	/**
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
	}

	/**
	 * Returns the title for the blog post
	 * @return string
	 */
	 public function getHeadline(){
	 	$headNode = $this->textFinder($this->node,self::HEADLINE);
	 	if($headNode == null)
	 		$headNode = $this->node;
	 	return $headNode->getNodeData()->getFullLabel();
	 }

	/**
	 * @return string
	 */
	public function getContent(){
		$headNode = $this->textFinder($this->node,self::TEXT);
		if($headNode==null)
			$headNode = $headNode = $this->textFinder($this->node,self::HEADLINE);
		return $headNode->getNodeData()->getFullLabel();	
	}

	/**
  	 * Find the first Text Node matching the grammar description
   	 * @param NodeInterface $node
     * @param string $grammar
     * @return NodeInterface
     */
 	private function textFinder($node,$grammar){
	    $q = new FlowQuery(array($node));
    	$element = $q->find('[instanceof '.$grammar.']')->get(0);
     	return $element;
	 }







}










?>