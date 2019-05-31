<?php

namespace Clearbanc\FundingPage\Test\Unit;

use Clearbanc\FundingPage\Test\Mock\CalculatorMock;

class CalculatorTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $contextMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $orderCollectionFactoryMock;

    /**
     * @var \PHPUnit_Framework_MockObject_MockObject
     */
    private $orderMock;

    function setUp()
    {

        $this->contextMock
            = $this->getMockBuilder(\Magento\Framework\App\Helper\Context::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->orderCollectionFactoryMock
            = $this->getMockBuilder(\Magento\Sales\Model\ResourceModel\Order\CollectionFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['create'])
            ->getMock();

        $this->orderMock = $this->getMockBuilder(\Magento\Sales\Model\Order::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $this->orderConfigMock = $this->getMockBuilder(\Magento\Sales\Model\Order\Config::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->calcMock = new CalculatorMock($this->contextMock, $this->orderCollectionFactoryMock);
    }

    /**
     * @test   Qualification logic within Calculator for the nightly job
     * @return null
     */
    public function testQualification() 
    {
        // assert that 10k minimum is set for qualification
        $this->assertEquals(CalculatorMock::MIN_REVENUE, 10 * 1000);

        // set a mock revenue of 30k
        // assert that getLast30DaySum returns the correct amount
        $mockRevenue = 30 * 1000;
        $this->calcMock->mockSetLast30DaySum($mockRevenue);
        $this->assertNotNull($this->calcMock->getLast30DaySum());
        $this->assertEquals($this->calcMock->getLast30DaySum(), $mockRevenue);
        
        // assert that 30k qualifies
        $this->assertTrue($this->calcMock->isQualified());

        // assert that 5k revenue fails to qualify
        $mockRevenue = 5 * 1000;
        $this->calcMock->mockSetLast30DaySum($mockRevenue);
        $this->assertNotNull($this->calcMock->getLast30DaySum());
        $this->assertFalse($this->calcMock->isQualified());
    }
}
