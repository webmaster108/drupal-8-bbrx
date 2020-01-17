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

/* {# inline_template_start #}<div class="slider-image"><div class="field field--name-body"><div class="slide-pic">
{{ field_slider_image_s }}
</div>
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div></div>
<div class="title-text mb-4 px-3 col-md-5">
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div> */
class __TwigTemplate_c3a826bd6ecbd622aab349ecc5c5b5229a6e14581cd88858cd6d5bc6d1859bfc extends \Twig\Template
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
        echo "<div class=\"slider-image\"><div class=\"field field--name-body\"><div class=\"slide-pic\">
";
        // line 2
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_slider_image_s"] ?? null)), "html", null, true);
        echo "
</div>
<h1>";
        // line 4
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_header_image_headline"] ?? null)), "html", null, true);
        echo "</h1>
<h3>";
        // line 5
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_header_image_sub_headline"] ?? null)), "html", null, true);
        echo "</h3>
</div></div>
<div class=\"title-text mb-4 px-3 col-md-5\">
<h1>";
        // line 8
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_header_image_headline"] ?? null)), "html", null, true);
        echo "</h1>
<h3>";
        // line 9
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["field_header_image_sub_headline"] ?? null)), "html", null, true);
        echo "</h3>
</div>";
    }

    public function getTemplateName()
    {
        return "{# inline_template_start #}<div class=\"slider-image\"><div class=\"field field--name-body\"><div class=\"slide-pic\">
{{ field_slider_image_s }}
</div>
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div></div>
<div class=\"title-text mb-4 px-3 col-md-5\">
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div>";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  86 => 9,  82 => 8,  76 => 5,  72 => 4,  67 => 2,  64 => 1,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "{# inline_template_start #}<div class=\"slider-image\"><div class=\"field field--name-body\"><div class=\"slide-pic\">
{{ field_slider_image_s }}
</div>
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div></div>
<div class=\"title-text mb-4 px-3 col-md-5\">
<h1>{{ field_header_image_headline }}</h1>
<h3>{{ field_header_image_sub_headline }}</h3>
</div>", "");
    }
}
