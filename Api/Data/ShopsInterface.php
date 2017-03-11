<?php


namespace Tareen\Shopfinder\Api\Data;

interface ShopsInterface
{

    const CREATED_AT = 'created_at';
    const COUNTRY = 'country';
    const SHOPS_ID = 'shops_id';
    const IMAGE = 'image';
    const STORE_VIEW = 'store_view';
    const IDENTIFIER = 'identifier';
    const NAME = 'name';


    /**
     * Get shops_id
     * @return string|null
     */
    
    public function getShopsId();

    /**
     * Set shops_id
     * @param string $shops_id
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setShopsId($shopsId);

    /**
     * Get name
     * @return string|null
     */
    
    public function getName();

    /**
     * Set name
     * @param string $name
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setName($name);

    /**
     * Get identifier
     * @return string|null
     */
    
    public function getIdentifier();

    /**
     * Set identifier
     * @param string $identifier
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setIdentifier($identifier);

    /**
     * Get country
     * @return string|null
     */
    
    public function getCountry();

    /**
     * Set country
     * @param string $country
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setCountry($country);

    /**
     * Get image
     * @return string|null
     */
    
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setImage($image);

    /**
     * Get store_view
     * @return string|null
     */
    
    public function getStoreView();

    /**
     * Set store_view
     * @param string $store_view
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setStoreView($store_view);

    /**
     * Get created_at
     * @return string|null
     */
    
    public function getCreatedAt();

    /**
     * Set created_at
     * @param string $created_at
     * @return Tareen\Shopfinder\Api\Data\ShopsInterface
     */
    
    public function setCreatedAt($created_at);
}
