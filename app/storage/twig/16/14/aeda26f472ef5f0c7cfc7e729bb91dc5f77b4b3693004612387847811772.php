<?php

/* /home/clem/Dropbox/october/themes/clem/layouts/default.htm */
class __TwigTemplate_1614aeda26f472ef5f0c7cfc7e729bb91dc5f77b4b3693004612387847811772 extends Twig_Template
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
        echo "<!DOCTYPE html>
<html>
    <head>
        <title>ClemDavies</title>
        <link rel=\"icon\" type=\"image/png\" href=\"\" />
        ";
        // line 6
        echo $this->env->getExtension('CMS')->assetsFunction('css');
        echo $this->env->getExtension('CMS')->displayBlock('styles');
        // line 7
        echo "        <link href=\"";
        echo $this->env->getExtension('CMS')->themeFilter(array(0 => "assets/css/theme.css"));
        echo "\" rel=\"stylesheet\">
    </head>
    <body>

        <!-- Header -->
        <header id=\"layout-header\">
        </header>

        <!-- Content -->
        <section id=\"layout-content\">
            ";
        // line 17
        echo $this->env->getExtension('CMS')->pageFunction();
        // line 18
        echo "        </section>

        <!-- Footer -->
        <footer id=\"layout-footer\">
        </footer>

        <!-- Scripts -->
        <script src=\"";
        // line 25
        echo $this->env->getExtension('CMS')->themeFilter(array(0 => "assets/javascript/jquery.js", 1 => "assets/javascript/app.js"));
        // line 28
        echo "\"></script>
        ";
        // line 29
        echo '<script src="'. Request::getBaseUrl() .'/modules/system/assets/js/framework.js"></script>'.PHP_EOL;
        echo '<script src="'. Request::getBaseUrl() .'/modules/system/assets/js/framework.extras.js"></script>'.PHP_EOL;
        echo '<link href="'. Request::getBaseUrl() .'/modules/system/assets/css/framework.extras.css" rel="stylesheet">'.PHP_EOL;
        // line 30
        echo "        ";
        echo $this->env->getExtension('CMS')->assetsFunction('js');
        echo $this->env->getExtension('CMS')->displayBlock('scripts');
        // line 31
        echo "    </body>
</html>";
    }

    public function getTemplateName()
    {
        return "/home/clem/Dropbox/october/themes/clem/layouts/default.htm";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  67 => 31,  63 => 30,  59 => 29,  56 => 28,  54 => 25,  45 => 18,  43 => 17,  29 => 7,  26 => 6,  19 => 1,);
    }
}
