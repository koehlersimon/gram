<?php
namespace SIMONKOEHLER\Osp\ExpressionLanguage;
use TYPO3\CMS\Core\ExpressionLanguage\AbstractProvider;

class CountryCondition extends AbstractProvider {

    public function __construct(){
        $this->expressionLanguageVariables = [
           'user_country' => $this->getCountry(),
        ];
    }

    /**
    * Output the current time in red letters
    *
    * @param  string          Empty string (no content to process)
    * @param  array           TypoScript configuration
    * @return string          HTML output, showing the current server time.
    */
    private function getCountry() {

        $data = unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip='.$this->getIp()));
        if(isset($data['geoplugin_countryCode']) && $data['geoplugin_countryCode'] !== ''){
            return $data['geoplugin_countryCode'];
        }
        else{
            return 'de';
        }

    }

    private function getIp() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')){
            $ipaddress = getenv('HTTP_CLIENT_IP');
        }
        else if(getenv('HTTP_X_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        }
        else if(getenv('HTTP_X_FORWARDED')){
            $ipaddress = getenv('HTTP_X_FORWARDED');
        }
        else if(getenv('HTTP_FORWARDED_FOR')){
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        }
        else if(getenv('HTTP_FORWARDED')){
            $ipaddress = getenv('HTTP_FORWARDED');
        }
        else if(getenv('REMOTE_ADDR')){
            $ipaddress = getenv('REMOTE_ADDR');
        }
        else{
            $ipaddress = 'UNKNOWN';
        }
        return $ipaddress;
    }

}
