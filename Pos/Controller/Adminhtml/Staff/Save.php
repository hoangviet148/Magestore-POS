<?php

namespace Learning\Pos\Controller\Adminhtml\Staff;

use Exception;
use Learning\Pos\Controller\Adminhtml\Staff;

class Save extends Staff
{
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data["password_confirmation"] !== $data["password"]) {
            $this->messageManager->addErrorMessage(__("Password confirm not same with password"));
            return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
        }

        if ($data) {
            if(isset($data['id'])) {
                $staffModel = $this->_objectManager->create(\Learning\Pos\Model\Staff::class);
                if(strlen($data['password']) == 0) {
                    unset($data["password"]);
                }
            } else {
                $staffModel = $this->_objectManager->create(\Learning\Pos\Model\Staff::class);
                if (strlen($data["password"]) === 0) {
                    $this->messageManager->addErrorMessage(__("Password require"));
                    return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
                }
            }
            $staffModel->setData($data);
            unset($staffModel["password_confirmation"]);
            unset($staffModel["form_key"]);
            try {
                $staffModel->save();
                $this->messageManager->addSuccessMessage(__("Staff was successfully save"));
            } catch (Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
            }
            if ($this->getRequest()->getParam("back") === 'edit') {
                return $resultRedirect->setPath('*/*/edit', ["id" => $this->getRequest()->getParam('id')]);
            }
            return $resultRedirect->setPath("*/*/");
        }

    }
}
