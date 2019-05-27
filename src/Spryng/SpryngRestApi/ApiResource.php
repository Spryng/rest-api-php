<?php

namespace Spryng\SpryngRestApi;

class ApiResource
{
    protected $raw;

    public function __construct($raw = null)
    {
        if ($raw !== null)
        {
            $this->setRaw($raw);
            $this->deserializeFromRaw();
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

    public function deserializeFromRaw()
    {
        $json = json_decode($this->getRaw(), true);
        foreach ($json as $key => $val)
        {
            // Remove underscores
            $key = str_replace('_', '', $key);
            $name = 'set'.ucfirst($key);
            if (method_exists($this, $name))
            {
                $this->$name($val);
            }
        }
    }
}