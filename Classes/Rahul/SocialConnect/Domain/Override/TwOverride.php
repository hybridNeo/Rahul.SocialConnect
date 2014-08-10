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
 	 * @var string 
 	 */	
	protected $tweet;

	/**
 	 * @var string 
 	 */	
	protected $image;


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
  	 * Find the array of Text Nodes matching the grammar description
   	 * @param NodeInterface $node
     * @param string $grammar
     * @return NodeInterface
     */
 	public function textFinder($node,$grammar){
	    $q = new FlowQuery(array($node));
    	$elements = $q->find('[instanceof '.$grammar.']');
    	$element = $this->findBest($elements,$node,$grammar);
     	return $element;
	 }
	 
	/**
	 * find the best match
	 * @param array $elements
	 * @param NodeInterface node
	 */
	private function findBest($elements,$node,$grammar){
	 	foreach ($elements as $element) {
	 		$parent = $element;
	 		while($parent->getNodeType()->getName() != $node->getNodeType()->getName()){
	 				$parent = $parent->getParent();
	 		}
	 		if($parent == $node)
	 			return $element;
	 	}
	 	return $elements->get(0);
	 }


	/**
	 * Finds an Image to represent the post returns Web friendly URL
	 * @return string
	 */
	public function getImage(){
		$node = $this->textFinder($this->node,self::IMAGE);
		if($this->settings['twitter']['image'] == '')
			return null;
		if($node != null){
			$img = $node->getProperty('image');
      		$res = $img->getResource();
     		$pub = new \TYPO3\Flow\Resource\Publishing\ResourcePublisher();
      		$this->image = $pub->getPersistentResourceWebUri($res);
      		return $this->image;
		}
		else{
			return null;
		}
	}


}




?>