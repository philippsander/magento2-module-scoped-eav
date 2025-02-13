<?php

declare(strict_types=1);

namespace Smile\ScopedEav\Model\Entity\Attribute\Backend;

use Magento\Catalog\Model\ImageUploader;
use Magento\Framework\DataObject;
use Magento\Framework\Filesystem;
use Magento\MediaStorage\Model\File\UploaderFactory;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;

/**
 * Scoped EAV image backend model.
 */
class Image extends \Magento\Catalog\Model\Category\Attribute\Backend\Image
{
    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var string
     */
    private $additionalData = '_additional_data_';

    /**
     * Image constructor.
     *
     * @param LoggerInterface $logger Logger.
     * @param Filesystem $filesystem Filesystem.
     * @param UploaderFactory $fileUploaderFactory File uploader factory.
     * @param ImageUploader|null $imageUploader Image uploader.
     */
    public function __construct(
        LoggerInterface $logger,
        Filesystem $filesystem,
        UploaderFactory $fileUploaderFactory,
        StoreManagerInterface $storeManager = null,
        ImageUploader $imageUploader = null
    ) {
        parent::__construct($logger, $filesystem, $fileUploaderFactory, $storeManager, $imageUploader);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Save uploaded file and set its name to category
     *
     * @param DataObject $object Object model.
     *
     * @return \Magento\Catalog\Model\Category\Attribute\Backend\Image
     */
    public function afterSave($object)
    {
        $value = $object->getData($this->additionalData . $this->getAttribute()->getName());

        if ($this->isTmpFileAvailable($value) && $imageName = $this->getUploadedImageName($value)) {
            try {
                $this->getImageUploader()->moveFileFromTmp($imageName);
            } catch (\Exception $e) {
                $this->_logger->critical($e);
            }
        }

        return $this;
    }

    /**
     * @return ImageUploader
     */
    private function getImageUploader()
    {
        return $this->imageUploader;
    }

    /**
     * Gets image name from $value array.
     * Will return empty string in a case when $value is not an array
     *
     * @param array $value Attribute value
     *
     * @return string
     */
    private function getUploadedImageName(array $value): string
    {
        if (is_array($value) && isset($value[0]['name'])) {
            return $value[0]['name'];
        }

        return '';
    }

    /**
     * Check if temporary file is available for new image upload.
     *
     * @param array|null $value Attribute value.
     *
     * @return bool
     */
    private function isTmpFileAvailable(?array $value): bool
    {
        return is_array($value) && isset($value[0]['tmp_name']);
    }
}
