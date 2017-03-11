<?php


namespace Tareen\Shopfinder\Model\ResourceModel;

class Shops extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('tareen_shops', 'shops_id');
    }
}
