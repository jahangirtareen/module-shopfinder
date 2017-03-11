<?php


namespace Tareen\Shopfinder\Api;

use Magento\Framework\Api\SearchCriteriaInterface;

interface ShopsRepositoryInterface
{


    /**
     * Save shops
     * @param \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
     * @return \Tareen\Shopfinder\Api\Data\ShopsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function save(
        \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
    );

    /**
     * Retrieve shops
     * @param string $shopsId
     * @return \Tareen\Shopfinder\Api\Data\ShopsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getById($shopsId);

    /**
     * Retrieve shops matching the specified criteria.
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Tareen\Shopfinder\Api\Data\ShopsSearchResultsInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function getList(
        \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
    );

    /**
     * Delete shops
     * @param \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
     * @return bool true on success
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function delete(
        \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
    );

    /**
     * Delete shops by ID
     * @param string $shopsId
     * @return bool true on success
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    
    public function deleteById($shopsId);
}
