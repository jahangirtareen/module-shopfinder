<?php


namespace Tareen\Shopfinder\Controller\Adminhtml\Shops;

class Delete extends \Tareen\Shopfinder\Controller\Adminhtml\Shops
{

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('shops_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->_objectManager->create('Tareen\Shopfinder\Model\Shops');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the Shops.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['shops_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a Shops to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
