<?php

namespace Thai\Knockout1\Model\ResourceModel;

use Magento\Framework\Model\AbstractModel;

class Employee extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('employee_knock', 'entity_id');
    }

}