<?php
/**
 * Created by PhpStorm.
 * User: nikhilkuria
 * Date: 23/02/17
 * Time: 6:05 AM
 */

use PHPUnit\Framework\TestCase;

final class LoginTest extends TestCase{

    public function testOnePlusOne() {
        $this->assertEquals(1+1,2);
    }

    public function testSimpleLogin(){
        $service = \NikeAndPhp\Service\BasicNikeService::create();
        $this->assertNotNull($service);
    }
}