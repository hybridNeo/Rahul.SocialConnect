<?php
namespace Rahul\SocialConnect\Domain\Factory;
/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Rahul.SocialConnect".               *
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
 * Twitter Factory for instantiating the right Object type
 * Depending on the NodeType  create function returns a specific object
 * @Flow\Scope("singleton")
 */
class BloggerFactory extends Factory{
	
	/**
	 * Instantiates an object of the Blogger override class based on the specified nodetype
	 * deafaults to TwOverride
	 * @param string
	 * @return Rahul\SocialConnect\Domain\Override/TwOverride
	 */
	public function create(){
		return new \Rahul\SocialConnect\Domain\Override\BgOverride($this->node);
	
	}
}

?>