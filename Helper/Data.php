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
 * @package    Lof_Recaptcha
 * @copyright  Copyright (c) 2021 Landofcoder (https://landofcoder.com/)
 * @license    https://landofcoder.com/LICENSE-1.0.html
 */

namespace Lof\Recaptcha\Helper;

use Magento\Store\Model\ScopeInterface;
use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;

class Data extends AbstractHelper
{

    /**
     * Data constructor.
     * @param Context $context
     */
    public function __construct(Context $context)
    {
        parent::__construct($context);
    }

    /**
     * Is module enabled
     *
     * @param null $storeId
     * @return boolean
     */
    public function isEnabled($storeId = null)
    {
        return $this->scopeConfig->getValue('lof_recaptcha/settings/enabled', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get the site key
     *
     * @param null $storeId
     * @return string
     */
    public function getSiteKey($storeId = null)
    {
        return $this->scopeConfig->getValue('lof_recaptcha/settings/site_key', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get the secret key
     *
     * @param null $storeId
     * @return string
     */
    public function getSecretKey($storeId = null)
    {
        return $this->scopeConfig->getValue('lof_recaptcha/settings/secret_key', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get the scores
     *
     * @param null $storeId
     * @return string
     */
    public function getIsCheckScores($storeId = null)
    {
        return $this->scopeConfig->getValue('lof_recaptcha/settings/is_check_scores', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Get the scores
     *
     * @param null $storeId
     * @return string
     */
    public function getScores($storeId = null)
    {
        return $this->scopeConfig->getValue('lof_recaptcha/settings/scores', ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * Verify Captcha
     * @param string $recaptchaResponse
     * @param string|null $storeId
     * @param string|null $remoteIp
     * @return string
     */
    public function verifyRecaptcha($recaptchaResponse = "", $storeId = null, $remoteIp=null){
        $secretKey = $this->getSecretKey($storeId);
        $remoteIp = $remoteIp?$remoteIp:$_SERVER['REMOTE_ADDR'];
        $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=" .
            $secretKey . "&response=" . $recaptchaResponse . "&remoteip=" . $remoteIp);
        $result = json_decode($response, true);

        $verified = false;

        if (isset($result['success']) && $result['success']) {
           $isCheckScores = $this->getIsCheckScores($storeId);
           if($isCheckScores && isset($result["score"])){
                $scores = $this->getScores($storeId);
                if((float)$result['score'] >= (float)$scores){
                    $verified = true;
                }
           }else {
               $verified = true;
           }
        }

        return $verified;
    }
}