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
namespace Lof\Recaptcha\Test\Unit\Block;

use Lof\Recaptcha\Block\Recaptcha;

class RecaptchaTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Recaptcha
     */
    protected $_recaptcha;

    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_recaptcha = $objectManager->getObject(Recaptcha::class);
    }

    public function testRecaptchaExists()
    {
        $this->assertTrue(class_exists(Recaptcha::class));
    }

    public function testIsEnabled()
    {
        $this->assertNull($this->_recaptcha->isEnabled());
    }

    public function testGetSiteKey()
    {
        $this->assertNull($this->_recaptcha->getSiteKey());
    }
}