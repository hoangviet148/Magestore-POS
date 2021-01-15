<?php

namespace Learning\Pos\Controller\Adminhtml\Staff;

use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\Session;
use Magento\Framework\App\ResponseInterface;
use Learning\Pos\Controller\Adminhtml\Staff as Staff;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Edit extends Staff
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    /**
     * Method execute to implement of logic edit staff
     *
     * @return ResponseInterface|Redirect|ResultInterface|Page
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $model = $this->_objectManager->create(\Learning\Pos\Model\Staff::class);
        $registryObject = $this->_objectManager->get(Registry::class);

        if ($id) {
            $model = $model->load($id);

            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__("This staff no longer not exists"));
                return $resultRedirect->setPath('staff/*/', ['_current' => true]);
            }
        }
        $data = $this->_objectManager->get(Session::class)->getFormData(true);
        // die('Stop Here'); - OK
        if (!empty($data)) {
            $model->setData($data);
        }
        // die('Stop Here'); - OK
        $registryObject->register('current_staff', $model);
        $resultPage = $this->resultPageFactory->create();
//       var_dump($model->getId());
//       die('Stop Here');
        if ($model->getId()) {
            //die('Stop Here');
            $pageTitle = __("EDIT STAFF " . $model->getName());

        } else {
            $pageTitle = __("NEW STAFF");

        }
        //die('Stop Here');

        $resultPage->getConfig()->getTitle()->prepend($pageTitle);

        return $resultPage;
    }
}
