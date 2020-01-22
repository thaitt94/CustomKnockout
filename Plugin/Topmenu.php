<?php

namespace Thai\Knockout1\Plugin;

use Magento\Framework\Data\Tree\NodeFactory;

class Topmenu
{
    protected $_nodeFactory;
    protected $_urlBuilder;

    public function __construct(
        NodeFactory $nodeFactory,
        \Magento\Framework\UrlInterface $urlBuilder
    ) 
    {
        $this->_nodeFactory = $nodeFactory;
        $this->_urlBuilder = $urlBuilder;
    }

    public function beforeGetHtml(
        \Magento\Theme\Block\Html\Topmenu $subject,
        $outermostClass = '',
        $childrenWrapClass = '',
        $limit = 0
    ) 
    {
          $node = $this->_nodeFactory->create(
            [
                'data' => [
                    'name' => __('Custom Ko'),
                    'id' => 'custom_ko',
                    'url' => $this->_urlBuilder->getUrl(null, ['_direct' =>'knock1/employee/index']),
                    'has_active' => false,
                    'is_active' => false
                    ],
                'idField' => 'id',
                'tree' => $subject->getMenu()->getTree()
            ]
        );
        $subject->getMenu()->addChild($node);
    }

}