<?php

namespace Spryng\SpryngRestApi\Objects;

use Spryng\SpryngRestApi\ApiResource;

class MessageCollection extends ApiResource
{
    /**
     * The total number of fetchable objects
     *
     * @var int
     */
    protected $total;

    /**
     * The number of objects in each page
     *
     * @var int
     */
    protected $perPage;

    /**
     * The current page
     *
     * @var int
     */
    protected $currentPage;

    /**
     * The last page, aka how many pages there are with this $perPage
     *
     * @var int
     */
    protected $lastPage;

    /**
     * Easy access URL to the next page
     *
     * @var string
     */
    protected $nextPageUrl;

    /**
     * Easy access URL to the previous page
     *
     * @var string
     */
    protected $prevPageUrl;

    /**
     * From index in the collection
     *
     * @var int
     */
    protected $from;

    /**
     * To index in the collection
     *
     * @var int
     */
    protected $to;

    /**
     * The actual message data
     *
     * @var array
     */
    protected $data;

    /**
     * @return int
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param int $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->perPage;
    }

    /**
     * @param int $perPage
     */
    public function setPerPage($perPage)
    {
        $this->perPage = $perPage;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->currentPage;
    }

    /**
     * @param int $currentPage
     */
    public function setCurrentPage($currentPage)
    {
        $this->currentPage = $currentPage;
    }

    /**
     * @return int
     */
    public function getLastPage()
    {
        return $this->lastPage;
    }

    /**
     * @param int $lastPage
     */
    public function setLastPage($lastPage)
    {
        $this->lastPage = $lastPage;
    }

    /**
     * @return string
     */
    public function getNextPageUrl()
    {
        return $this->nextPageUrl;
    }

    /**
     * @param string $nextPageUrl
     */
    public function setNextPageUrl($nextPageUrl)
    {
        $this->nextPageUrl = $nextPageUrl;
    }

    /**
     * @return string
     */
    public function getPrevPageUrl()
    {
        return $this->prevPageUrl;
    }

    /**
     * @param string $prevPageUrl
     */
    public function setPrevPageUrl($prevPageUrl)
    {
        $this->prevPageUrl = $prevPageUrl;
    }

    /**
     * @return int
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param int $from
     */
    public function setFrom($from)
    {
        $this->from = $from;
    }

    /**
     * @return int
     */
    public function getTo()
    {
        return $this->to;
    }

    /**
     * @param int $to
     */
    public function setTo($to)
    {
        $this->to = $to;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }
}