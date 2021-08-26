<?php
namespace SIMONKOEHLER\Gram\Domain\Model;

class Like extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /**
     * owner
     *
     * @var int
     */
    protected $owner = 0;

    /**
     * parent
     *
     * @var int
     */
    protected $parent = 0;

    /**
     * parentType
     *
     * @var int
     */
    protected $parentType = 0;

    /**
     * Returns the owner
     *
     * @return int $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Sets the owner
     *
     * @param int $owner
     * @return void
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * Returns the parentType
     *
     * @return int $parentType
     */
    public function getParentType()
    {
        return $this->parentType;
    }

    /**
     * Sets the parentType
     *
     * @param int $parentType
     * @return void
     */
    public function setParentType($parentType)
    {
        $this->parentType = $parentType;
    }

    /**
     * Returns the parent
     *
     * @return int $parent
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Sets the parent
     *
     * @param int $parent
     * @return void
     */
    public function setParent($parent)
    {
        $this->parent = $parent;
    }
}
