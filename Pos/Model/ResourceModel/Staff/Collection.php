<?php

namespace Learning\Pos\Model\ResourceModel\Staff;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Learning\Pos\Model\Staff as Model;
use Learning\Pos\Model\ResourceModel\Staff as ResourceModel;
class Collection extends AbstractCollection
{
    protected $_idFieldName = 'id';

    protected function _construct()
    {
        parent::_construct();
        $this->_init(Model::class, ResourceModel::class);
    }
}
