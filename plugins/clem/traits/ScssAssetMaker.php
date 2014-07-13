<?php namespace Clem\Traits;

// extends functionality of System\Traits\AsseMaker
// the only way I know how

Trait ScssAssetMaker{


    /**
     * Adds compiled SCSS StyleSheet asset to the asset list. Call $this->makeAssets() in a view
     * to output corresponding markup.
     * @param string $name Specifies a path (URL) to the script.
     * @param array $attributes Adds extra HTML attributes to the asset link.
     * @return void
     */
    public function addScss($name, $attributes = [])
    {

        //compile less
        $lessFile = $passedfile;
        $cssFile = Less::compile($passedfile);
        $cssPath = $this->getAssetPath($cssFile->name);

        $cssPath = $this->getAssetPath($name);

        if (isset($this->controller))
            $this->controller->addCss($cssPath, $attributes);

        if (is_string($attributes))
            $attributes = ['build' => $attributes];

        if (substr($cssPath, 0, 1) == '/')
            $cssPath = Request::getBaseUrl() . $cssPath;

        if (!in_array($cssPath, $this->assets['css']))
            $this->assets['css'][] = ['path' => $cssPath, 'attributes' => $attributes];
    }

}
