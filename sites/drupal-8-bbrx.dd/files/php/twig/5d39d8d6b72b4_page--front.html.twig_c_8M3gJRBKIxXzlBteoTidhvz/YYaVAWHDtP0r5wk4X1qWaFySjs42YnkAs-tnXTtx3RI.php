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

/* themes/custom/basic_bluerx/templates/system/page--front.html.twig */
class __TwigTemplate_b6a08fb7fd73fd6c956a59c50295c2b1363dc23b1044b516af8b1e1020b53ceb extends \Twig\Template
{
    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->parent = false;

        $this->blocks = [
            'header_left' => [$this, 'block_header_left'],
            'header_right' => [$this, 'block_header_right'],
            'navbar' => [$this, 'block_navbar'],
            'slider' => [$this, 'block_slider'],
            'main' => [$this, 'block_main'],
            'content' => [$this, 'block_content'],
            'contact' => [$this, 'block_contact'],
            'footer' => [$this, 'block_footer'],
            'content_bottom' => [$this, 'block_content_bottom'],
        ];
        $this->sandbox = $this->env->getExtension('\Twig\Extension\SandboxExtension');
        $tags = ["if" => 58, "block" => 59, "set" => 88];
        $filters = ["t" => 76, "clean_class" => 96];
        $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'block', 'set'],
                ['t', 'clean_class'],
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
        // line 54
        echo "
  ";
        // line 56
        echo "  <div class=\"header_wrapper_section\" id=\"header_wrapper_section\">
  <div id=\"header-left\" class=\"container py-4 head-point\">
    ";
        // line 58
        if ($this->getAttribute(($context["page"] ?? null), "header_left", [])) {
            // line 59
            echo "      ";
            $this->displayBlock('header_left', $context, $blocks);
            // line 62
            echo "    ";
        }
        // line 63
        echo "    
    ";
        // line 64
        if ($this->getAttribute(($context["page"] ?? null), "header_right", [])) {
            // line 65
            echo "      ";
            $this->displayBlock('header_right', $context, $blocks);
            // line 70
            echo "    ";
        }
        // line 71
        echo "
    <div class=\"navbar-header\">
          ";
        // line 74
        echo "          ";
        if ($this->getAttribute(($context["page"] ?? null), "navigation", [])) {
            // line 75
            echo "            <button type=\"button\" class=\"navbar-toggle\" data-toggle=\"collapse\" data-target=\"#navbar-collapse\">
              <span class=\"sr-only\">";
            // line 76
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->renderVar(t("Toggle navigation"));
            echo "</span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
              <span class=\"icon-bar\"></span>
            </button>
          ";
        }
        // line 82
        echo "          </div>


  </div>
  

";
        // line 88
        $context["container"] = (($this->getAttribute($this->getAttribute(($context["theme"] ?? null), "settings", []), "fluid_container", [])) ? ("container-fluid") : ("container"));
        // line 90
        if (($this->getAttribute(($context["page"] ?? null), "navigation", []) || $this->getAttribute(($context["page"] ?? null), "navigation_collapsible", []))) {
            // line 91
            echo "  ";
            $this->displayBlock('navbar', $context, $blocks);
        }
        // line 111
        echo "</div>
    ";
        // line 113
        echo "    ";
        if ($this->getAttribute(($context["page"] ?? null), "slider", [])) {
            // line 114
            echo "      ";
            $this->displayBlock('slider', $context, $blocks);
            // line 121
            echo "    ";
        }
        // line 122
        echo "
";
        // line 124
        $this->displayBlock('main', $context, $blocks);
        // line 135
        echo "  
  ";
        // line 137
        echo "  ";
        if ($this->getAttribute(($context["page"] ?? null), "contact", [])) {
            // line 138
            echo "    ";
            $this->displayBlock('contact', $context, $blocks);
            // line 145
            echo "  ";
        }
        // line 146
        echo "

";
        // line 148
        if ($this->getAttribute(($context["page"] ?? null), "footer", [])) {
            // line 149
            echo "  ";
            $this->displayBlock('footer', $context, $blocks);
        }
        // line 157
        echo "


";
        // line 160
        if ($this->getAttribute(($context["page"] ?? null), "content_bottom", [])) {
            // line 161
            echo "  ";
            $this->displayBlock('content_bottom', $context, $blocks);
        }
    }

    // line 59
    public function block_header_left($context, array $blocks = [])
    {
        // line 60
        echo "          ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header_left", [])), "html", null, true);
        echo "
      ";
    }

    // line 65
    public function block_header_right($context, array $blocks = [])
    {
        // line 66
        echo "      <div class=\"right-section\">
          ";
        // line 67
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "header_right", [])), "html", null, true);
        echo "
      </div>
      ";
    }

    // line 91
    public function block_navbar($context, array $blocks = [])
    {
        // line 92
        echo "    ";
        // line 93
        $context["navbar_classes"] = [0 => "navbar", 1 => (($this->getAttribute($this->getAttribute(        // line 95
($context["theme"] ?? null), "settings", []), "navbar_inverse", [])) ? ("navbar-inverse") : ("navbar-default")), 2 => (($this->getAttribute($this->getAttribute(        // line 96
($context["theme"] ?? null), "settings", []), "navbar_position", [])) ? (("navbar-" . \Drupal\Component\Utility\Html::getClass($this->sandbox->ensureToStringAllowed($this->getAttribute($this->getAttribute(($context["theme"] ?? null), "settings", []), "navbar_position", []))))) : (($context["container"] ?? null)))];
        // line 99
        echo "    <nav id=\"stick-bar\" class=\"navbar navbar-default journey-nav\">
        <div class=\"container\">
        ";
        // line 102
        echo "        ";
        if ($this->getAttribute(($context["page"] ?? null), "navigation", [])) {
            // line 103
            echo "          <div id=\"navbar-collapse\" class=\"navbar-collapse\">
            ";
            // line 104
            echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "navigation", [])), "html", null, true);
            echo "
          </div>
        ";
        }
        // line 107
        echo "        </div>
      </nav>
  ";
    }

    // line 114
    public function block_slider($context, array $blocks = [])
    {
        // line 115
        echo "        <div class=\"col-xs-12 p-0 slider-area\">
          <div class=\"container\">
            ";
        // line 117
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "slider", [])), "html", null, true);
        echo "
          </div>
        </div>
      ";
    }

    // line 124
    public function block_main($context, array $blocks = [])
    {
        // line 125
        echo "  <div role=\"main\" class=\"col-xs-12 p-0\">
    <div class=\"container py-5\">
      ";
        // line 128
        echo "        ";
        // line 129
        echo "        ";
        $this->displayBlock('content', $context, $blocks);
        // line 132
        echo "    </div>
  </div>
";
    }

    // line 129
    public function block_content($context, array $blocks = [])
    {
        // line 130
        echo "          ";
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content", [])), "html", null, true);
        echo "
        ";
    }

    // line 138
    public function block_contact($context, array $blocks = [])
    {
        // line 139
        echo "      <div class=\"col-xs-12 p-0 contact-area\">
        <div class=\"container py-5\">
          ";
        // line 141
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "contact", [])), "html", null, true);
        echo "
        </div>
      </div>
    ";
    }

    // line 149
    public function block_footer($context, array $blocks = [])
    {
        // line 150
        echo "    <div class=\"col-xs-12 p-0 bottom-links\">
      <div class=\"py-5\">
        ";
        // line 152
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "footer", [])), "html", null, true);
        echo "
      </div>
    </div>
  ";
    }

    // line 161
    public function block_content_bottom($context, array $blocks = [])
    {
        // line 162
        echo "    <div class=\"col-xs-12 p-0\">
      <div class=\"container py-5\">
        ";
        // line 164
        echo $this->env->getExtension('Drupal\Core\Template\TwigExtension')->escapeFilter($this->env, $this->sandbox->ensureToStringAllowed($this->getAttribute(($context["page"] ?? null), "content_bottom", [])), "html", null, true);
        echo "
      </div>
    </div>
  ";
    }

    public function getTemplateName()
    {
        return "themes/custom/basic_bluerx/templates/system/page--front.html.twig";
    }

    public function isTraitable()
    {
        return false;
    }

    public function getDebugInfo()
    {
        return array (  311 => 164,  307 => 162,  304 => 161,  296 => 152,  292 => 150,  289 => 149,  281 => 141,  277 => 139,  274 => 138,  267 => 130,  264 => 129,  258 => 132,  255 => 129,  253 => 128,  249 => 125,  246 => 124,  238 => 117,  234 => 115,  231 => 114,  225 => 107,  219 => 104,  216 => 103,  213 => 102,  209 => 99,  207 => 96,  206 => 95,  205 => 93,  203 => 92,  200 => 91,  193 => 67,  190 => 66,  187 => 65,  180 => 60,  177 => 59,  171 => 161,  169 => 160,  164 => 157,  160 => 149,  158 => 148,  154 => 146,  151 => 145,  148 => 138,  145 => 137,  142 => 135,  140 => 124,  137 => 122,  134 => 121,  131 => 114,  128 => 113,  125 => 111,  121 => 91,  119 => 90,  117 => 88,  109 => 82,  100 => 76,  97 => 75,  94 => 74,  90 => 71,  87 => 70,  84 => 65,  82 => 64,  79 => 63,  76 => 62,  73 => 59,  71 => 58,  67 => 56,  64 => 54,);
    }

    /** @deprecated since 1.27 (to be removed in 2.0). Use getSourceContext() instead */
    public function getSource()
    {
        @trigger_error('The '.__METHOD__.' method is deprecated since version 1.27 and will be removed in 2.0. Use getSourceContext() instead.', E_USER_DEPRECATED);

        return $this->getSourceContext()->getCode();
    }

    public function getSourceContext()
    {
        return new Source("", "themes/custom/basic_bluerx/templates/system/page--front.html.twig", "D:\\develoment\\jsonkeel\\dev\\drupal-8-bbrx\\themes\\custom\\basic_bluerx\\templates\\system\\page--front.html.twig");
    }
}
