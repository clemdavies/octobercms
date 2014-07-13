<?php

/* /home/clem/Dropbox/october/themes/clemtheme/layouts/fallback */
class __TwigTemplate_49aa16562a402df603aefc31a9f774048a46aabe178ec0c0c788fa70b8082dd4 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo $this->env->getExtension('CMS')->pageFunction();
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/themes/clemtheme/layouts/fallback";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
