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

/* themes/custom/ncim_theme/templates/navigation/menu--main.html.twig */
class __TwigTemplate_6a5ce91d1d1f0ed3fa23dd1ecc328cef extends Template
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
        // line 19
        yield "<nav class=\"navbar navbar-expand-xl navbar-light bg-white\">
  <div class=\"outer-container d-flex align-items-center\">
    <!-- Logo -->
    <a class=\"navbar-brand m-0\" href=\"";
        // line 22
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("<front>"));
        yield "\">
      <img src=\"/";
        // line 23
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/ncim.png\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("NCIM Logo"));
        yield "\" title=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("المركز الوطني لتفتيش والرقابة"));
        yield "\" style=\"height:auto; max-height:60px;\">
    </a>

    <!-- Toggler -->
    <button class=\"navbar-toggler ms-auto\" type=\"button\" data-bs-toggle=\"offcanvas\" data-bs-target=\"#offcanvasNavbar\" aria-controls=\"offcanvasNavbar\">
      <span class=\"navbar-toggler-icon\"></span>
    </button>

    <!-- Nav Links -->
    <div class=\"collapse navbar-collapse\" id=\"navbarSupportedContent\">
      <ul class=\"navbar-nav me-auto mb-2 mb-lg-0\">
        ";
        // line 34
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
        $context['loop'] = [
          'parent' => $context['_parent'],
          'index0' => 0,
          'index'  => 1,
          'first'  => true,
        ];
        if (is_array($context['_seq']) || (is_object($context['_seq']) && $context['_seq'] instanceof \Countable)) {
            $length = count($context['_seq']);
            $context['loop']['revindex0'] = $length - 1;
            $context['loop']['revindex'] = $length;
            $context['loop']['length'] = $length;
            $context['loop']['last'] = 1 === $length;
        }
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 35
            yield "          ";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 35)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                // line 36
                yield "            <!-- Dropdown/Mega Menu Item -->
            <li class=\"nav-item dropdown position-static\">
              <a class=\"nav-link gap-2\" href=\"";
                // line 38
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 38), "html", null, true);
                yield "\" id=\"navbarDropdown";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 38), "html", null, true);
                yield "\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                ";
                // line 39
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 39), "html", null, true);
                yield "
                <img src=\"/";
                // line 40
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
                yield "/images/icons/arrow_down.svg\">
              </a>
              <ul class=\"dropdown-menu w-100 bg-white mega-menu\" aria-labelledby=\"navbarDropdown";
                // line 42
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 42), "html", null, true);
                yield "\">
                <div class=\"outer-container\">
                  <div class=\"row g-4 row-cols-4\">
                    ";
                // line 45
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "below", [], "any", false, false, true, 45));
                foreach ($context['_seq'] as $context["_key"] => $context["child"]) {
                    // line 46
                    yield "                      <div>
                        <h6 class=\"fw-bold px-3 mb-2 text-primary\">";
                    // line 47
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["child"], "title", [], "any", false, false, true, 47), "html", null, true);
                    yield "</h6>
                        ";
                    // line 48
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["child"], "below", [], "any", false, false, true, 48)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        // line 49
                        yield "                          ";
                        $context['_parent'] = $context;
                        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, $context["child"], "below", [], "any", false, false, true, 49));
                        foreach ($context['_seq'] as $context["_key"] => $context["grandchild"]) {
                            // line 50
                            yield "                            <a class=\"dropdown-item d-flex gap-3 align-items-center\" href=\"";
                            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["grandchild"], "url", [], "any", false, false, true, 50), "html", null, true);
                            yield "\">
                              ";
                            // line 51
                            if (CoreExtension::getAttribute($this->env, $this->source, $context["grandchild"], "icon", [], "any", true, true, true, 51)) {
                                // line 52
                                yield "                                <img src=\"/";
                                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
                                yield "/images/icons/";
                                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["grandchild"], "icon", [], "any", false, false, true, 52), "html", null, true);
                                yield "\">
                              ";
                            } elseif (CoreExtension::getAttribute($this->env, $this->source,                             // line 53
$context["grandchild"], "description", [], "any", true, true, true, 53)) {
                                // line 54
                                yield "                                <img src=\"/";
                                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
                                yield "/images/icons/";
                                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["grandchild"], "description", [], "any", false, false, true, 54), "html", null, true);
                                yield "\">
                              ";
                            } else {
                                // line 56
                                yield "                                <img src=\"/";
                                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
                                yield "/images/icons/check.svg\">
                              ";
                            }
                            // line 58
                            yield "                              <span>";
                            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["grandchild"], "title", [], "any", false, false, true, 58), "html", null, true);
                            yield "</span>
                            </a>
                          ";
                        }
                        $_parent = $context['_parent'];
                        unset($context['_seq'], $context['_key'], $context['grandchild'], $context['_parent']);
                        $context = array_intersect_key($context, $_parent) + $_parent;
                        // line 61
                        yield "                        ";
                    }
                    // line 62
                    yield "                      </div>
                    ";
                }
                $_parent = $context['_parent'];
                unset($context['_seq'], $context['_key'], $context['child'], $context['_parent']);
                $context = array_intersect_key($context, $_parent) + $_parent;
                // line 64
                yield "                  </div>
                </div>
              </ul>
            </li>
          ";
            } else {
                // line 69
                yield "            <!-- Regular Menu Item -->
            <li class=\"nav-item\">
              <a class=\"nav-link";
                // line 71
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["item"], "in_active_trail", [], "any", false, false, true, 71)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    yield " active";
                }
                yield "\" href=\"";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "url", [], "any", false, false, true, 71), "html", null, true);
                yield "\">";
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "title", [], "any", false, false, true, 71), "html", null, true);
                yield "</a>
            </li>
          ";
            }
            // line 74
            yield "        ";
            ++$context['loop']['index0'];
            ++$context['loop']['index'];
            $context['loop']['first'] = false;
            if (isset($context['loop']['revindex0'], $context['loop']['revindex'])) {
                --$context['loop']['revindex0'];
                --$context['loop']['revindex'];
                $context['loop']['last'] = 0 === $context['loop']['revindex0'];
            }
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 75
        yield "      </ul>

      <!-- Search Form -->
      <div class=\"d-flex navbar-nav gap-3\">
        <button class=\"btn border-0\" type=\"button\" title=\"";
        // line 79
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Search"));
        yield "\">
          <img src=\"/";
        // line 80
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, (($context["base_path"] ?? null) . ($context["directory"] ?? null)), "html", null, true);
        yield "/images/icons/search.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Search"));
        yield "\">
        </button>
        
        <!-- Language Switcher -->
        ";
        // line 84
        if ((array_key_exists("languages", $context) && (Twig\Extension\CoreExtension::length($this->env->getCharset(), ($context["languages"] ?? null)) >= 1))) {
            // line 85
            yield "        <div class=\"dropdown\">
          <a class=\"nav-link\" type=\"button\" id=\"dropdownMenuButton\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
            ";
            // line 87
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((array_key_exists("other_language_name", $context)) ? (Twig\Extension\CoreExtension::default(($context["other_language_name"] ?? null), t("English"))) : (t("English"))), "html", null, true);
            yield "
          </a>
          <ul class=\"dropdown-menu\" aria-labelledby=\"dropdownMenuButton\">
            ";
            // line 90
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(($context["languages"] ?? null));
            foreach ($context['_seq'] as $context["_key"] => $context["language"]) {
                // line 91
                yield "              ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["language"], "url", [], "any", false, false, true, 91)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 92
                    yield "                <li><a class=\"dropdown-item\" href=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language"], "url", [], "any", false, false, true, 92), "html", null, true);
                    yield "\">";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["language"], "name", [], "any", false, false, true, 92), "html", null, true);
                    yield "</a></li>
              ";
                }
                // line 94
                yield "            ";
            }
            $_parent = $context['_parent'];
            unset($context['_seq'], $context['_key'], $context['language'], $context['_parent']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 95
            yield "          </ul>
        </div>
        ";
        }
        // line 98
        yield "        
        <!-- User Account Links -->
        <div class=\"d-flex align-items-center\">
          ";
        // line 101
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "isAnonymous", [], "any", false, false, true, 101)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 102
            yield "            <!-- Not logged in - Show Login/Register -->
            <a href=\"";
            // line 103
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("user.login"));
            yield "\" class=\"btn btn-background-black-default me-2\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("تسجيل الدخول"));
            yield "</a>
          ";
        } else {
            // line 105
            yield "            <!-- Logged in - Show User Menu -->
            <div class=\"dropdown btn btn-background-black-default me-2\">
              <a class=\"nav-link dropdown-toggle text-light\" href=\"#\" id=\"userDropdown\" role=\"button\" data-bs-toggle=\"dropdown\" aria-expanded=\"false\">
                ";
            // line 108
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ((CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "displayname", [], "any", true, true, true, 108)) ? (Twig\Extension\CoreExtension::default(CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "displayname", [], "any", false, false, true, 108), CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "name", [], "any", false, false, true, 108), "value", [], "any", false, false, true, 108))) : (CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["user"] ?? null), "name", [], "any", false, false, true, 108), "value", [], "any", false, false, true, 108))), "html", null, true);
            yield "
              </a>
              <ul class=\"dropdown-menu\" aria-labelledby=\"userDropdown\">
                <li><a class=\"dropdown-item\" href=\"";
            // line 111
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("user.page"));
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("الملف الشخصي"));
            yield "</a></li>
                <li><a class=\"dropdown-item\" href=\"";
            // line 112
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("user.logout"));
            yield "\">";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("تسجيل الخروج"));
            yield "</a></li>
              </ul>
            </div>
          ";
        }
        // line 116
        yield "        </div>
      </div>
    </div>
  </div>
</nav>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["base_path", "directory", "items", "loop", "languages", "other_language_name", "user"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ncim_theme/templates/navigation/menu--main.html.twig";
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
        return array (  321 => 116,  312 => 112,  306 => 111,  300 => 108,  295 => 105,  288 => 103,  285 => 102,  283 => 101,  278 => 98,  273 => 95,  267 => 94,  259 => 92,  256 => 91,  252 => 90,  246 => 87,  242 => 85,  240 => 84,  231 => 80,  227 => 79,  221 => 75,  207 => 74,  195 => 71,  191 => 69,  184 => 64,  177 => 62,  174 => 61,  164 => 58,  158 => 56,  150 => 54,  148 => 53,  141 => 52,  139 => 51,  134 => 50,  129 => 49,  127 => 48,  123 => 47,  120 => 46,  116 => 45,  110 => 42,  105 => 40,  101 => 39,  95 => 38,  91 => 36,  88 => 35,  71 => 34,  53 => 23,  49 => 22,  44 => 19,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ncim_theme/templates/navigation/menu--main.html.twig", "/var/www/html/web/themes/custom/ncim_theme/templates/navigation/menu--main.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 34, "if" => 35];
        static $filters = ["escape" => 23, "t" => 23, "length" => 84, "default" => 87];
        static $functions = ["path" => 22];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 't', 'length', 'default'],
                ['path'],
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
