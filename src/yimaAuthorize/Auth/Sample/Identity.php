<?php
namespace yimaAuthorize\Auth\Sample;

use Poirot\Core\Entity;
use yimaAuthorize\Auth\IdentityInterface;

class Identity implements IdentityInterface
{
    protected $uid;

    /**
     * @var Entity
     */
    protected $data;

    /**
     * Set Uid
     *
     * @param null|int|string $uid Uid
     *
     * @return $this
     */
    function setUid($uid)
    {
        $this->uid = $uid;

        return $this;
    }

    /**
     * Get UIdentity
     *
     * - each Identity has a uid,
     *   it can be user_id, ...
     *   this uid used by Permission to recognize users
     *
     *   null if not identity detected
     *
     * @return null|string|int
     */
    function getUid()
    {
        return $this->uid;
    }

    /**
     * Get Identity Data
     *
     * @return Entity
     */
    function data()
    {
        if(!$this->data)
            $this->data = new Entity();

        return $this->data;
    }
}
 