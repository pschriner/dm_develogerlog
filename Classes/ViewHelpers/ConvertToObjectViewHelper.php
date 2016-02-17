<?php

namespace DieMedialen\DmDeveloperlog\ViewHelpers;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */
 
use \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
 
class ConvertToObjectViewHelper extends AbstractViewHelper
{

    /**
     * @param string $classname
     * @param int uid
     * @param mixed as
     */
    public function render($classname, $uid, $as) {
        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);
        $backendUserRepository = $objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository::class);
        /** @var $user \TYPO3\CMS\Extbase\Domain\Model\BackendUser */
        $value = $backendUserRepository->findByUid($uid);
        $this->templateVariableContainer->add($as, $value);
        $output = $this->renderChildren();
        $this->templateVariableContainer->remove($as);
        return $output;
    }
}