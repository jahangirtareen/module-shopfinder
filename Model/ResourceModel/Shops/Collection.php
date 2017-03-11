<?php


namespace Tareen\Shopfinder\Model\ResourceModel\Shops;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(
            'Tareen\Shopfinder\Model\Shops',
            'Tareen\Shopfinder\Model\ResourceModel\Shops'
        );
    }
}
