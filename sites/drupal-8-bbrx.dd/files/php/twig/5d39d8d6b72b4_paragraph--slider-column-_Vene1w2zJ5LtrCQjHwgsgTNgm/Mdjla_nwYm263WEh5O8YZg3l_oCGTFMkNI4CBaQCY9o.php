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

/* themes/custom/basic_bluerx/templates/paragraphs/paragraph--slider-column-content.html.twig */
class __TwigTemplate_2e426cc06c73c7e4b5557c60f46f8618f8ff80da1f3825e67607a3d59c9ed38c extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["set" => 42, "if" => 51];
        $filters = ["clean_class" => 44];
        $functions = ["file_url" => 53];

        try {
            $this->sandbox->checkSecurity(
                ['set', 'if'],
                ['clean_class'],
                ['file_url']
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
        // line 42
        $context["classes"] = [0 => "paragraph", 1 => ("paragraph--type--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($this->getAttribute(        // line 44
($context["paragraph"] ?? null), "bundle", [])))), 2 => ((        // line 45
($context["view_mode"] ?? null)) ? (("paragraph--view-mode--" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed(($context["view_mode"] ?? null))))) : ("")), 3 => (( !$this->getAttribute(        // line 46
($context["paragraph"] ?? null), "isPublished", [], "method")) ? ("paragraph--unpublished") : (""))];
        // line 49
        echo "<div class=\"col-sm-6 col-md-3 cOuter text-center pid-";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["paragraph"] ?? null), "id", [], "method")), "html", null, true);
        echo "\">
  <div class=\"field--name-body\">
    ";
        // line 51
        if ($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_icon_img", []), 0, []), "target_id", [])) {
            // line 52
            echo "    ";
            $context["img_uri"] = $this->getAttribute($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_icon_img", []), "entity", []), "uri", []), "value", []);
            // line 53
            echo "    ";
            $context["img_url"] = call_user_func_array($this->env->getFunction('file_url')->getCallable(), [$this->sandbox->ensureToStringAllowed(($context["img_uri"] ?? null))]);
            // line 54
            echo "    <a href=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link_button", []), 0, [], "array"), "#url", [], "array")), "html", null, true);
            echo "\"><img class=\"mt-3\" src=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed(($context["img_url"] ?? null)), "html", null, true);
            echo "\" alt=\"";
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_icon_img", []), 0, []), "alt", [])), "html", null, true);
            echo "\"></a>
    ";
        }
        // line 56
        echo "    <a href=\"";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link_button", []), 0, [], "array"), "#url", [], "array")), "html", null, true);
        echo "\"><h3>";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_main_title", []), 0, []), "value", [])), "html", null, true);
        echo "</h3></a>
    <p>";
        // line 57
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_column_description", []), 0, []), "value", [])), "html", null, true);
        echo "</p>
    <p><a class=\"btn my-3 btn-enroll\" href=\"";
        // line 58
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["content"] ?? null), "field_link_button", []), 0, [], "array"), "#url", [], "array")), "html", null, true);
        echo "\">";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute($this->getAttribute(($context["paragraph"] ?? null), "field_link_button", []), 0, []), "title", [])), "html", null, true);
        echo "</a></p>
  </div>
</div>";
    }

    public function getTemplateName()
    {
        return "themes/custom/basic_bluerx/templates/paragraphs/paragraph--slider-column-content.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  95 => 58,  91 => 57,  84 => 56,  74 => 54,  71 => 53,  68 => 52,  66 => 51,  60 => 49,  58 => 46,  57 => 45,  56 => 44,  55 => 42,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/basic_bluerx/templates/paragraphs/paragraph--slider-column-content.html.twig", "D:\\develoment\\jsonkeel\\dev\\drupal-8-bbrx\\themes\\custom\\basic_bluerx\\templates\\paragraphs\\paragraph--slider-column-content.html.twig");
    }
}
