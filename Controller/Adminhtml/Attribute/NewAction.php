<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Controller\Adminhtml\Attribute;

use Smile\ScopedEav\Controller\Adminhtml\AbstractAttribute;

/**
 * Scoped EAV entity attribute create controller.
 */
class NewAction extends AbstractAttribute
{
    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultForward = $this->resultForwardFactory->create();
        return $resultForward->forward('edit');
    }
}
