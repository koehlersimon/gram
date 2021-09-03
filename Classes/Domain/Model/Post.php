<?php
namespace SIMONKOEHLER\Gram\Domain\Model;
use TYPO3\CMS\Extbase\Annotation\ORM\Cascade;

class Post extends \TYPO3\CMS\Extbase\DomainObject\AbstractEntity
{

    /*
    *
    * @var int
    */
    protected $crdate;

    /** @var int */
    public $hidden;

    /**
     * content
     *
     * @var string
     */
    protected $content = '';

    /**
     * likes
     *
     * @var int
     */
    protected $likes = 0;

    /**
     * owner
     *
     * @var \TYPO3\CMS\Extbase\Domain\Model\FrontendUser<\TYPO3\CMS\Extbase\Domain\Model\FrontendUser>
     */
    protected $owner;

    /**
     * feGroup
     *
     * @var string
     */
    protected $feGroup = '';

    /**
     * media
     *
     * @var \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference>
     * @Cascade remove
     */
    protected $media = null;


    /**
     * Returns the media
     *
     * @return \TYPO3\CMS\Extbase\Persistence\ObjectStorage<\TYPO3\CMS\Extbase\Domain\Model\FileReference> $media
     */
    public function getMedia()
    {
        return $this->media;
    }

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

    /**
     * Returns the content
     *
     * @return string $content
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Sets the content
     *
     * @param string $content
     * @return void
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * Returns the likes
     *
     * @return int $likes
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * Sets the likes
     *
     * @param int $likes
     * @return void
     */
    public function setLikes($likes)
    {
        $this->likes = $likes;
    }

    /**
     * Returns the feGroup
     *
     * @return string $feGroup
     */
    public function getFeGroup()
    {
        return $this->feGroup;
    }

    /**
     * Sets the feGroup
     *
     * @param string $feGroup
     * @return void
     */
    public function setFeGroup($feGroup)
    {
        $this->feGroup = $feGroup;
    }

    /**
     * Sets the hidden
     *
     * @param int $hidden
     * @return void
     */
    public function setHidden($hidden)
    {
        $this->hidden = $hidden;
    }

}
