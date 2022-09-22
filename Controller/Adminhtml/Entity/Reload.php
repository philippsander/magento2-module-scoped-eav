<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Controller\Adminhtml\Entity;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Smile\ScopedEav\Controller\Adminhtml\AbstractEntity;

/**
 * Scoped EAV entity reload controller.
 */
class Reload extends AbstractEntity implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    public function execute()
    {
        if (!$this->getRequest()->getParam('set')) {
            $resultForward = $this->resultForwardFactory->create();
            return $resultForward->forward('noroute');
        }

        $this->getEntity();

        $resultLayout = $this->resultLayoutFactory->create();
        $resultLayout->getLayout()->getUpdate()->removeHandle('default');
        $resultLayout->setHeader('Content-Type', 'application/json', true);

        return $resultLayout;
    }
}
