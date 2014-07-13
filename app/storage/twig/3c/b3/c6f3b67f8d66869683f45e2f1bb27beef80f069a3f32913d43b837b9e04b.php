<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/head.htm */
class __TwigTemplate_3cb3c6f3b67f8d66869683f45e2f1bb27beef80f069a3f32913d43b837b9e04b extends Twig_Template
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
    <a class='image-link' href='";
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
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/head.htm";
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
