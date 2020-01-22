<?php
 
namespace Thai\Knockout1\Controller\Employee;

use Thai\Knockout1\Model\EmployeeFactory;
 
class Delete extends \Magento\Framework\App\Action\Action
{
    protected $_employeeFactory;
    protected $helper;
    protected $resultJsonFactory;
    protected $resultRawFactory;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        EmployeeFactory $employeeFactory
    ) 
    {
        parent::__construct($context);
        $this->_employeeFactory = $employeeFactory;
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
    }
    
    public function execute()
    {
        $employee = $this->_employeeFactory->create();
        $data = $this->getRequest()->getParams('data');
        $employee->load($data['entity_id'])->delete();
        
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($data);
    }
}