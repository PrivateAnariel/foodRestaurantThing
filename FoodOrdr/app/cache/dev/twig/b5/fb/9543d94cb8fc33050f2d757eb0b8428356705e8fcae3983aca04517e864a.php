<?php

/* :security:login.html.twig */
class __TwigTemplate_b5fb9543d94cb8fc33050f2d757eb0b8428356705e8fcae3983aca04517e864a extends Twig_Template
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
        if ((isset($context["error"]) ? $context["error"] : null)) {
            // line 2
            echo "    <div>";
            echo twig_escape_filter($this->env, $this->env->getExtension('translator')->trans($this->getAttribute((isset($context["error"]) ? $context["error"] : null), "messageKey", array()), $this->getAttribute((isset($context["error"]) ? $context["error"] : null), "messageData", array())), "html", null, true);
            echo "</div>
";
        }
        // line 4
        echo "
";
        // line 5
        if ($this->env->getExtension('security')->isGranted("IS_AUTHENTICATED_FULLY")) {
            // line 6
            echo "\tLogged in as ";
            echo twig_escape_filter($this->env, $this->getAttribute($this->getAttribute((isset($context["app"]) ? $context["app"] : null), "user", array()), "username", array()), "html", null, true);
            echo "</br>
\t<a href=\"";
            // line 7
            echo $this->env->getExtension('routing')->getPath("logout");
            echo "\">logout</a>
";
        } else {
            // line 9
            echo "\t<form action=\"";
            echo $this->env->getExtension('routing')->getPath("login_check");
            echo "\" method=\"post\">
\t\t<label for=\"username\">Username:</label>
\t\t<input type=\"text\" id=\"username\" name=\"_username\" value=\"";
            // line 11
            echo twig_escape_filter($this->env, (isset($context["last_username"]) ? $context["last_username"] : null), "html", null, true);
            echo "\" />
\t
\t\t<label for=\"password\">Password:</label>
\t\t<input type=\"password\" id=\"password\" name=\"_password\" />
\t\t<button type=\"submit\">login</button>
\t</form>
";
        }
    }

    public function getTemplateName()
    {
        return ":security:login.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  48 => 11,  42 => 9,  37 => 7,  32 => 6,  30 => 5,  27 => 4,  21 => 2,  19 => 1,);
    }
}
