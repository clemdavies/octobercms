<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/container.htm */
class __TwigTemplate_d356362159f5e325cac5d979d78be4252921c7d0a2f873f4892252f8aa1c4517 extends Twig_Template
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
        echo "<div id='clem-steam-feedlibrary'
     class='clem-feed'
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
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/container.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 7,  37 => 6,  26 => 3,  39 => 6,  33 => 5,  27 => 4,  23 => 3,  29 => 4,  22 => 2,  19 => 1,);
    }
}
