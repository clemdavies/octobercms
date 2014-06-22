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
        echo "<div class='panel panel-default'>
    <div class='panel-heading'>
        <h3 class='panel-title'>Recently Played</h3>
        <h3 class='panel-title'>";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["url"]) ? $context["url"] : null), "html", null, true);
        echo "</h3>
    </div>
    <div class='panel-body'>
        <ul class='list-group'>
            ";
        // line 8
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["games"]) ? $context["games"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["game"]) {
            // line 9
            echo "                <li class='list-group-item'>
                    <div class='icon'>";
            // line 10
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "icon"), "html", null, true);
            echo "</div>
                    <div class='name'>";
            // line 11
            echo twig_escape_filter($this->env, $this->getAttribute((isset($context["game"]) ? $context["game"] : null), "name"), "html", null, true);
            echo "</div>
                </li>
            ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['game'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 14
        echo "        </ul>
    </div>
</div>";
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
        return array (  51 => 14,  42 => 11,  38 => 10,  35 => 9,  31 => 8,  24 => 4,  19 => 1,);
    }
}
