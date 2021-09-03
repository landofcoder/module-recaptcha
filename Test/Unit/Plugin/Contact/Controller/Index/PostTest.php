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
namespace Lof\Recaptcha\Test\Unit\Plugin\Contact\Controller\Index;

use Lof\Recaptcha\Plugin\Contact\Controller\Index\Post;

class PostTest extends \PHPUnit_Framework_TestCase
{

    public function testExists()
    {
        $this->assertTrue(class_exists(Post::class));
    }
}