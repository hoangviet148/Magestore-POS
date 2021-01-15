<?php

namespace Learning\Pos\Controller\Adminhtml\Staff;

use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultFactory;
use Learning\Pos\Controller\Adminhtml\Staff;
use Magento\Framework\Controller\ResultInterface;

class NewAction extends Staff
{
    /**
     * Method to add new record
     *
     * @return ResponseInterface|ResultInterface
     */
    public function execute()
    {
        $resultFoward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
        return $resultFoward->forward('edit');
    }
}
