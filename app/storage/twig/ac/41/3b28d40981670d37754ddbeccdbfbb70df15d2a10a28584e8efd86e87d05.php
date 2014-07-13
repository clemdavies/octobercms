<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/item.htm */
class __TwigTemplate_ac413b28d40981670d37754ddbeccdbfbb70df15d2a10a28584e8efd86e87d05 extends Twig_Template
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
        echo "
<li class='game list-group-item' rank='";
        // line 2
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "rank"), "html", null, true);
        echo "'>
    <a class='image-link' href='";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_url"), "html", null, true);
        echo "'><img class='image' src='";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_image_url"), "html", null, true);
        echo "'/></a>
    <div class='text'>
        <div class='game-name'>";
        // line 5
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "name"), "html", null, true);
        echo "</div>
        <div class='game-playtime-recent'>";
        // line 6
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeRecentString", array(), "method"), "html", null, true);
        echo "</div>
        <div class='game-playtime-forever'>";
        // line 7
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeForeverString", array(), "method"), "html", null, true);
        echo "</div>
    </div>
</li>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/libraryfeed/item.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  41 => 7,  37 => 6,  33 => 5,  26 => 3,  29 => 4,  22 => 2,  19 => 1,);
    }
}
