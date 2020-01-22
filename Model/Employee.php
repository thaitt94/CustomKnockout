<?php

namespace Thai\Knockout1\Model;

/*
 * Class có nhiệm vụ tương tác với db thông qua resource model
 */
class Employee extends \Magento\Framework\Model\AbstractModel
{
    protected function _construct()
    {
        $this->_init(\Thai\Knockout1\Model\ResourceModel\Employee::class);
    }
}