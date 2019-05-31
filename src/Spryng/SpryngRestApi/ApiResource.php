<?php

namespace Spryng\SpryngRestApi;

use Spryng\SpryngRestApi\Objects\MessageCollection;

class ApiResource
{
    protected $raw;

    public function __construct($raw = null)
    {
        if ($raw !== null)
        {
            $this->setRaw($raw);
        }
    }

    /**
     * @return mixed
     */
    public function getRaw()
    {
        return $this->raw;
    }

    /**
     * @param mixed $raw
     */
    public function setRaw($raw)
    {
        $this->raw = $raw;
    }

    /**
     * @param $raw string|array
     * @param $class string
     * @return ApiResource|array
     */
    public static function deserializeFromRaw($raw, $class)
    {
        // Decode the raw Json response
        $json = json_decode($raw, true);

        // If the data parameter is set, it means that this is a collection of message objects
        if (isset($json['data']))
        {
            $collection = new MessageCollection();
            $collection->setTotal($json['total']);
            $collection->setPerPage($json['per_page']);
            $collection->setCurrentPage($json['current_page']);
            $collection->setLastPage($json['last_page']);
            $collection->setNextPageUrl($json['next_page_url']);
            $collection->setPrevPageUrl($json['prev_page_url']);
            $collection->setFrom($json['from']);
            $collection->setTo($json['to']);

            $messages = array();
            foreach ($json['data'] as $rawMessage)
            {
                // Call the function recursively to deserialize every message. Serialize back to Json to avoid array/object
                // conversion issues
                $messages[] = self::deserializeFromRaw(json_encode($rawMessage), $class);
            }
            $collection->setData($messages);

            return $collection;
        }

        // If we've come here, we're deserializing a single message or balance response
        $obj = new $class;
        foreach ($json as $key => $val)
        {
            // Remove underscores from the key that may be present in the response
            $key = str_replace('_', '', $key);

            // Get the name of the set method by capitalizing the first character of the key
            $name = 'set'.ucfirst($key);
            if (!is_array($val))
                echo $name.": ". $val."\n";

            // If there is such a set method, call it
            if (method_exists('ApiResource', $name))
            {
                $obj->$name($val);
            }
        }

        return $obj;
    }
}