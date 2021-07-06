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
namespace Lof\Recaptcha\Test\Unit\Helper;

use Lof\Recaptcha\Helper\Data;

class DataTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @var Data
     */
    protected $_dataHelper;

    /**
     * Is called before running a test
     */
    protected function setUp()
    {
        $objectManager = new \Magento\Framework\TestFramework\Unit\Helper\ObjectManager($this);
        $this->_dataHelper = $objectManager->getObject(Data::class);
    }

    public function testExists()
    {
        $this->assertTrue(class_exists(Data::class));
    }

    public function testEnabled()
    {
        $this->assertNull($this->_dataHelper->isEnabled());
    }

    public function testSiteKey()
    {
        $this->assertNull($this->_dataHelper->getSiteKey());
    }

    public function testSecretKey()
    {
        $this->assertNull($this->_dataHelper->getSecretKey());
    }
}
