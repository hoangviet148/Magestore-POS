<?php

namespace Learning\Pos\Model;

use Magento\Framework\Api\SortOrder;
use Learning\Pos\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Api\Data\ProductSearchResultsInterfaceFactory;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;

/**
 * Class ProductRepository to get product for WebPOS
 *
 */
class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    /**
     * @var ProductSearchResultsInterfaceFactory
     */
    protected $productSearchResultInterfaceFactory;

    /**
     * @param ProductSearchResultsInterfaceFactory $productSearchFactory
     * @param CollectionFactory $collectionFactory ,
     */
    public function __construct(
        ProductSearchResultsInterfaceFactory $productSearchFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->collectionFactory = $collectionFactory;
        $this->productSearchResultInterfaceFactory = $productSearchFactory;
    }

    /**
     * @inheritDoc
     * @throws LocalizedException
     */
    function getList(SearchCriteriaInterface $searchCriteria = null)
    {
        $searchResults = $this->productSearchResultInterfaceFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);

        $collection = $this->collectionFactory->create();

        $collection->addFieldToSelect("*")->addAttributeToSelect("*");
        //$collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        //$collection->joinAttribute('webpos_visible', 'catalog_product/status', 'entity_id', null, 'inner');
        $collection->addFieldToFilter('webpos_visible', ['eq' => "1"] , "left");

        $this->addFilterToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);
        $collection->load();

        $result = [];
        foreach ($collection->addMediaGalleryData() as $product) {
            $temp = [];
            if ($product->getTypeId() == "configurable") {
                $children = $product->getTypeInstance()->getUsedProducts($product);
                if (!empty($children)) {
                    foreach ($children as $child) {
                        $attrColor = $product->getResource()->getAttribute('color');
                        $attrSize = $product->getResource()->getAttribute('size');
                        if ($attrColor->usesSource() && $attrSize->usesSource()) {
                            $optionTextColor = $attrColor->getSource()->getOptionText($child["color"]);
                            $attributeIdColor = $attrColor->getSource()->getAttribute()->getAttributeId();
                            $optionTextSize = $attrSize->getSource()->getOptionText($child["size"]);
                            $attributeIdSize = $attrSize->getSource()->getAttribute()->getAttributeId();
                            $temp[] = [
                                "entity_id" => $child->getEntityId(),
                                "type_id" => $child->getTypeId(),
                                "sku" => $child->getSku(),
                                "name" => $child->getName(),
                                "color" => [
                                    "option_id" => $attributeIdColor,
                                    "label" => $optionTextColor,
                                    "option_value" => $child["color"]
                                ],
                                "size" => [
                                    "option_id" => $attributeIdSize,
                                    "label" => $optionTextSize,
                                    "option_value" => $child["size"]
                                ],
                            ];
                        }
                    }
                }

            }
            $result[] = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "image" => $product->getMediaGalleryImages()->getColumnValues("url")[0],
                "sku" => $product->getSku(),
                "price" => $product->getFinalPrice(),
                "store_id" => $product->getStoreId(),
                "visibility" => $product->getVisibility(),
                "status" => $product->getStatus(),
                "type_id" => $product->getTypeId(),
                // "webpos_visible" => $product->getData('webpos_visible'),
                "childItems" => $temp
            ];
        }

        $searchResults->setItems($result);
        $searchResults->setTotalCount($collection->getSize());
        return $searchResults;
    }

    /**
     * Method addFilterToCollection support filter by standard searchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private
    function addFilterToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {

            $fields = [];
            $categoryFilter = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $conditionType = $filter->getConditionType() ?: 'eq';

                if ($filter->getField() == 'category_id') {
                    $categoryFilter[$conditionType][] = $filter->getValue();
                    continue;
                }
                $fields[] = ['attribute' => $filter->getField(), $conditionType => $filter->getValue()];
            }

            if ($categoryFilter) {
                $collection->addCategoriesFilter($categoryFilter);
            }

            if ($fields) {
                $collection->addFieldToFilter($fields);
            }
        }
    }

    /**
     * Method addSortOrdersToCollection support sort by standard searchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private
    function addSortOrdersToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ((array)$searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * Method addPagingToCollection support sort by standard searchCriteria
     *
     * @param SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private
    function addPagingToCollection(SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }
}
