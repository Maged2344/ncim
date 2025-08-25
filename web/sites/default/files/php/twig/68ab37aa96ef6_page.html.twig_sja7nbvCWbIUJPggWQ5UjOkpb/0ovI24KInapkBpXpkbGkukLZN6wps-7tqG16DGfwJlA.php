<?php

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Extension\CoreExtension;
use Twig\Extension\SandboxExtension;
use Twig\Markup;
use Twig\Sandbox\SecurityError;
use Twig\Sandbox\SecurityNotAllowedTagError;
use Twig\Sandbox\SecurityNotAllowedFilterError;
use Twig\Sandbox\SecurityNotAllowedFunctionError;
use Twig\Source;
use Twig\Template;
use Twig\TemplateWrapper;

/* themes/custom/ncim_theme/page.html.twig */
class __TwigTemplate_89c8574bdd5ed03988fdbe0a2f3cdda8 extends Template
{
    private Source $source;
    /**
     * @var array<string, Template>
     */
    private array $macros = [];

    public function __construct(Environment $env)
    {
        parent::__construct($env);

        $this->source = $this->getSourceContext();

        $this->parent = false;

        $this->blocks = [
        ];
        $this->sandbox = $this->extensions[SandboxExtension::class];
        $this->checkSecurity();
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 67
        yield "<div id=\"page\" class=\"page-wrapper\">

  <!-- Include custom navigation template -->
  ";
        // line 70
        yield from $this->load("@ncim_theme/includes/control-bar.html.twig", 70)->unwrap()->yield($context);
        // line 71
        yield "
  ";
        // line 72
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 72)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 73
            yield "    <div class=\"primary-wrapper\">
      ";
            // line 74
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "primary_menu", [], "any", false, false, true, 74), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 77
        yield "
  ";
        // line 78
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["node"] ?? null), "bundle", [], "any", false, false, true, 78) != "news")) {
            // line 79
            yield "    ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 79)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 80
                yield "      <div class=\"breadcrumb-wrapper\">
        ";
                // line 81
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "breadcrumb", [], "any", false, false, true, 81), "html", null, true);
                yield "
      </div>
    ";
            }
            // line 84
            yield "  ";
        }
        // line 85
        yield "
  ";
        // line 86
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 86)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 87
            yield "    <div class=\"highlighted\">
      ";
            // line 88
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "highlighted", [], "any", false, false, true, 88), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 91
        yield "
  ";
        // line 92
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 92)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 93
            yield "    <div class=\"featured-top\">
      ";
            // line 94
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "featured_top", [], "any", false, false, true, 94), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 97
        yield "
  <main id=\"\" class=\"\" role=\"main\">
    <div class=\"\">
      ";
        // line 100
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 100)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 101
            yield "        <aside class=\"sidebar sidebar--first\" role=\"complementary\">
          ";
            // line 102
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_first", [], "any", false, false, true, 102), "html", null, true);
            yield "
        </aside>
      ";
        }
        // line 105
        yield "
      <div class=\"content-area\">
        ";
        // line 107
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_top", [], "any", false, false, true, 107)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 108
            yield "          <div class=\"page-top\">
            ";
            // line 109
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_top", [], "any", false, false, true, 109), "html", null, true);
            yield "
          </div>
        ";
        }
        // line 112
        yield "
        <div class=\"content\">
          ";
        // line 114
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "content", [], "any", false, false, true, 114), "html", null, true);
        yield "
        </div>

        ";
        // line 117
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_bottom", [], "any", false, false, true, 117)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 118
            yield "          <div class=\"page-bottom\">
            ";
            // line 119
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "page_bottom", [], "any", false, false, true, 119), "html", null, true);
            yield "
          </div>
        ";
        }
        // line 122
        yield "      </div>

      ";
        // line 124
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 124)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 125
            yield "        <aside class=\"sidebar sidebar--second\" role=\"complementary\">
          ";
            // line 126
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "sidebar_second", [], "any", false, false, true, 126), "html", null, true);
            yield "
        </aside>
      ";
        }
        // line 129
        yield "    </div>
  </main>

  ";
        // line 132
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "feedback", [], "any", false, false, true, 132)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 133
            yield "    <div class=\"feedback-wrapper\">
      ";
            // line 134
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "feedback", [], "any", false, false, true, 134), "html", null, true);
            yield "
    </div>
  ";
        }
        // line 137
        yield "
  ";
        // line 138
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 138)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 139
            yield "    <footer class=\"footer\" role=\"contentinfo\">
      <div class=\"footer__inner\">
        ";
            // line 141
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer", [], "any", false, false, true, 141), "html", null, true);
            yield "
      </div>
    </footer>
  ";
        }
        // line 145
        yield "
  ";
        // line 147
        yield "  ";
        yield from $this->load("@ncim_theme/includes/footer-regions.html.twig", 147)->unwrap()->yield($context);
        // line 148
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "node"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ncim_theme/page.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function isTraitable(): bool
    {
        return false;
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  218 => 148,  215 => 147,  212 => 145,  205 => 141,  201 => 139,  199 => 138,  196 => 137,  190 => 134,  187 => 133,  185 => 132,  180 => 129,  174 => 126,  171 => 125,  169 => 124,  165 => 122,  159 => 119,  156 => 118,  154 => 117,  148 => 114,  144 => 112,  138 => 109,  135 => 108,  133 => 107,  129 => 105,  123 => 102,  120 => 101,  118 => 100,  113 => 97,  107 => 94,  104 => 93,  102 => 92,  99 => 91,  93 => 88,  90 => 87,  88 => 86,  85 => 85,  82 => 84,  76 => 81,  73 => 80,  70 => 79,  68 => 78,  65 => 77,  59 => 74,  56 => 73,  54 => 72,  51 => 71,  49 => 70,  44 => 67,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ncim_theme/page.html.twig", "/var/www/html/web/themes/custom/ncim_theme/page.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["include" => 70, "if" => 72];
        static $filters = ["escape" => 74];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['include', 'if'],
                ['escape'],
                [],
                $this->source
            );
        } catch (SecurityError $e) {
            $e->setSourceContext($this->source);

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
}
