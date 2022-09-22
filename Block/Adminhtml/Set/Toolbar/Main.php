<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Block\Adminhtml\Set\Toolbar;

use Magento\Backend\Block\Template;
use Magento\Backend\Block\Widget\Button;

/**
 * Attribute set listing main container.
 */
class Main extends Template
{
    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _prepareLayout()
    {
        $this->getToolbar()->addChild(
            'addButton',
            Button::class,
            [
                'label' => __('Add Attribute Set'),
                'onclick' => 'setLocation(\'' . $this->getUrl('*/*/add') . '\')',
                'class' => 'add primary add-set',
            ]
        );

        return parent::_prepareLayout();
    }
}
