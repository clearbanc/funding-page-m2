<?php
namespace Clearbanc\FundingPage\Controller\Adminhtml\Status;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    /**
     * Constructor
     *
     * @param \Magento\Backend\App\Action\Context $actionContext
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\AdminNotification\Model\InboxFactory $inboxFactory,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->date = $date;
        $this->_inboxFactory = $inboxFactory;
    }

    /**
     * Load the page defined in view/adminhtml/layout/fundingpage_status_index.xml
     *
     * @return \Magento\Framework\View\Result\Page
     */
    public function execute()
    {
        // TESTING-- following code dispatches event
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $order =$this->calculator->last30DayOrders()->getLastItem();
        // $textDisplay = new \Magento\Framework\DataObject(array('order' => order));
        // $this->_eventManager->dispatch('mageplaza_helloworld_display_text', ['order' => $order]);

        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $order = $objectManager->get('\Magento\Sales\Model\Order')->loadByIncrementId('100000001');
        // $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        // $order = $objectManager->get('\Magento\Sales\Model\Order')->getCollection()->getLastItem();
        // // $order = $objectManager->get('\Magento\Sales\Model\Order')->loadByIncrementId('100000080');
        // $this->_eventManager->dispatch('sales_order_place_after', array('order'=>$order));
        // // END OF TEST

        // TESTING-- following code adds admin notification message
        // $this->_inboxFactory->create()->addNotice(__('CLEAR B A N C BABYYYYYY'), __('son u bout to get some cash and spice up ur store'), __('https://clearbanc.com'));

        $inboxCollection = $this->_inboxFactory->create()->getCollection();
        $title = "Congratulations! You've qualified for funding";
        $message = "Visit www.clearbanc.com for more information.";
        $send = true;

        foreach ($inboxCollection as $item) {
            $notification = $item->getData();
            if ($notification['title'] == $title && $notification['description'] == $message) {
                $send = false;
                break;
            }
        }
        if ($send) {
            $this->_inboxFactory->create()->addNotice($title, $message);
        }

        return $resultPage = $this->resultPageFactory->create();
    }
}
