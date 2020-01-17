<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;

/* {# inline_template_start #}<button type="button" id="change-state-popup" class="btn btn-info area-search radius border-0" data-toggle="modal" data-target="#myModal">Choose Your State</button>
      <div class="modal fade" id="myModal" role="dialog">
         <div class="modal-dialog modal-sm ">
              <div class="modal-content p-5">
                 <div class="modal-header position-absolute cross-sign">
                    <button type="button" class="close" data-dismiss="modal">×</button>
                 </div>
               <div class="modal-body p-0"> */
class __TwigTemplate_b8fcd5e790788bed89c75e0e906a9f20274816be0d448f9bf74aed6fe6871caf extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = [];
        $filters = [];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                [],
                []
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->getSourceContext());

            if ($e instanceof SecurityNotAllowedTagError && isset($tags[$e->getTagName()])) {
                $e->setTemplateLine($tags[$e->getTagName()]);
            } elseif ($e instanceof SecurityNotAllowedFilterError && isset($filters[$e->getFilterName()])) {
                $e->setTemplateLine($filters[$e->getFilterName()]);
            } elseif ($e instanceof SecurityNotAllowedFunctionError && isset($functions[$e->getFunctionName()])) {
                $e->setTemplateLine($functions[$e->getFunctionName()]);
            }

            throw $e;
        }

    }

    protected function doDisplay(array $context, array $blocks = [])
    {
        // line 1
        echo "<button type=\"button\" id=\"change-state-popup\" class=\"btn btn-info area-search radius border-0\" data-toggle=\"modal\" data-target=\"#myModal\">Choose Your State</button>
      <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
         <div class=\"modal-dialog modal-sm \">
              <div class=\"modal-content p-5\">
                 <div class=\"modal-header position-absolute cross-sign\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>
                 </div>
               <div class=\"modal-body p-0\">";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<button type=\"button\" id=\"change-state-popup\" class=\"btn btn-info area-search radius border-0\" data-toggle=\"modal\" data-target=\"#myModal\">Choose Your State</button>
      <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
         <div class=\"modal-dialog modal-sm \">
              <div class=\"modal-content p-5\">
                 <div class=\"modal-header position-absolute cross-sign\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>
                 </div>
               <div class=\"modal-body p-0\">";
    }

    public function getDebugInfo()
    {
        return array (  62 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "{# inline_template_start #}<button type=\"button\" id=\"change-state-popup\" class=\"btn btn-info area-search radius border-0\" data-toggle=\"modal\" data-target=\"#myModal\">Choose Your State</button>
      <div class=\"modal fade\" id=\"myModal\" role=\"dialog\">
         <div class=\"modal-dialog modal-sm \">
              <div class=\"modal-content p-5\">
                 <div class=\"modal-header position-absolute cross-sign\">
                    <button type=\"button\" class=\"close\" data-dismiss=\"modal\">×</button>
                 </div>
               <div class=\"modal-body p-0\">", "");
    }
}
