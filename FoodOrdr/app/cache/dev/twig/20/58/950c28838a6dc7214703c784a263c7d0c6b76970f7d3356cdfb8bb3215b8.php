<?php

/* default/index.html.twig */
class __TwigTemplate_2058950c28838a6dc7214703c784a263c7d0c6b76970f7d3356cdfb8bb3215b8 extends Twig_Template
{
    public function __construct(Twig_Environment $env)
    {
        parent::__construct($env);

        // line 1
        try {
            $this->parent = $this->env->loadTemplate("base.html.twig");
        } catch (Twig_Error_Loader $e) {
            $e->setTemplateFile($this->getTemplateName());
            $e->setTemplateLine(1);

            throw $e;
        }

        $this->blocks = array(
            'body' => array($this, 'block_body'),
        );
    }

    protected function doGetParent(array $context)
    {
        return "base.html.twig";
    }

    protected function doDisplay(array $context, array $blocks = array())
    {
        $this->parent->display($context, array_merge($this->blocks, $blocks));
    }

    // line 3
    public function block_body($context, array $blocks = array())
    {
        // line 4
        echo "Welcome, ";
        echo twig_escape_filter($this->env, (isset($context["name"]) ? $context["name"] : $this->getContext($context, "name")), "html", null, true);
        echo "<br/><br/>
";
        // line 5
        if (array_key_exists("message", $context)) {
            // line 6
            echo "\t";
            echo twig_escape_filter($this->env, (isset($context["message"]) ? $context["message"] : $this->getContext($context, "message")), "html", null, true);
            echo "<br/><br/>
";
        }
        // line 8
        echo "<a href=\"";
        echo $this->env->getExtension('routing')->getPath("user_registration");
        echo "\">Register a new user</a><br/>
<a href=\"";
        // line 9
        echo $this->env->getExtension('routing')->getPath("user_modification");
        echo "\">Modify Current User</a><br/>
<a href=\"";
        // line 10
        echo $this->env->getExtension('routing')->getPath("display_user");
        echo "\">Display all users</a><br/>

";
    }

    public function getTemplateName()
    {
        return "default/index.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  61 => 10,  57 => 9,  52 => 8,  46 => 6,  44 => 5,  39 => 4,  36 => 3,  11 => 1,);
    }
}
