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
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
     
class MapToHelperClassViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    
    static protected $map = [
        -1 => 'success',
        0 => 'info',
        1 => 'warning',
        2 => 'danger',
        3 => 'danger'
    ];
    
    /**
     * @param int $severity 
     * @return string bootstrap color mapped value
     */
    public function render($severity = -2)
    {
        return static::renderStatic(
            array(
                'severity' => $severity,
            ),
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
        $severity = 0;
        if ($arguments['severity'] == -2) {
            try {
                $severity = (int)$renderChildrenClosure();
            } catch (Exception $e) {
                $severity = 0;
            }
        } else {
            $severity = (int)$arguments['severity'];
        }
        if (isset(self::$map[$severity])) {
            return self::$map[$severity];
        } else {
            return self::$map[0];
        }
        
    }
}