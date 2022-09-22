<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Block\Adminhtml\Attribute;

use Magento\Backend\Block\Widget\Context;
use Magento\Backend\Block\Widget\Form\Container;
use Magento\Framework\Registry;

/**
 * Entity attribute edit block.
 *
 * @SuppressWarnings(PHPMD.CamelCasePropertyName)
 */
class Edit extends Container
{
    /**
     * Core registry
     */
    private Registry $coreRegistry;

    /**
     * Constructor.
     *
     * @param Context $context  Block context.
     * @param Registry $registry Registry.
     * @param array $data Additional data.
     */
    public function __construct(
        Context $context,
        Registry $registry,
        array $data = []
    ) {
        $this->coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * @inheritdoc
     */
    public function addButton($buttonId, $data, $level = 0, $sortOrder = 0, $region = 'toolbar')
    {
        if ($this->getRequest()->getParam('popup')) {
            $region = 'header';
        }
        return parent::addButton($buttonId, $data, $level, $sortOrder, $region);
    }

    /**
     * @inheritdoc
     */
    public function getHeaderText()
    {
        $headerText = (string) __('New Attribute');

        if ($this->coreRegistry->registry('entity_attribute')->getId()) {
            $frontendLabel = $this->coreRegistry->registry('entity_attribute')->getFrontendLabel();
            if (is_array($frontendLabel)) {
                $frontendLabel = $frontendLabel[0];
            }
            $headerText = (string) __('Edit Attribute "%1"', $this->escapeHtml($frontendLabel));
        }

        return $headerText;
    }

    /**
     * Retrieve URL for validation
     */
    public function getValidationUrl(): string
    {
        return $this->getUrl('*/*/validate', ['_current' => true]);
    }

    /**
     * Retrieve URL for save
     */
    public function getSaveUrl(): string
    {
        return $this->getUrl('*/*/save', ['_current' => true, 'back' => null]);
    }

    /**
     * @inheritdoc
     * @SuppressWarnings(PHPMD.CamelCaseMethodName)
     */
    protected function _construct()
    {
        parent::_construct();

        $this->buttonList->update('save', 'label', (string) __('Save Attribute'));
        $this->buttonList->update('delete', 'label', (string) __('Delete Attribute'));

        $this->addButton('save_and_edit_button', [
            'label' => __('Save and Continue Edit'),
            'class' => 'save',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'saveAndContinueEdit', 'target' => '#edit_form']],
            ],
        ]);

        $entityAttribute = $this->coreRegistry->registry('entity_attribute');

        if (!$entityAttribute || !$entityAttribute->getIsUserDefined()) {
            $this->buttonList->remove('delete');
        }
    }
}
