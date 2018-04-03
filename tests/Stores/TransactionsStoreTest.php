<?php

namespace Hotrush\Tests\Stores;

use \Hotrush\Stores\TransactionsStore;
use \Hotrush\Events\Transaction;
use \PHPUnit\Framework\TestCase;

/**
 * Test Case for @see \Hotrush\Stores\TransactionsStore
 */
final class TransactionsStoreTest extends TestCase
{

    /**
     * @covers \Hotrush\Stores\TransactionsStore::register
     * @covers \Hotrush\Stores\TransactionsStore::get
     */
    public function testTransactionRegistrationAndFetch()
    {
        $store = new TransactionsStore();
        $name = 'test';
        $trx = new Transaction($name);

        // Must be Empty
        $this->assertTrue($store->isEmpty());

        // Store the Transaction and fetch it then
        $store->register($trx);
        $proof = $store->fetch($name);

        // We should get the Same!
        $this->assertEquals($trx, $proof);
        $this->assertNotNull($proof);

        // Must not be Empty
        $this->assertFalse($store->isEmpty());
    }

    /**
     * @depends testTransactionRegistrationAndFetch
     *
     * @expectedException \Hotrush\Exception\Transaction\DuplicateTransactionNameException
     *
     * @covers  \Hotrush\Stores\TransactionsStore::register
     */
    public function testDuplicateTransactionRegistration()
    {
        $store = new TransactionsStore();
        $name = 'test';
        $trx = new Transaction($name);

        // Store the Transaction again to force an Exception
        $store->register($trx);
        $store->register($trx);
    }

    /**
     * @depends testTransactionRegistrationAndFetch
     *
     * @covers  \Hotrush\Stores\TransactionsStore::get
     */
    public function testFetchUnknownTransaction()
    {
        $store = new TransactionsStore();
        $this->assertNull($store->fetch('unknown'));
    }

}
