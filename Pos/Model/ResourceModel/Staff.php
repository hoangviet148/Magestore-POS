<?php

namespace Learning\Pos\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Staff extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('pos_staff', 'id');
    }
}
