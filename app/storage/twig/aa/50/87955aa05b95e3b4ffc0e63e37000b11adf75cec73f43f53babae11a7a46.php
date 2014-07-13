<?php

/* /home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/container.htm */
class __TwigTemplate_aa5087955aa05b95e3b4ffc0e63e37000b11adf75cec73f43f53babae11a7a46 extends Twig_Template
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
        echo "<div id='clemfeed-steamlibrary'
     class='feed-container'
     onInit='";
        // line 3
        echo twig_escape_filter($this->env, (isset($context["__SELF__"]) ? $context["__SELF__"] : null), "html", null, true);
        echo "::onInit'
     onAppend='";
        // line 4
        echo twig_escape_filter($this->env, (isset($context["__SELF__"]) ? $context["__SELF__"] : null), "html", null, true);
        echo "::onAppend' >
</div>


<div class='feed-container'>
    <div class='head'>
    </div>
    <div class='body'>
        <div class='item'>
            <div class='image'>
            </div>
            <div class='name'>
            </div>
            <div class='time'>
                <div class='recent'>
                </div>
                <div class='forever'>
                </div>
            </div>
        </div>
    </div>
</div>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/plugins/clem/feed/components/steam/library/container.htm";
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
