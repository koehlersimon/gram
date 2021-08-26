<?php
namespace SIMONKOEHLER\Gram\Domain\Model;

class User extends \TYPO3\CMS\Extbase\Domain\Model\FrontendUser {

        /**
         * url
         *
         * @var string
         */
        protected $url;

        /**
         * apikey
         *
         * @var string
         */
        protected $apikey;

        /**
         * Returns the url
         *
         * @return string $url
         */
        public function getUrl() {
            return $this->url;
        }

        /**
         * Sets the url
         *
         * @param string $url
         * @return void
         */
        public function setUrl($url) {
            $this->url = $url;
        }

}
