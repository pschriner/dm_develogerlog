<?php
namespace DieMedialen\DmDeveloperlog\Controller;

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
 
use TYPO3\CMS\Core\Imaging\IconFactory;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Backend\Template\Components\ButtonBar;
use TYPO3\CMS\Backend\Template\ModuleTemplate;
use TYPO3\CMS\Backend\View\BackendTemplateView;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;
 
class DevlogController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
        
    protected $severityOptions = [
        -1 => 'OK',
        0 => 'INFO',
        1 => 'NOTICE',
        2 => 'WARNING',
        3 => 'ERROR'
    ];
    
    /**
     * @var DieMedialen\DmDeveloperlog\Domain\Repository\LogentryRepository
     * @inject
     */
    protected $logEntryRepository;
    
    /**
     * Main action for list
     *
     * @param DieMedialen\DmDeveloperlog\Domain\Model\Constraint $search
     *
     * @return void
     */
    public function indexAction($constraint = NULL)
    {
        $this->view->assign('constraint', $constraint);
        $this->view->assign('severity-options', $this->severityOptions);
        $this->view->assign('logEntries', $this->logEntryRepository->findByConstraint($constraint));
    }
    
    public function flushAction()
    {
        $this->logEntryRepository->removeAll();
        $this->addFlashMessage('TEST', 'Ok - Title for OK message', FlashMessage::OK, true);
        $this->redirect('index');
    }
 }