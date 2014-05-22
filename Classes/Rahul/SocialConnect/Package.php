<?php
namespace Rahul\SocialConnect;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "TYPO3.Neos".            *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU General Public License, either version 3 of the   *
 * License, or (at your option) any later version.                        *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */

use TYPO3\Flow\Core\Booting\Step;
use TYPO3\Flow\Core\Bootstrap;
use TYPO3\Flow\Package\Package as BasePackage;

/**
 * The TYPO3 Neos Package
 */
class Package extends BasePackage {

	/**
	 * @param \TYPO3\Flow\Core\Bootstrap $bootstrap The current bootstrap
	 * @return void
	 */
	public function boot(\TYPO3\Flow\Core\Bootstrap $bootstrap) {
		
//		require_once($this->packagePath . 'Resources/Private/PHP/Facebook/BaseFacebook.php');
		require_once($this->packagePath . 'Resources/Private/PHP/Facebook/Facebook.php');
		$dispatcher = $bootstrap->getSignalSlotDispatcher();
		$package = $this;
		$dispatcher->connect('TYPO3\Flow\Core\Booting\Sequence', 'afterInvokeStep', function(Step $step) use ($package, $bootstrap) {
		if ($step->getIdentifier() === 'typo3.flow:persistence') {
		$package->registerIndexingSlots($bootstrap);
					}
				 });
		  }
public function registerIndexingSlots(Bootstrap $bootstrap) {
	 $bootstrap->getSignalSlotDispatcher()->connect(  'TYPO3\Neos\Service\PublishingService', 'nodePublished','Rahul\SocialConnect\Service\Notification', 'sendSocialConnect');

  }
		
}
