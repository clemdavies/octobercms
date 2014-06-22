<?php namespace Clem\Steam\Api;

use Clem\Steam\Api\Api;
use Clem\Steam\Api\Method;
use Clem\Steam\Models\Settings;

use Clem\Helpers\UrlBuilder;
use Clem\Helpers\Debug;

use Config;
use ReflectionMethod;
use RuntimeException;

/**
*
*/


// validation needs further looking into
// perhaps defer validation to outside method? but validation patterns are set in config?
// validate finished url?
class Method
{
    private $name;

    private $parameters;
    private $urlTemplate;
    private $url;

    private $api;

    //stores passed parameters to __construct
    protected $passedParameters;

    // stores response from api call
    protected $response;

    /**
    *   There MAY be reason to defer calling of url to child classes. BUT I would like
    *   to have ALL data ready to go prior to creation of this object or its children.
    *   If additional parameters need to be assigned values then that can be done using
    *   the extension methods.
    *   This allows a single construction method to be called and defer validation
    *   upwards and into a single place within the code. ie; Here
    */
    public function __construct($parameters){
        $this->passedParameters = $parameters;
        $this->api = Api::instance();

        $this->urlTemplate = Config::get('clem.steam::api.urltemplates.'.Config::get('clem.steam::api.methods.'.$this->name.'.urltemplate'));
        // config static parameters
        $this->doExtensionMethod('preInitParameters');
        $this->initParameters();
        // check if api key is required and set it in the parameters
        $this->doExtensionMethod('preUseApiKey');
        $this->useApiKey();
        // component instance parameters
        $this->doExtensionMethod('preAddParameters');
        $this->addParameters( $this->passedParameters );

        $this->doExtensionMethod('preUrlBuilder');
        $this->urlBuilder = new UrlBuilder($this->parameters,$this->urlTemplate);
        $this->url = $this->urlBuilder->getUrl();
    }


    /**
    *   Allow a method to run After parameter initialization but Before url is created
    *   Restricts access to createurl method.
    */
    private function doExtensionMethod( $methodName ){
        if( method_exists( $this,$methodName ) ){
            $reflection = new ReflectionMethod($this, $methodName );
            if (!$reflection->isProtected()) {
                throw new RuntimeException('Method '.$methodName.' must be set to protected or removed from '.get_class($this));
            }
            $this->$methodName();
        }
    }

    // pulls parameters with key value pairs from config file
    private function initParameters(){
        $this->parameters = Config::get('clem.steam::api.methods.'.$this->name.'.parameters');
    }

    // checks if key is set in parameters listing and sets the api->key value to it.
    private function useApiKey(){
        foreach ($this->parameters as $subArrayKey => $subArray) {
            if ( array_key_exists('key',$subArray) ) {
                $this->parameters[$subArrayKey]['key'] = $this->api->getKey();
            }
        }
    }

    // loops on itself until end of nesting. passes key and value to be set when value is not an array
    protected function addParameters( $parameters ){
        foreach ($parameters as $key => $value) {
            if ( is_array($value) ) {
                $this->addParameters($value);
            }else{
                $this->addParameter($key,$value);
            }
        }
    }

    // only sets parameters if a key is set for it in the config
    // only allows values to be assigned to existing null pointers in the parameters array
    protected function addParameter( $passedKey,$passedValue ){
        foreach($this->parameters as $subArrayKey => $subArray){
            if ( array_key_exists($passedKey, $subArray) &&
                is_null($this->parameters[$subArrayKey][$passedKey]) ) {
                $this->parameters[$subArrayKey][$passedKey] = $passedValue;
            }
        }
    }

    /**
    *   Calls $url
    *   @return $result associative array or false
    */
    public function callurl(){
        try {
            $this->response = json_decode( file_get_contents($this->url) )->response;
        } catch (Exception $e) {
            throw new RuntimeException('Failed to retrieve valid response from: '.$this->url);
        }
    }


    public function setName($newName){
        $this->name = $newName;
    }
    public function getName(){
        return $this->name;
    }

    public function setParameters($newParameters){
        $this->parameters = $newParameters;
    }
    public function getParameters(){
        return $this->parameters;
    }
    private function findKey($findKey,$array){
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = $this->findKey($findKey,$value);
                if ($result) return $result;
            }else if ($key == $findKey) {
                return $value;
            }
        }
        return false;
    }
    public function getParameter($findKey){
        return $this->findKey($findKey,$this->parameters);
    }

    public function seturlTemplate($newurlTemplate){
        $this->urltemplate = $newurlTemplate;
    }
    public function geturlTemplate(){
        return $this->urltemplate;
    }

    public function seturl($newurl){
        $this->url = $newurl;
    }
    public function geturl(){
        return $this->url;
    }

    public function setApi($newApi){
        $this->api = $newApi;
    }
    public function getApi(){
        return $this->api;
    }


}