<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/library/feedHead.htm */
class __TwigTemplate_f294863591259ebef9b204fee1633dd8a699a96a67f54a571782865618123df6 extends Twig_Template
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
        echo "<div class='panel-heading'>
    <h3 class='user-name panel-title'>";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "persona_name"), "html", null, true);
        echo "Recently Played Games</h3>
    <a class='user-page-url' href='";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_url"), "html", null, true);
        echo "'><img class='user-image' src='";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_image_url"), "html", null, true);
        echo "' /></a>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/library/feedHead.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  31 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }
}
