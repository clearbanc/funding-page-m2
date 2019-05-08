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

  // public getter for last30DaySum
  public function getLast30DaySum()
  {
    return $this->calculator->getlast30DaySum();
  }

  // public getter for orders
  public function getLast30DaysOrders()
  {
    return $this->calculator->getLast30DaysOrders();
  }

  // public getter for last30DaySum
  public function getLastYearSum()
  {
    return $this->calculator->getlastYearSum();
  }

  // public getter for orders
  public function getLastYearOrders()
  {
    return $this->calculator->getLastYearOrders();
  }

  public function getMinRevenue()
  {
    return $this->calculator::MIN_REVENUE;
  }

  public function isQualified()
  {
    return $this->calculator->getLast30DaySum() > $this->calculator::MIN_REVENUE;
  }
}
