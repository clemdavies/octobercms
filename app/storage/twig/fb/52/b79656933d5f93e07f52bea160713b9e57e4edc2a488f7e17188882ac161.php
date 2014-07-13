<?php

/* /home/clem/Dropbox/october/themes/clem/layouts/fallback */
class __TwigTemplate_fb52b79656933d5f93e07f52bea160713b9e57e4edc2a488f7e17188882ac161 extends Twig_Template
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
        return "/home/clem/Dropbox/october/themes/clem/layouts/fallback";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
