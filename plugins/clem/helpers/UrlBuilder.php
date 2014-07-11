<?php namespace Clem\Helpers;

use RuntimeException;

/**
*   creates a url from a template string and array of parameters
*/

class UrlBuilder
{
    private $parameters;
    private $urlTemplate;
    private $constructingurl;
    private $url;

    public function __construct($parameters,$urlTemplate){
        $this->parameters  = $parameters;
        $this->urlTemplate = $urlTemplate;
        $this->createurl();
    }
    public function reconstruct( $parameters,$urlTemplate ){
        $this->parameters  = $parameters;
        $this->urlTemplate = $urlTemplate;
        $this->createurl();
    }

    private function insertParameters( $parameters ){
        foreach ( $parameters as $key => $value ){
            if ( is_array($value) ) {
                $this->insertParameters( $value );
            }else if( !is_null($value) ){
                $this->insertParameter( $key,$value );
            }
        }
    }

    private function insertParameter($key,$value){
        if ( strpos($this->constructingurl, $key) !== false ) {
            $this->constructingurl = str_replace( '{{'.$key.'}}', $value, $this->constructingurl );
        }else if( strrpos($this->constructingurl,'?') != 0  ){
            // extra parameters already started :. append
            $this->constructingurl .= '&'.$key.'='.$value;
        }else{
            $this->constructingurl .= '?'.$key.'='.$value;
        }
    }

    private function validateParameters($parameters,$keyPath = ''){
        foreach ($parameters as $key => $value) {
            if ( $key == 'optional' && is_array($value) ) {
                continue;
            }else if( is_array($value) ){
                $this->validateParameters( $value,$keyPath.'['.$key.']' );
            }else{
                $this->validateParameter( $keyPath.'['.$key.']',$value );
            }
        }
    }

    private function validateParameter( $keyPath,$value ){
            return;
        if( $value == null ){
            throw new RuntimeException('Parameter at '.$keyPath.' must be set prior to url creation. Check config.php.');
        }
    }

    // neglects validation
    private function createurl(){
        $this->validateParameters( $this->parameters );
        $this->constructingurl = $this->urlTemplate;
        $this->insertParameters( $this->parameters );

        // if valid url then
        $this->url = $this->constructingurl;
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
        $this->urlTemplate = $newurlTemplate;
    }
    public function geturlTemplate(){
        return $this->urlTemplate;
    }

    public function seturl($newurl){
        $this->url = $newurl;
    }
    public function geturl(){
        return $this->url;
    }

}