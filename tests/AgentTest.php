<?php

namespace Hotrush\Tests;

use \Hotrush\Agent;
use \PHPUnit\Framework\TestCase;

/**
 * Test Case for @see \Hotrush\Agent
 */
final class AgentTest extends TestCase
{

    /**
     * @covers \Hotrush\Agent::__construct
     * @covers \Hotrush\Agent::startTransaction
     * @covers \Hotrush\Agent::stopTransaction
     * @covers \Hotrush\Agent::getTransaction
     */
    public function testStartAndStopATransaction()
    {
        $agent = new Agent(['appName' => 'phpunit_1']);

        // Create a Transaction, wait and Stop it
        $name = 'trx';
        $agent->startTransaction($name);
        usleep(10);
        $agent->stopTransaction($name);

        $duration = $agent->getTransaction($name)->getDuration();

        $this->assertGreaterThanOrEqual(10, $duration);
    }

    /**
     * @depends testStartAndStopATransaction
     *
     * @expectedException \Hotrush\Exception\Transaction\UnknownTransactionException
     *
     * @covers  \Hotrush\Agent::__construct
     * @covers  \Hotrush\Agent::getTransaction
     */
    public function testForceErrorOnUnknownTransaction()
    {
        $agent = new Agent(['appName' => 'phpunit_x']);

        // Let it go boom!
        $agent->getTransaction('unknown');
    }

    /**
     * @depends testForceErrorOnUnknownTransaction
     *
     * @expectedException \Hotrush\Exception\Transaction\UnknownTransactionException
     *
     * @covers  \Hotrush\Agent::__construct
     * @covers  \Hotrush\Agent::stopTransaction
     */
    public function testForceErrorOnUnstartedTransaction()
    {
        $agent = new Agent(['appName' => 'phpunit_2']);

        // Stop an unstarted Transaction and let it go boom!
        $agent->stopTransaction('unknown');
    }

}
