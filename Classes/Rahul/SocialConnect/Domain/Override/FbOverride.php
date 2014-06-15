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
 * Default Override class for Facebook Post Parameters
 *
 * @Flow\Scope("prototype")
 */
class FbOverride{
	
	/**
 	 * @var array
 	 */	
	protected $settings;

	/**
	 * @var NodeInterface
	 */
	protected $node;

	/**
 	 * @var string 
 	 */	
	protected $link;
 	
 	/**
 	 * @var string 
 	 */	
	protected $caption;

	/**
 	 * @var string 
 	 */	
	protected $name;

	/**
 	 * @var string 
 	 */	
	protected $image;

	/**
 	 * @var string 
 	 */	
	protected $description;

	
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
	 * @param NodeInterface $node 
	 * Constructor
	 * @return void
	 */
	public function __construct($node){
		$this->node = $node;
	}

	/**
	 * An Initializer
	 * @return void
	 */
	public function init(){
		$this->caption = $this->settings['facebook']['caption'];
		$this->image = $this->settings['facebook']['image'];
		$this->description = $this->settings['facebook']['desc'];
		$this->link = $this->settings['facebook']['link'];
		$this->name = $this->settings['facebook']['name'];
		
	}

	

	/**
	 * Returns the caption
	 * @return string
	 */
	public function getCaption(){
		return $this->caption;
	}

	/**
	 * Returns the link
	 * @return string
	 */
	public function getLink(){
		return $this->link;
	}

	/**
	 * Returns the description
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * Returns the image
	 * @return string
	 */
	public function getImage(){
		return $this->image;
	}

	/**
	 * Returns the caption
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * Returns the content label
	 * @return string
	 */
	public function getContent(){
		$contentData =$this->node->getNodeData();
        $content = $contentData->getFullLabel();
		return $content;
	}

}













?>