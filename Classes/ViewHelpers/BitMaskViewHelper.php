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
     
class BitMaskViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{
    /**
     * @param string $operator
     * @param int $value
     * @param array $mask
     * @param string $as
     * @return string
     */
    public function render($operator = '&', $value = NULL, $mask = array())
    {
        return static::renderStatic(
            array(
                'operator' => $operator,
                'value' => $value,
                'mask' => $mask
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
        $value = 0;
        if ($arguments['value'] === NULL) {
            try {
                $value = (int)$renderChildrenClosure();
            } catch (\Exception $e) {
                $value = 0;
            }
        } else {
            $value = (int)$arguments['value'];
        }
        $operator = '&';
        if (in_array($arguments['operator'],['&','|'])) {
            $operator = $arguments['operator'];
        }
        $masked = [];
        foreach ($arguments['mask'] as $v) {
            $v = (int)$v;
            if ($operator == '&') {
                if ($v & $value) {
                    $masked[] = $v;
                }
            }
            if ($operator == '|') {
                if ($v | $value) {
                    $masked[$v] = $v;
                }
            }
        }
        return $masked;
    }
}