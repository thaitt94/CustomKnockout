<?php

namespace Thai\Knockout1\Model\ResourceModel\Employee;

/*
 * Class tạo ra một collection cho module
 */
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected $_idFieldName = 'entity_id';

    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Thai\Knockout1\Model\Employee::class, 
            \Thai\Knockout1\Model\ResourceModel\Employee::class);
    }

}