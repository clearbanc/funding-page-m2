<?php

namespace Clearbanc\FundingPage\Model\System\Message;

class QualifiedMessage implements \Magento\Framework\Notification\MessageInterface
{

    const MESSAGE_IDENTITY = 'clearbanc_system_message';
    public function getIdentity()
    {
        // Retrieve unique message identity
        return self::MESSAGE_IDENTITY;
    }

    public function isDisplayed()
    {
        // Return true to show your message, false to hide it
        return false;
    }

    public function getText()
    {
        return 'Text';
        // Retrieve message text
        //return 'Notification message text goes here';
    }

    public function getSeverity()
    {
        // Possible values: SEVERITY_CRITICAL, SEVERITY_MAJOR, SEVERITY_MINOR, SEVERITY_NOTICE
        return self::SEVERITY_NOTICE;
    }
}
