<?php

/* /home/clem/Dropbox/october/plugins/clem/steam/components/recentlyplayed/default.htm */
class __TwigTemplate_e4a6008aed7e9b665fb529513f750fcab4de4cefc8be1ae9f8cefc4b8d492b78 extends Twig_Template
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
        echo "<div class='recently-played-games panel panel-default'>
    <div class='panel-heading'>
        <h3 class='user-name panel-title'>";
        // line 3
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "persona_name"), "html", null, true);
        echo "Recently Played Games</h3>
        <a class='user-page-url' href='";
        // line 4
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_url"), "html", null, true);
        echo "'><img class='user-image' src='";
        echo twig_escape_filter($this->env, $this->getAttribute((isset($context["user"]) ? $context["user"] : null), "profile_image_url"), "html", null, true);
        echo "' /></a>
    </div>
    <div class='panel-body'>
        <ul class='games-list list-group'>
            ";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["games"]) ? $context["games"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["game"]) {
            // line 9
            echo "                <li class='game list-group-item' rank='";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "rank"), "html", null, true);
            echo "'>
                    <a class='game-page-link' href='";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_url"), "html", null, true);
            echo "'><img class='game-icon' src='";
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "app_image_url"), "html", null, true);
            echo "'/></a>
                    <div class='game-name'>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "name"), "html", null, true);
            echo "</div>
                    <div class='game-playtime-recent'>";
            // line 12
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeRecentString", array(), "method"), "html", null, true);
            echo "</div>
                    <div class='game-playtime-forever'>";
            // line 13
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "playtimeForeverString", array(), "method"), "html", null, true);
            echo "</div>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['game'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 16
        echo "
        </ul>
    </div>
</div>

<form data-request=\"onTest\" data-request-update=\"calcresult: '#result'\">
    <input type=\"text\" name=\"value1\"/>
    <input type=\"text\" name=\"value2\"/>
    <input type=\"submit\" value=\"Calculate\">
</form>
<div id=\"#result\"></div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/steam/components/recentlyplayed/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  68 => 16,  59 => 13,  55 => 12,  51 => 11,  45 => 10,  40 => 9,  36 => 8,  27 => 4,  23 => 3,  19 => 1,);
    }
}
