<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/library/feedBody.htm */
class __TwigTemplate_95c48ca41c44f7432f5f95ccf04011f3cd19815e6975fa75f4b8cc64e028999b extends Twig_Template
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
        echo "<div class='panel-body'>
    <ul class='games-list list-group'>
        ";
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["games"]) ? $context["games"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["game"]) {
            // line 4
            echo "            <li class='game list-group-item' rank='";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "rank"), "html", null, true);
            echo "'>
                <a class='game-page-link' href='";
            // line 5
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_url"), "html", null, true);
            echo "'><img class='game-icon' src='";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_image_url"), "html", null, true);
            echo "'/></a>
                <div class='game-name'>";
            // line 6
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "name"), "html", null, true);
            echo "</div>
                <div class='game-playtime-recent'>";
            // line 7
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeRecentString", array(), "method"), "html", null, true);
            echo "</div>
                <div class='game-playtime-forever'>";
            // line 8
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeForeverString", array(), "method"), "html", null, true);
            echo "</div>
            </li>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['game'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 11
        echo "    </ul>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/library/feedBody.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  55 => 11,  46 => 8,  42 => 7,  38 => 6,  32 => 5,  27 => 4,  23 => 3,  31 => 4,  26 => 3,  22 => 2,  19 => 1,);
    }
}
