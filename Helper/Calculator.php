<?php
namespace Clearbanc\FundingPage\Helper;

use \Magento\Framework\App\Helper\AbstractHelper;

class Calculator extends AbstractHelper
{
    const MIN_REVENUE = 10000;

    /** @var \Magento\Sales\Model\ResourceModel\Order\CollectionFactory */
    protected $_orderCollectionFactory;

    /** @var \Magento\Sales\Model\ResourceModel\Order\Collection */
    protected $last30DayOrders;

    /** @var \Magento\Sales\Model\ResourceModel\Order\Collection */
    protected $lastYearOrders;
    protected $someVar;

    protected $last30DaySum = 0.00;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Sales\Model\ResourceModel\Order\CollectionFactory $_orderCollectionFactory
    ) {
        $this->_orderCollectionFactory = $_orderCollectionFactory;
        parent::__construct($context);
    }

    protected function setLast30DaySum($orders)
    {
        $sum = 0.00;
        foreach ($orders as $key => $value) {
            $order = $value->getData();
            if (isset($order['grand_total'])) {
                $sum = $sum + (float)$order['grand_total'];
            }
        }
        $this->last30DaySum = $sum;
    }

    // public getter for last30DaySum
    public function getLast30DaySum()
    {
        if (!$this->last30DaySum) {
            $this->setLast30DaySum($this->last30DayOrders);
        }
        return $this->last30DaySum;
    }

    // update Orders
    protected function setLast30DaysOrders()
    {
        // set date ranges for order collection search
        $to = date("Y-m-d h:i:s"); // current date
        $from = strtotime('-30 day', strtotime($to));
        $from = date('Y-m-d h:i:s', $from); // 30 days before

        // get orders from set dates
        $this->last30DayOrders = $this->_orderCollectionFactory->create()
             ->addFieldToSelect('*')
             ->addFieldToFilter('created_at', ['gteq' => $from])
             ->addFieldToFilter('created_at', ['lteq' => $to]);
    }

    // public getter for orders
    public function getLast30DaysOrders()
    {
        if (!$this->last30DayOrders) {
            // update order information
            $this->setLast30DaysOrders();

            $this->setLast30DaySum($this->last30DayOrders);
        }

        return $this->last30DayOrders;
    }

    public function setLastYearOrders()
    {
        // set date ranges for order collection search
        $to = date("Y-m-d h:i:s"); // current date
        $from = strtotime('-1 year', strtotime($to));
        $from = date('Y-m-d h:i:s', $from); // 30 days before

        // get orders from set dates
        $this->lastYearOrders = $this->_orderCollectionFactory->create()
             ->addFieldToSelect('*')
             ->addFieldToFilter('created_at', ['gteq' => $from])
             ->addFieldToFilter('created_at', ['lteq' => $to]);
    }

    // public getter for orders
    public function getLastYearOrders()
    {
        if (!$this->lastYearOrders) {
            // update order information
            $this->setLastYearOrders();
        }
        return $this->lastYearOrders;
    }

    public function isQualified() 
    {
        $this->updateData();
        return $this->last30DaySum > $this::MIN_REVENUE;
    }

    public function updateData()
    {
        $this->setLast30DaysOrders();
        $this->setLast30DaySum($this->last30DayOrders);
        $this->setLastYearOrders();
    }
}

