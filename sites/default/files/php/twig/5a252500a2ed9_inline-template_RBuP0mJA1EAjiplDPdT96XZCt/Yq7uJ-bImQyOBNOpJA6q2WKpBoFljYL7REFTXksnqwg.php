<?php

/* {# inline_template_start #}<code>/track/vehicle_type/{vehicle_type}</code>: GET, PATCH, DELETE</br><code>/entity/vehicle_type</code>: POST */
class __TwigTemplate_32280fa9e030f392ee0c4e5e031daa8994b59aa9c78ed60d5fbefaad1a410243 extends Twig_Template
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
        $tags = array();
        $filters = array();
        $functions = array();

        try {
            $this->env->getExtension('Twig_Extension_Sandbox')->checkSecurity(
                array(),
                array(),
                array()
            );
        } catch (Twig_Sandbox_SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof Twig_Sandbox_SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof Twig_Sandbox_SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

        // line 1
        echo "<code>/track/vehicle_type/{vehicle_type}</code>: GET, PATCH, DELETE</br><code>/entity/vehicle_type</code>: POST";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<code>/track/vehicle_type/{vehicle_type}</code>: GET, PATCH, DELETE</br><code>/entity/vehicle_type</code>: POST";
    }

    public function getDebugInfo()
    {
        return array (  43 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Twig_Source("", "{# inline_template_start #}<code>/track/vehicle_type/{vehicle_type}</code>: GET, PATCH, DELETE</br><code>/entity/vehicle_type</code>: POST", "");
    }
}
