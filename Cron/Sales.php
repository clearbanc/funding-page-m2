<?php

namespace Clearbanc\FundingPage\Cron;

class Sales
{
    protected $logger;

    protected $httpClientFactory;

    protected $authSession;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory,
        \Magento\Store\Model\Information $storeInfo,
        \Clearbanc\FundingPage\Helper\Calculator $calculator,
        \Magento\AdminNotification\Model\InboxFactory $inboxFactory
    ) {
        $this->logger = $logger;
        $this->_httpClientFactory = $httpClientFactory;
        $this->_storeInfo = $storeInfo;
        $this->calculator = $calculator;
        $this->_inboxFactory = $inboxFactory;
    }

    public function sendNotification()
    {
        $inboxCollection = $this->_inboxFactory->create()->getCollection();
        $title = "Congratulations! You've qualified for funding";
        $message = "Visit CLEARBANC.COM for more information.";
        $send = true;

        //foreach ($inboxCollection as $item) {
            //$notification = $item->getData();
            //if ($notification['title'] == $title && $notification['description'] == $message) {
                //$send = false;
                //break;
            //}
        //}
        if ($send) {
            $this->_inboxFactory->create()->addNotice($title, $message);
        }

        return $resultPage = $this->resultPageFactory->create();

    }

    /**
     * Send notification if account is qualified 
     * 
     * @return void
     */
    public function execute()
    {
        if ($this->calculator->isQualified()) {
            $this->logger->info('User qualified for funding: sending notification');
             $this->sendNotification();
        } else {
            $this->logger->info('User not yet qualified: will check in a week');
        }
    }
}
