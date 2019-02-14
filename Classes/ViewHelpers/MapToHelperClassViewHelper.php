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
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3\CMS\Fluid\Core\ViewHelper\Facets\CompilableInterface;

class MapToHelperClassViewHelper extends AbstractViewHelper implements CompilableInterface
{
    protected static $defaultSeverity = 0;

    protected static $map = [
        -1 => 'success',
        0 => 'info',
        1 => 'warning',
        2 => 'danger',
        3 => 'danger',
    ];

    public function initializeArguments()
    {
        $this->registerArgument('severity', 'int', 'Log level severity (-1 to 3).', false);
    }

    /**
     * @param int $severity
     * @return string bootstrap color mapped value
     */
    public function render()
    {
        return static::renderStatic(
            [
                'severity' => $this->arguments['severity'],
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
