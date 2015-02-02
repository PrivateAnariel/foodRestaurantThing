<?php

/* base.html.twig */
class __TwigTemplate_576d42db29e394be63bde67f2011e113e4ae3afe0303132704c89fbe76a4e462 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = array(
            'title' => array($this, 'block_title'),
            'stylesheets' => array($this, 'block_stylesheets'),
            'body' => array($this, 'block_body'),
            'javascripts' => array($this, 'block_javascripts'),
        );
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        // line 1
        echo "<!DOCTYPE html>
<html>
    <head>
        <meta charset=\"UTF-8\" />
        <title>";
        // line 5
        $this->displayBlock('title', $context, $blocks);
        echo "</title>
        ";
        // line 6
        $this->displayBlock('stylesheets', $context, $blocks);
        // line 7
        echo "        <link rel=\"icon\" type=\"image/x-icon\" href=\"";
        echo twig_escape_filter($this->env, $this->env->getExtension('assets')->getAssetUrl("favicon.ico"), "html", null, true);
        echo "\" />
    </head>
    <body>
        ";
        // line 10
        $this->displayBlock('body', $context, $blocks);
        // line 11
        echo "        ";
        $this->displayBlock('javascripts', $context, $blocks);
        // line 12
        echo "\t\t<br/><br/>
\t\t
\t\t";
        // line 14
        if (array_key_exists("authenticated", $context)) {
            // line 15
            echo "\t\t\t<a href=\"";
            echo $this->env->getExtension('routing')->getPath("logout");
            echo "\">Logout</a><br/>
\t\t";
        } else {
            // line 17
            echo "\t\t\t<div id=\"sidebar\">
\t\t\t\t";
            // line 18
            echo $this->env->getExtension('http_kernel')->renderFragment($this->env->getExtension('http_kernel')->controller("AppBundle:Security:login"));
            echo "
\t\t\t</div>
\t\t\t<a href=\"";
            // line 20
            echo $this->env->getExtension('routing')->getPath("user_registration");
            echo "\">Register a new user</a><br/>\t
\t\t";
        }
        // line 22
        echo "    </body>
</html>
";
    }

    // line 5
    public function block_title($context, array $blocks = array())
    {
        echo "Welcome!";
    }

    // line 6
    public function block_stylesheets($context, array $blocks = array())
    {
    }

    // line 10
    public function block_body($context, array $blocks = array())
    {
    }

    // line 11
    public function block_javascripts($context, array $blocks = array())
    {
    }

    public function getTemplateName()
    {
        return "base.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  94 => 11,  89 => 10,  84 => 6,  78 => 5,  72 => 22,  67 => 20,  62 => 18,  59 => 17,  53 => 15,  51 => 14,  47 => 12,  44 => 11,  42 => 10,  35 => 7,  33 => 6,  29 => 5,  23 => 1,);
    }
}
