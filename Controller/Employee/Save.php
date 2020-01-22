<?php
namespace Thai\Knockout1\Controller\Employee;
 
use Thai\Knockout1\Model\EmployeeFactory;
use Magento\Framework\Exception\LocalizedException;
 
class Save extends \Magento\Framework\App\Action\Action
{
    protected $helper;
    protected $resultJsonFactory;
    protected $resultRawFactory;
    protected $_employeeFactory;
 
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Json\Helper\Data $helper,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\Controller\Result\RawFactory $resultRawFactory,
        EmployeeFactory $employeeFactory
    ) 
    {
        $this->_employeeFactory = $employeeFactory;
        $this->helper = $helper;
        $this->resultJsonFactory = $resultJsonFactory;
        $this->resultRawFactory = $resultRawFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $data = $data = $this->helper->jsonDecode($this->getRequest()->getContent());
        if(empty($data['entity_id'])){
            unset($data['entity_id']);
            $employee = $this->_employeeFactory->create();
        } else {
            $id  = $data['entity_id'];
            $employee = $this->_employeeFactory->create()->load($id);
            if($employee->getId()){
                $employee = $this->_employeeFactory->create()->load($id);
            }
        }
        $employee->setData($data);
        $save = $employee->save();
        if ($save) {
            $response[] = [
                'entity_id' => $employee->getId(),
                'department' => $employee->getDepartment(), 
                'full_name' => $employee->getFull_name(),
                'position' => $employee->getPosition(),
                'email' => $employee->getEmail(),
                'dob' => $employee->getDob(),
                'salary' => $employee->getSalary()
            ];
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($response,true);
    }
}