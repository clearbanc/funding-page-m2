<?php
namespace Clearbanc\FundingPage\Test\Mock;

use Clearbanc\FundingPage\Helper\Calculator;

/**
 * Mocks the Calculator class to make it testable
 *
 */
class CalculatorMock extends Calculator
{
    /**
     * Update a protected variable via mock to test getter piece
     *
     * @param $num Number to set the 30 day sum to
     *
     * @return null
     */
    public function mockSetLast30DaySum($num)
    {
        $this->last30DaySum = $num;
    }
    /**
     * Mock updateData() to override existing one
     *
     * @return null
     */
    public function updateData()
    {
        return;
    }
}
