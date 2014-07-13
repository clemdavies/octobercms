<?php

/* /home/clem/Dropbox/october/themes/clemfeed/pages/home.htm */
class __TwigTemplate_284482480e57e0fd9a5b5dbef2b73f9818f5190ee46fe756380f76fdc93da9bd extends Twig_Template
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
        echo "HOMEPAGE
";
        // line 2
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('CMS')->componentFunction("feedsteamlibrary"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/themes/clemfeed/pages/home.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  22 => 2,  19 => 1,);
    }
}
