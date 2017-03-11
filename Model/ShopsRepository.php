<?php


namespace Tareen\Shopfinder\Model;

use Tareen\Shopfinder\Api\Data\ShopsSearchResultsInterfaceFactory;
use Magento\Framework\Reflection\DataObjectProcessor;
use Magento\Store\Model\StoreManagerInterface;
use Tareen\Shopfinder\Model\ResourceModel\Shops as ResourceShops;
use Magento\Framework\Exception\CouldNotSaveException;
use Tareen\Shopfinder\Api\Data\ShopsInterfaceFactory;
use Magento\Framework\Api\DataObjectHelper;
use Tareen\Shopfinder\Model\ResourceModel\Shops\CollectionFactory as ShopsCollectionFactory;
use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\CouldNotDeleteException;
use Tareen\Shopfinder\Api\ShopsRepositoryInterface;

class ShopsRepository implements shopsRepositoryInterface
{

    protected $shopsCollectionFactory;

    protected $dataObjectProcessor;

    protected $dataObjectHelper;

    protected $searchResultsFactory;

    protected $resource;

    protected $dataShopsFactory;

    protected $shopsFactory;

    private $storeManager;


    /**
     * @param ResourceShops $resource
     * @param ShopsFactory $shopsFactory
     * @param ShopsInterfaceFactory $dataShopsFactory
     * @param ShopsCollectionFactory $shopsCollectionFactory
     * @param ShopsSearchResultsInterfaceFactory $searchResultsFactory
     * @param DataObjectHelper $dataObjectHelper
     * @param DataObjectProcessor $dataObjectProcessor
     * @param StoreManagerInterface $storeManager
     */
    public function __construct(
        ResourceShops $resource,
        ShopsFactory $shopsFactory,
        ShopsInterfaceFactory $dataShopsFactory,
        ShopsCollectionFactory $shopsCollectionFactory,
        ShopsSearchResultsInterfaceFactory $searchResultsFactory,
        DataObjectHelper $dataObjectHelper,
        DataObjectProcessor $dataObjectProcessor,
        StoreManagerInterface $storeManager
    ) {
        $this->resource = $resource;
        $this->shopsFactory = $shopsFactory;
        $this->shopsCollectionFactory = $shopsCollectionFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->dataObjectHelper = $dataObjectHelper;
        $this->dataShopsFactory = $dataShopsFactory;
        $this->dataObjectProcessor = $dataObjectProcessor;
        $this->storeManager = $storeManager;
    }

    /**
     * {@inheritdoc}
     */
    public function save(
        \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
    ) {
        /* if (empty($shops->getStoreId())) {
            $storeId = $this->storeManager->getStore()->getId();
            $shops->setStoreId($storeId);
        } */
        try {
            $this->resource->save($shops);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__(
                'Could not save the shops: %1',
                $exception->getMessage()
            ));
        }
        return $shops;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($shopsId)
    {
        $shops = $this->shopsFactory->create();
        $shops->load($shopsId);
        if (!$shops->getId()) {
            throw new NoSuchEntityException(__('shops with id "%1" does not exist.', $shopsId));
        }
        return $shops;
    }

    /**
     * {@inheritdoc}
     */
    public function getList(
            \Magento\Framework\Api\SearchCriteriaInterface $criteria = NULL
        )
        {
            $currentStore = $this->storeManager->getStore()->getId();
            $items = [];

            $searchResults = $this->searchResultsFactory->create();
            $collection = $this->shopsCollectionFactory->create();
            
            if($criteria != NULL) {
                $searchResults->setSearchCriteria($criteria);
                foreach ($criteria->getFilterGroups() as $filterGroup) {
                    foreach ($filterGroup->getFilters() as $filter) {
                        $condition = $filter->getConditionType() ?: 'eq';
                        $fieldName = $filter->getField();
                        switch ($fieldName) {
                            case 'name':
                            case 'identifier':
                            case 'country':
                                $fieldName = $fieldName;
                                break;
                        }
                        switch ($filter->getConditionType()) {
                            case 'like':
                                $filter->setValue('%'.$filter->getValue().'%');
                                break;
                        }
                        $collection->addFieldToFilter($fieldName, [$condition => $filter->getValue()]);
                    }
                }
                $sortOrders = $criteria->getSortOrders();
                if ($sortOrders) {
                    /** @var SortOrder $sortOrder */
                    foreach ($sortOrders as $sortOrder) {
                        $collection->addOrder(
                            $sortOrder->getField(),
                            ($sortOrder->getDirection() == SortOrder::SORT_ASC) ? 'ASC' : 'DESC'
                        );
                    }
                }
                $collection->setCurPage($criteria->getCurrentPage());
                $collection->setPageSize($criteria->getPageSize());
            }
            foreach ($collection as $shopModel) {
                $shopData = $this->dataShopsFactory->create();
                $shopValues = $shopModel->getData();
                $storeViews = trim($shopValues['store_view'], ",");
                $storeViews = explode(",", $storeViews);
                $shopValues['store_view'] = [];
                foreach ($storeViews as $storeView) {
                    if ($storeView == 0) {
                        $shopValues['store_view'][] = 'all';
                    } else {
                        $shopValues['store_view'][] = $this->storeManager->getStore($storeView)->getCode();
                    }

                }
                
                $this->dataObjectHelper->populateWithArray(
                    $shopData,
                    $shopValues,
                    'Tareen\Shopfinder\Api\Data\ShopsInterface'
                );
                $items[] = $this->dataObjectProcessor->buildOutputDataArray(
                    $shopData,
                    'Tareen\Shopfinder\Api\Data\ShopsInterface'
                );
            }
            $searchResults->setTotalCount($collection->getSize());
            $searchResults->setItems($items);
            return $searchResults;
            $searchResults->setTotalCount($collection->getSize());
        }

    /**
     * {@inheritdoc}
     */
    public function delete(
        \Tareen\Shopfinder\Api\Data\ShopsInterface $shops
    ) {
        try {
            $this->resource->delete($shops);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__(
                'Could not delete the shops: %1',
                $exception->getMessage()
            ));
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function deleteById($shopsId)
    {
        return $this->delete($this->getById($shopsId));
    }
}
