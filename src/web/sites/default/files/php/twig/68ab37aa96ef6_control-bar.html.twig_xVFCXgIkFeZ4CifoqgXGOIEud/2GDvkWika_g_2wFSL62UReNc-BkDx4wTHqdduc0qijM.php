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

/* @ncim_theme/includes/control-bar.html.twig */
class __TwigTemplate_72a779900c9663909473acf4d6bfc389 extends Template
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
        // line 7
        yield "<div class=\"bg-neutral-50 control-bar border border-neutral-primary border-bottom-1\">
  <div class=\"outer-container d-flex justify-content-between align-items-center\">
    <!-- Desktop layout -->
    <div class=\"d-flex gap-4\">
      <div class=\"d-flex gap-2 align-items-center\">
        <img src=\"";
        // line 12
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/wheather.svg\" height=\"18\" width=\"18\" alt=\"weather\" class=\"object-fit-contain\" id=\"weather-icon\">
        <span class=\"text-primary-paragraph fs-14\" id=\"weather-status\"></span>
      </div>
      <div class=\"d-none d-md-flex gap-2 align-items-center\">
        <img src=\"";
        // line 16
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/calender.svg\" height=\"18\" width=\"18\" alt=\"calender\" class=\"object-fit-contain\">
        <span class=\"text-primary-paragraph fs-14\" id=\"date-time\">";
        // line 17
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "j-F-Y"), "html", null, true);
        yield "</span>
      </div>
      <div class=\"d-none d-md-flex gap-2 align-items-center\">
        <img src=\"";
        // line 20
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/clock.svg\" height=\"18\" width=\"18\" alt=\"time\" class=\"object-fit-contain\">
        <span class=\"text-primary-paragraph fs-14\" id=\"time\">";
        // line 21
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "g:i A"), "html", null, true);
        yield "</span>
      </div>
      <div class=\"d-none d-md-flex gap-2 align-items-center\">
        <img src=\"";
        // line 24
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/location.svg\" height=\"18\" width=\"18\" alt=\"location\" class=\"object-fit-contain\">
        <span class=\"text-primary-paragraph fs-14\" id=\"location\"></span>
      </div>
    </div>

    <!-- Desktop actions -->
    <div class=\"d-flex gap-2\">
      <button class=\"control-btn btn accessibility-tool\" data-action=\"toggle-visibility\" title=\"";
        // line 31
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Toggle visibility"));
        yield "\">
        <img src=\"";
        // line 32
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/eye.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("eye"));
        yield "\">
      </button>
      <button class=\"control-btn btn accessibility-tool\" data-action=\"zoom-in\" title=\"";
        // line 34
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Zoom in"));
        yield "\">
        <img src=\"";
        // line 35
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/zoom_in.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("zoom in"));
        yield "\">
      </button>
      <button class=\"control-btn btn accessibility-tool\" data-action=\"zoom-out\" title=\"";
        // line 37
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Zoom out"));
        yield "\">
        <img src=\"";
        // line 38
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/zoom_out.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("zoom out"));
        yield "\">
      </button>
      <button class=\"control-btn btn accessibility-tool\" data-action=\"text-to-speech\" title=\"";
        // line 40
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Voice input"));
        yield "\">
        <img src=\"";
        // line 41
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/mic.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("mic"));
        yield "\">
      </button>
    </div>
  </div>
</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["base_path", "directory"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "@ncim_theme/includes/control-bar.html.twig";
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
        return array (  125 => 41,  121 => 40,  114 => 38,  110 => 37,  103 => 35,  99 => 34,  92 => 32,  88 => 31,  78 => 24,  72 => 21,  68 => 20,  62 => 17,  58 => 16,  51 => 12,  44 => 7,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "@ncim_theme/includes/control-bar.html.twig", "/var/www/html/web/themes/custom/ncim_theme/templates/includes/control-bar.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = [];
        static $filters = ["escape" => 12, "date" => 17, "t" => 31];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                [],
                ['escape', 'date', 't'],
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
