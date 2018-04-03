<?php

namespace Hotrush\Tests\Stores;

use \Hotrush\Stores\ErrorsStore;
use \Hotrush\Events\Error;
use \PHPUnit\Framework\TestCase;

/**
 * Test Case for @see \Hotrush\Stores\ErrorsStore
 */
final class ErrorsStoreTest extends TestCase
{

    /**
     * @covers \Hotrush\Stores\ErrorsStoreTest::register
     * @covers \Hotrush\Stores\ErrorsStoreTest::list
     */
    public function testCaptureErrorExceptionAndListIt()
    {
        $store = new ErrorsStore();
        $error = new Error(new \Error('unit-test'));

        // Must be Empty
        $this->assertTrue($store->isEmpty());

        // Store the Error and Check that it's "stored"
        $store->register($error);
        $list = $store->list();

        $this->assertEquals(count($list), 1);

        // Must not be Empty
        $this->assertFalse($store->isEmpty());
    }

}
