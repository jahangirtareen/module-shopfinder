<?php


namespace Tareen\Shopfinder\Controller\Adminhtml\Shops;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Magento\Backend\App\Action
{

    protected $dataPersistor;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
    ) {
        $this->dataPersistor = $dataPersistor;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('shops_id');
        
            $model = $this->_objectManager->create('Tareen\Shopfinder\Model\Shops')->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This Shops no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }
            
            foreach ($data as $key => $value) {
                    if($key=='image') {
                        for($i=0 ; $i<count($value) ; $i++) {
                            unset($value[$i]['cookie']);
                            unset($value[$i]['tmp_name']);
                        }
                        $data[$key] = serialize($value);
                    } else if (is_array($value)) {
                        $keyVal = $this->getRequest()->getParam($key);
                        $keyVals = [];
                        foreach($keyVal as $kv) {
                            if($kv==="0" || $kv) {
                                $keyVals[] = $kv;
                            }
                        }
                        $data[$key] = ','.implode(',',$keyVals).',';
                    }
                }
                if(!isset($data['image'])) {
                    $data['image'] = serialize('');
                }
                
            $model->setData($data);
        
            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the Shops.'));
                $this->dataPersistor->clear('tareen_shopfinder_shops');
        
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['shops_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the Shops.'));
            }
        
            $this->dataPersistor->set('tareen_shopfinder_shops', $data);
            return $resultRedirect->setPath('*/*/edit', ['shops_id' => $this->getRequest()->getParam('shops_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
