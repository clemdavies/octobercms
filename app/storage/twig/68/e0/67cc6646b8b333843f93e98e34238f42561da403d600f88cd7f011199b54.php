<?php

/* /home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/body.htm */
class __TwigTemplate_68e067cc6646b8b333843f93e98e34238f42561da403d600f88cd7f011199b54 extends Twig_Template
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
        echo "<div class='body'>
    <ul class='games-list list-group'>
        ";
        // line 3
        $context['_parent'] = (array) $context;
        $context['_seq'] = twig_ensure_traversable((isset($context["games"]) ? $context["games"] : null));
        foreach ($context['_seq'] as $context["_key"] => $context["game"]) {
            // line 4
            echo "            ";
            $context['__cms_partial_params'] = [];
            $context['__cms_partial_params']['game'] = (isset($context["game"]) ? $context["game"] : null)            ;
            echo $this->env->getExtension('CMS')->partialFunction(((isset($context["__SELF__"]) ? $context["__SELF__"] : null) . "::item")            , $context['__cms_partial_params']            );
            unset($context['__cms_partial_params']);
            // line 5
            echo "        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_iterated'], $context['_key'], $context['game'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 6
        echo "    </ul>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/body.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  39 => 6,  33 => 5,  27 => 4,  23 => 3,  29 => 4,  22 => 2,  19 => 1,);
    }
}
