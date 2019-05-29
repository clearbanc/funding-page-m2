<?php

namespace Clearbanc\FundingPage\Cron;

class Sales
{
    protected $logger;

    protected $httpClientFactory;

    protected $authSession;

    /**
     * Contructor for Cron
     *
     * @param \Psr\Log\LoggerInterface $logger
     * @param \Magento\Framework\HTTP\ZendClientFactory $httpClientFactory
     * @param \Magento\Store\Model\Information $storeInfo
     * @param \Clearbanc\FundingPage\Helper\Calculator $calculator
     * @param \Magento\AdminNotification\Model\InboxFactory $inboxFactory
     */
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

    /**
     * Function to send notification to the user if they qualify
     *
     * @return void
     */
    public function sendNotification()
    {
        $inboxCollection = $this->_inboxFactory->create()->getCollection();
        $title = "Congratulations! You've qualified for funding";
        $message = "Visit CLEARBANC.COM for more information.";
        $send = true;

        // TODO add this back once everything is validated
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
    }

    /**
     * Execute the cron job for clearbanc funding status
     * 
     * @return void
     */
    public function execute()
    {
        if ($this->calculator->isQualified()) {
            $this->logger->info('User qualified for funding: sending notification');
             $this->sendNotification();
        } else {
            $this->logger->info('User not yet qualified: will check again in couple weeks');
        }
    }
}
