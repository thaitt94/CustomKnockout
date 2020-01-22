<?php

namespace Thai\Knockout1\Block;

use Thai\Knockout1\Model\EmployeeFactory;
use Magento\Framework\App\Action\Action;
use Magento\Framework\View\Element\Template\Context;
use Magento\Framework\Serialize\SerializerInterface;

class Employee extends \Magento\Framework\View\Element\Template
{ 
    private $serializer;
    protected $_employeeFactory;

    public function __construct(
        Context $context,
        EmployeeFactory $employeeFactory,
        SerializerInterface $serializer,
        array $data = []
    )
    {
        $this->serializer = $serializer;
        $this->_employeeFactory = $employeeFactory;
        parent::__construct($context, $data);

    }

    public function encodeData($data) 
    {
        return $this->serializer->serialize($data);
    }

    public function getEmployeeJson()
    {
        $employeeData = [];
        $employees = $this->_employeeFactory->create()->getCollection()->setOrder('entity_id','DESC');
        foreach ($employees as $emp) {
            $employeeData[] = $emp->getData();
        }
        return $this->encodeData($employeeData);
    }
}