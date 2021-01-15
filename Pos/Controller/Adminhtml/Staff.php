<?php

namespace Learning\Pos\Controller\Adminhtml;

use Magento\Backend\App\Action;

class Staff extends Action
{
    public function execute()
    {
        return $this->_authorization->isAllowed('Learning_Pos::staff');
    }
}
