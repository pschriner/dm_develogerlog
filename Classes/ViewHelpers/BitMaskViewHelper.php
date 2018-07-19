<?php
namespace DieMedialen\DmDeveloperlog\ViewHelpers;

/**
 * This file is part of the dm_developerlog project.
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
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class BitMaskViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper implements CompilableInterface
{
    /**
     * @param int $value
     * @param array $mask
     * @return string
     */
    public function render($value = null, $mask = null)
    {
        return static::renderStatic(
            [
                'value' => $value,
                'mask' => $mask,
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
        $value = 0;
        if ($arguments['value'] === null) {
            try {
                $value = (int)$renderChildrenClosure();
            } catch (\Exception $e) {
            }
        } else {
            $value = max(0, (int)$arguments['value']);
        }

        $mask = [];
        $masked = [];
        if (!is_array($arguments['mask'])) {
            $max = is_int($arguments['mask']) ? intval($arguments['mask']) : PHP_INT_MAX;
            $i = 1;
            while ($i < $max) {
                $mask[] = $i;
                $i = $i * 2;
            }
        } else {
            $mask = array_map('intval', $arguments['mask']);
        }

        foreach ($mask as $v) {
            if ($v & $value) {
                $masked[] = $v;
            }
        }
        return $masked;
    }
}
