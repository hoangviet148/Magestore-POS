<?php

namespace Learning\Pos\Controller\Adminhtml\Staff;

use Exception;
use Learning\Pos\Controller\Adminhtml\Staff;
use Learning\Pos\Model\Staff as StaffModel;

class Delete extends Staff
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $staffId = (int)$this->getRequest()->getParam('id');

        if($staffId > 0) {
            $staffModel = $this->_objectManager->create(StaffModel::class)->load($staffId);

            try {
                $staffModel->delete();
                $this->messageManager->addSuccessMessage(__("Staff was successfully deleted"));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
            }
        }
        return $resultRedirect->setPath("*/*/");
    }
}
