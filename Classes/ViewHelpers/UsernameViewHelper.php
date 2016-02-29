<?php
namespace DieMedialen\DmDeveloperlog\ViewHelpers;

/*
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

use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

/**
 * Get username from backend user id
 * @internal
 */
class UsernameViewHelper extends AbstractViewHelper implements CompilableInterface
{
    /**
     * First level cache of user names
     *
     * @var array
     */
    protected static $usernameRuntimeCache = array();

    /**
     * Resolve user name from backend user id.
     *
     * @param int $uid Uid of the user
     * @param mixed $backend
     * @return string Username or an empty string if there is no user with that UID
     */
    public function render($uid, $backend = TRUE)
    {
        return static::renderStatic(
            array(
                'uid' => $uid,
                'backend' => $backend
            ),
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param callable $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     *
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $uid = $arguments['uid'];
        $backendOrFrontend = !empty($arguments['backend']) ? 'be' : 'fe';

        $userKey = $backendOrFrontend . '-' .$uid;

        if (isset(static::$usernameRuntimeCache[$userKey])) {
            return htmlspecialchars(static::$usernameRuntimeCache[$userKey]);
        }

        $objectManager = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\Object\ObjectManager::class);

        if ($backendOrFrontend == 'be') {
            $backendUserRepository = $objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\BackendUserRepository::class);
            /** @var $user \TYPO3\CMS\Extbase\Domain\Model\BackendUser */
            $user = $backendUserRepository->findByUid($uid);
        } else {
            $frontendUserRepository = $objectManager->get(\TYPO3\CMS\Extbase\Domain\Repository\FrontendUserRepository::class);
            /** @var $user \TYPO3\CMS\Extbase\Domain\Model\FrontendUser */
            $user = $frontendUserRepository->findByUid($uid);
        }
        // $user may be NULL if user was deleted from DB, set it to empty string to always return a string
        static::$usernameRuntimeCache[$userKey] = ($user === null) ? '' : $user->getUserName();
        return htmlspecialchars(static::$usernameRuntimeCache[$userKey]);
    }
}
