<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Controller\Adminhtml\Entity\Image;

use Magento\Backend\App\Action;
use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\JsonFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\NotFoundException;

/**
 * Scoped EAV uploader controller.
 */
class Upload extends Action implements HttpPostActionInterface
{
    private ImageUploader $imageUploader;
    private JsonFactory $resultJsonFactory;

    /**
     * Upload constructor.
     *
     * @param Action\Context $context Context.
     * @param ImageUploader $imageUploader Image uploader.
     * @param JsonFactory $resultJsonFactory Json factory.
     */
    public function __construct(
        Action\Context $context,
        ImageUploader $imageUploader,
        JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Execute action based on request and return result
     *
     * Note: Request will be added as operation argument in future
     *
     * @return ResultInterface|ResponseInterface
     * @throws NotFoundException
     */
    /**
     * Upload file controller action
     */
    public function execute(): ResultInterface
    {
        // @todo need https://patch-diff.githubusercontent.com/raw/magento/magento2/pull/19249.patch
        $imageId = $this->_request->getParam('param_name');

        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        $resultJson = $this->resultJsonFactory->create();
        $resultJson->setData($result);
        return $resultJson;
    }
}
