<?php
namespace SIMONKOEHLER\Gram\Domain\Model;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;

class Chat extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /*
    *
    * @var int
    */
    protected $crdate;


    /**
     * owner
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     */
    protected $owner;


    /**
    * Returns the crdate
    *
    * @return int
    */
    public function getCrdate() {
        return $this->crdate;
    }

    /**
     * Returns the owner
     *
     * @return \TYPO3\CMS\Extbase\Domain\Model\FrontendUser<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser> $owner
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * Sets the owner
     *
     * @param \TYPO3\CMS\Extbase\Domain\Model\FrontendUser
     * @return void
     */
    public function setOwner(\TYPO3\CMS\Extbase\Domain\Model\FrontendUser $owner)
    {
        $this->owner = $owner;
    }

}
