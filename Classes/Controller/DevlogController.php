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
use DieMedialen\DmDeveloperlog\Domain\Repository\LogentryRepository;
use TYPO3\CMS\Core\Messaging\FlashMessage;
use TYPO3\CMS\Extbase\Mvc\View\ViewInterface;

class DevlogController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    protected $severityOptions = [
        -1 => 'OK',
        0 => 'INFO',
        1 => 'NOTICE',
        2 => 'WARNING',
        3 => 'ERROR',
    ];

    protected $extkeyOptions = [];

    /**
     * @var LogentryRepository
     */
    protected $logEntryRepository;

    /**
     * @param LogentryRepository $logEntryRepository
     */
    public function injectLogentryRepository(LogentryRepository $logEntryRepository)
    {
        $this->logEntryRepository = $logEntryRepository;
    }

    /**
     * Backend Template Container
     *
     * @var string
     */
    protected $defaultViewObjectName = \TYPO3\CMS\Backend\View\BackendTemplateView::class;

    /**
     * Set up the doc header properly here
     *
     * @param ViewInterface $view
     * @return void
     */
    protected function initializeView(ViewInterface $view)
    {
        /** @var BackendTemplateView $view */
        parent::initializeView($view);
        if ($this->actionMethodName == 'indexAction') {
            //$this->generateMenu();
            //$this->registerDocheaderButtons();
            $this->view->getModuleTemplate()->setFlashMessageQueue($this->controllerContext->getFlashMessageQueue());
        }
        if ($view instanceof \TYPO3\CMS\Backend\View\BackendTemplateView) {
            $pageRenderer = $view->getModuleTemplate()->getPageRenderer();
            $pageRenderer->loadJquery();
            $pageRenderer->loadRequireJsModule('bootstrap');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/ContextHelp');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/DocumentHeader');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/SplitButtons');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Backend/Modal');
            $pageRenderer->loadRequireJsModule('TYPO3/CMS/Lang/Lang');
            $pageRenderer->addCssFile('EXT:dm_developerlog/Resources/Public/Css/Developerlog.css');
        }
    }

    public function initializeIndexAction()
    {
        $this->extkeyOptions = $this->logEntryRepository->getExtensionKeys();
        $this->frontendUsers = $this->logEntryRepository->getFrontendUsers();
        $this->backendUsers = $this->logEntryRepository->getBackendUsers();
    }

    /**
     * Main action for list
     *
     * @param \DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint
     *
     * @ignorevalidation $constraint
     *
     * @return void
     */
    public function indexAction(\DieMedialen\DmDeveloperlog\Domain\Model\Constraint $constraint = null)
    {
        $this->view->assign('constraint', $constraint);
        $this->view->assign('severity-options', $this->severityOptions);
        $this->view->assign('extkey-options', $this->extkeyOptions);
        $this->view->assign('frontendUser', $this->frontendUsers);
        $this->view->assign('backendUsers', $this->backendUsers);
        $this->view->assign('logEntries', $this->logEntryRepository->findByConstraint($constraint));
    }

    /**
     * Delete all log entries
     * @return void
     */
    public function flushAction()
    {
        $this->logEntryRepository->removeAll();

        /** @var FlashMessage $message */
        $message = $this->getFlushFlashMessage();

        /** @var FlashMessageService $flashMessageService */
        $flashMessageService = $this->objectManager->get(\TYPO3\CMS\Core\Messaging\FlashMessageService::class);

        /** @var FlashMessageService $flashMessageService */
        $messageQueue = $flashMessageService->getMessageQueueByIdentifier('extbase.flashmessages.dm_developerlog.notifications');
        $messageQueue->addMessage($message);

        $this->redirect('index');
    }

    /**
     * @return FlashMessage $message
     */
    protected function getFlushFlashMessage()
    {
        return $this->objectManager->get(
            FlashMessage::class,
           $this->translate('controller.log.flushed'),
           $this->translate('controller.log.flushed.title'),
           FlashMessage::OK,
           true
        );
    }

    /**
     * Get a translated string
     * The second parameter is optional, and passed to vprintf.
     * As such it is expected to either be a string, or an array.
     *
     * @param string $key
     * @param mixed $sprintfParameters
     * @param mixed $vprintfParmeters
     *
     * @return string
     */
    protected function translate($key, $vprintfParmeters = '')
    {
        if ($vprintfParmeters != '' && !is_array($vprintfParmeters)) {
            $vprintfParmeters = [$vprintfParmeters];
        }
        return \TYPO3\CMS\Extbase\Utility\LocalizationUtility::translate($key, 'dm_developerlog', $vprintfParmeters);
    }
}
