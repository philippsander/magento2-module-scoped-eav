<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Controller\Adminhtml\Attribute;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Smile\ScopedEav\Controller\Adminhtml\AbstractAttribute;

/**
 * Scoped EAV attribute listing controller.
 */
class Index extends AbstractAttribute implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        $resultPage = $this->createActionPage(__('Manage Attributes'));

        return $resultPage;
    }
}
