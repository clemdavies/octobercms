<?php

/* /home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/head.htm */
class __TwigTemplate_cd44e582346dd621b1cddb0b3cde0427d0bf696ef202f91766c4128430f5770b extends Twig_Template
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
        echo "<div class='head'>
    <a class='thumbnail' href='";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_url"), "html", null, true);
        echo "'><img class='image' src='";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_image_url"), "html", null, true);
        echo "' /></a>
    <h3 class='title'>Steam Games</h3>
    <h3 class='subtitle username'>";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "persona_name"), "html", null, true);
        echo "</h3>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/head.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  29 => 4,  22 => 2,  19 => 1,);
    }
}
