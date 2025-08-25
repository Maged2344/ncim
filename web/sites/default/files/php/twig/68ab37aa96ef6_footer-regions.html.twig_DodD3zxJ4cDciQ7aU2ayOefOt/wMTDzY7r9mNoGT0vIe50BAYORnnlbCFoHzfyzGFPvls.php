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

/* @ncim_theme/includes/footer-regions.html.twig */
class __TwigTemplate_a2258cc24973579e54401565f6e35293 extends Template
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
        // line 11
        yield "<footer class=\"py-7 bg-neutral-50\">
  <div class=\"outer-container\">
    <!-- Main Footer Columns -->
    <div class=\"row row-cols-lg-4 row-cols-md-2 mb-8 g-4\">
      <!-- Column 1: Overview Menu -->
      <div>
        ";
        // line 17
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_1", [], "any", false, false, true, 17)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 18
            yield "          ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_1", [], "any", false, false, true, 18), "html", null, true);
            yield "
        ";
        }
        // line 20
        yield "      </div>
      
      <!-- Column 2: Help & Support Menu -->
      <div>
        ";
        // line 24
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_2", [], "any", false, false, true, 24)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 25
            yield "          ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_2", [], "any", false, false, true, 25), "html", null, true);
            yield "
        ";
        }
        // line 27
        yield "      </div>
      
      <!-- Column 3: Important Links Menu -->
      <div>
        ";
        // line 31
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_3", [], "any", false, false, true, 31)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 32
            yield "          ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_3", [], "any", false, false, true, 32), "html", null, true);
            yield "
        ";
        }
        // line 34
        yield "      </div>
      
      <!-- Column 4: Social Media & Accessibility Custom Block -->
      <div>
        ";
        // line 38
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_4", [], "any", false, false, true, 38)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 39
            yield "          ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_column_4", [], "any", false, false, true, 39), "html", null, true);
            yield "
        ";
        }
        // line 41
        yield "      </div>
    </div>

    <!-- Bottom Section: Terms Menu + Copyright -->
    ";
        // line 45
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 45)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 46
            yield "      ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["page"] ?? null), "footer_bottom", [], "any", false, false, true, 46), "html", null, true);
            yield "
    ";
        }
        // line 48
        yield "
    <!-- Static Copyright Section - Exact same as original -->
    <div class=\"d-flex justify-content-sm-between justify-content-center flex-column flex-sm-row align-items-center flex-wrap gap-3\">
      <div>
        <h4 class=\"fs-18 text-default fw-600\">
          ";
        // line 53
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("جميع الحقوق محفوظة للمركز الوطني للرقابة والتفتيش ©"));
        yield "
          <span class=\"year\" data-year=\"";
        // line 54
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "\"></span>
        </h4>
        <div class=\"text-default\">";
        // line 56
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("تاريخ آخر تعديل:"));
        yield " <span id=\"latest-modifiedDate\">14/12/2020</span></div>
      </div>
      <div class=\"d-flex gap-3 align-items-center\">
        <img src=\"";
        // line 59
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/Saudi_Vision.png\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Saudi Vision"));
        yield "\" title=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Saudi Vision"));
        yield "\">
        <img src=\"";
        // line 60
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/registered.png\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("registered"));
        yield "\" title=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("registered"));
        yield "\">
      </div>
    </div>
  </div>
</footer>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["page", "base_path", "directory"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@ncim_theme/includes/footer-regions.html.twig";
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
        return array (  146 => 60,  138 => 59,  132 => 56,  127 => 54,  123 => 53,  116 => 48,  110 => 46,  108 => 45,  102 => 41,  96 => 39,  94 => 38,  88 => 34,  82 => 32,  80 => 31,  74 => 27,  68 => 25,  66 => 24,  60 => 20,  54 => 18,  52 => 17,  44 => 11,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@ncim_theme/includes/footer-regions.html.twig", "/var/www/html/web/themes/custom/ncim_theme/templates/includes/footer-regions.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 17];
        static $filters = ["escape" => 18, "t" => 53, "date" => 54];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if'],
                ['escape', 't', 'date'],
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
