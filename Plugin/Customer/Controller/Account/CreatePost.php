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

namespace Lof\Recaptcha\Plugin\Customer\Controller\Account;

use Magento\Framework\Controller\Result\RedirectFactory;
use Magento\Framework\Message\ManagerInterface;
use Lof\Recaptcha\Helper\Data;

class CreatePost
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
     * @param \Magento\Customer\Controller\Account\CreatePost $subject
     * @param \Closure $proceed
     * @return \Magento\Framework\Controller\Result\Redirect|mixed
     */
    public function aroundExecute(
        \Magento\Customer\Controller\Account\CreatePost $subject,
        \Closure $proceed
    ) {
        if ($this->dataHelper->isEnabled()) {
            $recaptchaResponse = $subject->getRequest()->getPost('g-recaptcha-response');

            if ($recaptchaResponse) {
                $verified = $this->dataHelper->verifyRecaptcha($recaptchaResponse);

                if ($verified) {
                    return $proceed();
                } else {
                    return $this->recaptchaError();
                }
            } else {
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
        $resultRedirect->setPath('customer/account/create');

        return $resultRedirect;
    }
}
