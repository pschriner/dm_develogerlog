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
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;
     
class BitMaskViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper implements CompilableInterface
{
    /**
     * @param string $operator
     * @param int $value
     * @param array $mask
     * @return string
     */
    public function render($operator = '&', $value = NULL, $mask = NULL)
    {
        if (!in_array($operator, ['&','|'])) {
            throw new \UnexpectedValueException('Argument $operator has to be & or |', 1455117117);
        }
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
                ;
            }
        } else {
            $value = (int)$arguments['value'];
        }

        $operator = $arguments['operator'];

        $mask = array();
        $masked = [];
        if ($arguments['mask'] === NULL) {
            $max = PHP_INT_MAX;
            $i = 1;
            while ($i < $max) {
                $mask[] = $i;
                $i = $i*2;
            }
        } else {
            $mask = array_map('intval', $arguments['mask']);
        }

        foreach ($mask as $v) {
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