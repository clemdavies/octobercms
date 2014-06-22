<?php

/* /home/clem/Dropbox/october/themes/demo/layouts/fallback */
class __TwigTemplate_1aaa5fb728c6ec231b60afc88f5538571dc5b1789cfc487289dfca62e58e47da extends Twig_Template
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
        return "/home/clem/Dropbox/october/themes/demo/layouts/fallback";
    }

    public function getDebugInfo()
    {
        return array (  19 => 1,);
    }
}
