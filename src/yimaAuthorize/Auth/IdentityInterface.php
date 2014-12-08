<?php
namespace yimaAuthorize\Auth;

use Poirot\Collection\Entity;

interface IdentityInterface
{
    /**
     * Set Uid
     *
     * @param null|int|string $uid Uid
     *
     * @return $this
     */
    function setUid($uid);

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
    function getUid();

    /**
     * Get Identity Data
     *
     * @return Entity
     */
    function data();
}
