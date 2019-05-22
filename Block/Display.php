<?php

namespace Clearbanc\FundingPage\Block;

class Display extends \Magento\Framework\View\Element\Template
{
    protected $calculator;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Clearbanc\FundingPage\Helper\Calculator $calculator,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Magento\Backend\Model\Auth\Session $authSession,
        array $data = []
    ) {
        $this->calculator = $calculator;
        $this->authSession = $authSession;
        $this->_httpClientFactory = $httpClientFactory;
        parent::__construct($context, $data);
    }

    /**
     * Public getter for last30DaySum
     *
     * @return getLast30DaySum
     */
    public function getLast30DaySum()
    {
        return $this->calculator->getlast30DaySum();
    }

    /**
     *  Public getter for orders
     *
     * @return getLast30DaysOrders
     */
    public function getLast30DaysOrders()
    {
        return $this->calculator->getLast30DaysOrders();
    }

    /**
     *  Public getter for getLastYearSum
     *
     * @return getlastYearSum()
     */
    public function getLastYearSum()
    {
        return $this->calculator->getlastYearSum();
    }

    /**
     *  Public getter for orders
     *
     * @return getLastYearOrders()
     */
    public function getLastYearOrders()
    {
        return $this->calculator->getLastYearOrders();
    }

    /**
     *  Public getter for getMinRevenue
     *
     * @return calculator::MIN_REVENUE()
     */
    public function getMinRevenue()
    {
        return $this->calculator::MIN_REVENUE;
    }

    /**
     *  Public getter for isQualified
     *
     * @return true if the admin meets the minimum revenue criteria else false
     */
    public function isQualified()
    {
        return $this->calculator->getLast30DaySum() > $this->calculator::MIN_REVENUE;
    }
}
