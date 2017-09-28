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
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;

class MapToHelperClassViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    protected static $defaultSeverity = 0;

    protected static $map = [
        -1 => 'success',
        0 => 'info',
        1 => 'warning',
        2 => 'danger',
        3 => 'danger',
    ];

    /**
     * @param int $severity
     * @return string bootstrap color mapped value
     */
    public function render($severity = -2)
    {
        return static::renderStatic(
            [
                'severity' => $severity,
            ],
            $this->buildRenderChildrenClosure(),
            $this->renderingContext
        );
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return string
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $severity = null;
        if ($arguments['severity'] == -2 || !isset($arguments['severity'])) {
            try {
                $severity = (int)$renderChildrenClosure();
            } catch (\Exception $e) {
            }
        } else {
            $severity = (int)$arguments['severity'];
        }
        if (!isset(self::$map[$severity])) {
            $severity = self::$defaultSeverity;
        }
        return self::$map[$severity];
    }
}
