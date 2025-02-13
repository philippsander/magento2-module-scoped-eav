<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Controller\Adminhtml\Set;

use Smile\ScopedEav\Controller\Adminhtml\AbstractSet;

/**
 * Scoped EAV entity attribute set admin delete controller.
 */
class Delete extends AbstractSet
{
    /**
     * {@inheritdoc}
     */
    public function execute()
    {
        try {
            $this->getAttributeSet()->delete();
            $this->messageManager->addSuccessMessage(__('The attribute set has been removed.'));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__('We can\'t delete this set right now.'));
        }

        return $this->_redirect('*/*/index');
    }
}
