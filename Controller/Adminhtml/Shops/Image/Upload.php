<?php
    /**
     * Copyright © 2016 Magento. All rights reserved.
     * See COPYING.txt for license details.
     */
    namespace Tareen\Shopfinder\Controller\Adminhtml\Shops\Image;
    use Magento\Framework\Controller\ResultFactory;
    /**
     * Class Upload
     */
    class Upload extends \Magento\Backend\App\Action
    {
        /**
         * Image uploader
         *
         * @var \Tareen\Shopfinder\Model\ImageUploader
         */
        protected $imageUploader;
        /**
         * Upload constructor.
         *
         * @param \Magento\Backend\App\Action\Context $context
         * @param \Tareen\Shopfinder\Model\ImageUploader $imageUploader
         */
        public function __construct(
            \Magento\Backend\App\Action\Context $context,
            \Tareen\Shopfinder\Model\ImageUploader $imageUploader
        ) {
            parent::__construct($context);
            $this->imageUploader = $imageUploader;
        }
        /**
         * Check admin permissions for this controller
         *
         * @return boolean
         */
        protected function _isAllowed()
        {
            return $this->_authorization->isAllowed('Tareen_Shopfinder::Shops_save');
        }
        /**
         * Upload file controller action
         *
         * @return \Magento\Framework\Controller\ResultInterface
         */
        public function execute()
        {
            $imageId = $this->_request->getParam('param_name', 'image');
            try {
                $result = $this->imageUploader->saveFileToTmpDir($imageId);
                $result['cookie'] = [
                    'name' => $this->_getSession()->getName(),
                    'value' => $this->_getSession()->getSessionId(),
                    'lifetime' => $this->_getSession()->getCookieLifetime(),
                    'path' => $this->_getSession()->getCookiePath(),
                    'domain' => $this->_getSession()->getCookieDomain(),
                ];
            } catch (\Exception $e) {
                $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
            }
            return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
        }
    }