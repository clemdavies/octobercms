<?php

/* /home/clem/Dropbox/october/themes/clemfeed/layouts/fallback */
class __TwigTemplate_d92d58207d85f62d7dc9468b87587b71029b0b5c5a4d8dfb53ae7e160da2bb25 extends Twig_Template
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
        return "/home/clem/Dropbox/october/themes/clemfeed/layouts/fallback";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
