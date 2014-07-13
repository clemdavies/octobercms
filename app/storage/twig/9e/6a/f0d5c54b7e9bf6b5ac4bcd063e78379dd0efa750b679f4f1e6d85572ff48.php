<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/library/default.htm */
class __TwigTemplate_9e6af0d5c54b7e9bf6b5ac4bcd063e78379dd0efa750b679f4f1e6d85572ff48 extends Twig_Template
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
        echo "<div id='clem-steam-library'
     class='recently-played-games panel panel-default'
     onInit='";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["__SELF__"]) ? $context["__SELF__"] : null), "html", null, true);
        echo "::onInit'
     onAppend='";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["__SELF__"]) ? $context["__SELF__"] : null), "html", null, true);
        echo "::onAppend' >
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/library/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  27 => 4,  23 => 3,  19 => 1,);
    }
}
