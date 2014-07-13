<?php

/* /home/clem/Dropbox/october/themes/demo/pages/hi-clem.htm */
class __TwigTemplate_25e3275ead27dc3e084a3aef5d4479981772f69ef6a1eb008f18b558e2117b5e extends Twig_Template
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
        echo "<div>
    hi clem!
</div>
";
        // line 4
        $context['__cms_component_params'] = [];
        echo $this->env->getExtension('CMS')->componentFunction("feedsteamlibrary"        , $context['__cms_component_params']        );
        unset($context['__cms_component_params']);
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/themes/demo/pages/hi-clem.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  24 => 4,  19 => 1,);
    }
}
