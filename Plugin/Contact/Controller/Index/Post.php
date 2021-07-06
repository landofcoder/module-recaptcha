<?php
/**
 * Landofcoder
 * 
 * NOTICE OF LICENSE
 * 
 * This source file is subject to the Landofcoder.com license that is
 * available through the world-wide-web at this URL:
 * https://landofcoder.com/license
 * 
 * DISCLAIMER
 * 
 * Do not edit or add to this file if you wish to upgrade this extension to newer
 * version in the future.
 * 
 * @category   Landofcoder
 * @package    Lof_Gallery
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */
namespace Lof\Recaptcha\Plugin\Contact\Controller\Index;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Lof\Recaptcha\Helper\Data;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\App\ObjectManager;

class Post
{

    /**
     * @var RedirectFactory
     */
    protected $resultRedirectFactory;

    /**
     * @var ManagerInterface
     */
    protected $messageManager;

    /**
     * @var Data
     */
    protected $dataHelper;

    /**
     * Post constructor.
     * @param RedirectFactory $resultRedirectFactory
     * @param ManagerInterface $messageManager
     * @param Data $dataHelper
     */
    public function __construct(
        RedirectFactory $resultRedirectFactory,
        ManagerInterface $messageManager,
        Data $dataHelper
    ) {
        $this->resultRedirectFactory = $resultRedirectFactory;
        $this->messageManager = $messageManager;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Execute around post
     *
     * @param \Magento\Contact\Controller\Index\Post $subject
     * @param \Closure $proceed
     * @return \Magento\Framework\Controller\Result\Redirect|mixed
     */
    public function aroundExecute(
        \Magento\Contact\Controller\Index\Post $subject,
        \Closure $proceed
    ) {
        if ($this->dataHelper->isEnabled()) {
            $request = $subject->getRequest();
            $recaptchaResponse = $request->getPost('g-recaptcha-response');

            $hasError = false;

            if ($recaptchaResponse) {
                $verified = $this->dataHelper->verifyRecaptcha($recaptchaResponse);
                if ($verified) {
                    return $proceed();
                } else {
                    $hasError = true;
                }
            } else {
                $hasError = true;
            }

            if ($hasError) {
                $dataPersistor = ObjectManager::getInstance()->get(DataPersistorInterface::class);
                $post = $request->getPostValue();
                $dataPersistor->set('contact_us', $post);

                return $this->recaptchaError();
            }
        }

        return $proceed();
    }

    /**
     * Recaptcha Error
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    protected function recaptchaError(): \Magento\Framework\Controller\Result\Redirect
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $this->messageManager->addErrorMessage(__('There was an error with the Recaptcha, please try again.'));
        $resultRedirect->setPath('contact/index');

        return $resultRedirect;
    }
}
