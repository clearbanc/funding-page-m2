<?php

namespace Clearbanc\FundingPage\Observer;

use Magento\Framework\Event\ObserverInterface;


class OrderData implements ObserverInterface
{
  protected $calculator;

  public function __construct(
    \Clearbanc\FundingPage\Helper\Calculator $calculator,
    \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
  ) {
    $this->calculator = $calculator;
    $this->_httpClientFactory = $httpClientFactory;
  }

  public function execute(\Magento\Framework\Event\Observer $observer)
  {
    // TODO- what to do with received order info?
    // $order = $observer->getEvent()->getOrder();
    // var_dump($order->getId());

    // send api request to clearbanc to store sale data 
    // $this->sendRequest();
    // $client = $this->_httpClientFactory->create();
    // $client->setUri('http://localhost:3333/v3/salesorder');
    // $client->setMethod(\Zend_Http_Client::POST);
    // $client->setHeaders(\Zend_Http_Client::CONTENT_TYPE, 'application/json');
    // $client->setHeaders('Accept', 'application/json');
    
    // $order = json_encode($observer->getEvent()->getOrder());
    // if (!$order){
    //   var_dump('no order bitchhhhh');
    // }
    // // var_dump($order);
    // $client->setParameterPost($order); //json
    // $response = $client->request();
    // $json = json_decode($response->getBody(), true);
    return;
  }
}
