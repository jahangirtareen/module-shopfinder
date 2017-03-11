<?php


namespace Tareen\Shopfinder\Api\Data;

interface ShopsSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{


    /**
     * Get shops list.
     * @return \Tareen\Shopfinder\Api\Data\ShopsInterface[]
     */
    
    public function getItems();

    /**
     * Set name list.
     * @param \Tareen\Shopfinder\Api\Data\ShopsInterface[] $items
     * @return $this
     */
    
    public function setItems(array $items);
}
