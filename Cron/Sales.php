<?php
namespace Clearbanc\FundingPage\Cron;

class Sales
{
  protected $logger;

  protected $_httpClientFactory;

  protected $authSession;

  public function __construct(
    \Psr\Log\LoggerInterface $logger,
    \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
    \Magento\Store\Model\Information $storeInfo,
    \Clearbanc\FundingPage\Helper\Calculator $calculator
  ) {
    $this->logger = $logger;
    $this->_httpClientFactory = $httpClientFactory;
    $this->_storeInfo = $storeInfo;
    $this->calculator = $calculator;
  }

  // make api request
  public function sendNotification() {
    $client = $this->_httpClientFactory->create();
    $client->setUri('http://localhost:3333/v3/magento-info');
    $client->setMethod(\Zend_Http_Client::POST);
    $client->setHeaders(\Zend_Http_Client::CONTENT_TYPE, 'application/json');
    $client->setHeaders('Accept', 'application/json');
    // $client->setHeaders("Authorization", "Bearer 1212121212121");
    $params = array();
    // $user = $this->authSession->getUser();
    // $params['firstName'] = $user->getFirstName();
    // $params['lastName'] = $user->getLastName();
    // $params['email'] = $user->getEmail();
    $params['last30DaySum'] = $this->calculator->getLast30DaySum();
    $client->setParameterPost($params); //json
    try {
      $response = $client->request();
      $this->logger->info('request sent my guy');
    } catch (Exception $e){
      $this->logger->info('theres an errrrrrrrror o shit');
    }
  }

  /**
   * Write to system.log
   * Send notification if account is qualified 
   * 
   * @return void
   */
  public function execute()
  {
    if ($this->calculator->isQualified()) {
      $this->logger->info('Qualified for funding');
      // $this->sendNotification();
    } else {
      $this->logger->info('Not yet qualified');
    }
  }
}
