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

/* themes/custom/ncim_theme/templates/blocks/faq-content.html.twig */
class __TwigTemplate_d0c8f74ed1cd8e37603b5656b25aa8dc extends Template
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
        // line 13
        yield "
<section class=\"py-6\">
  <div class=\"outer-container\">
    <!-- Search and Filter Form -->
    <form class=\"d-flex align-items-center gap-3 mb-6\" id=\"faqSearchForm\">
      <div class=\"input-group w-fit isearch-input-groupn border border-field-border-default rounded-3\">
        <button class=\"btn border-0\" type=\"button\">
          <img src=\"/";
        // line 20
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["directory"] ?? null), "html", null, true);
        yield "/images/icons/search.svg\" alt=\"\" srcset=\"\">
        </button>
        <input type=\"text\" 
               class=\"form-control border-0\" 
               id=\"faqSearchInput\"
               placeholder=\"";
        // line 25
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("بحث"));
        yield "\" 
               aria-label=\"";
        // line 26
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("Example text with button addon"));
        yield "\" 
               aria-describedby=\"button-addon1\">
        <button class=\"btn border-0\" type=\"button\" id=\"voiceSearchBtn\">
          <img src=\"/";
        // line 29
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["directory"] ?? null), "html", null, true);
        yield "/images/icons/speech.svg\" alt=\"\" srcset=\"\">
        </button>
      </div>

      <button type=\"button\" class=\"btn btn-default d-flex align-items-center gap-2\" id=\"filterBtn\">
        <img src=\"/";
        // line 34
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["directory"] ?? null), "html", null, true);
        yield "/images/icons/filter.svg\" alt=\"\" srcset=\"\">
        ";
        // line 35
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ترتيب"));
        yield "
        <i class=\"fa-light fa-angle-down\"></i>
      </button>
    </form>

    <!-- Sort Dropdown (Hidden by default) -->
    <div class=\"filter-dropdown mb-4 d-none\" id=\"filterDropdown\">
      <div class=\"card p-3\">
        <h6 class=\"mb-3\">";
        // line 43
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ترتيب الأسئلة"));
        yield "</h6>
        <div class=\"d-flex flex-wrap gap-2\">
          <button type=\"button\" class=\"btn btn-outline-primary btn-sm filter-category\" data-category=\"newest\">
            ";
        // line 46
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("الأحدث أولاً"));
        yield "
          </button>
          <button type=\"button\" class=\"btn btn-outline-primary btn-sm filter-category\" data-category=\"oldest\">
            ";
        // line 49
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("الأقدم أولاً"));
        yield "
          </button>
          <button type=\"button\" class=\"btn btn-outline-primary btn-sm filter-category\" data-category=\"alphabetical\">
            ";
        // line 52
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ترتيب أبجدي"));
        yield "
          </button>
          <button type=\"button\" class=\"btn btn-outline-primary btn-sm filter-category\" data-category=\"reverse-alphabetical\">
            ";
        // line 55
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ترتيب أبجدي عكسي"));
        yield "
          </button>
          <button type=\"button\" class=\"btn btn-outline-primary btn-sm filter-category\" data-category=\"category\">
            ";
        // line 58
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("ترتيب حسب الفئة"));
        yield "
          </button>
        </div>
      </div>
    </div>

    <!-- Nav Tabs -->
    <ul class=\"nav nav-tabs faq-tabs\" id=\"faqTabs\" role=\"tablist\">
      ";
        // line 66
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "categories", [], "any", false, false, true, 66));
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
        foreach ($context['_seq'] as $context["key"] => $context["category"]) {
            // line 67
            yield "        <li class=\"nav-item\" role=\"presentation\">
          <button class=\"nav-link";
            // line 68
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 68)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield " active";
            }
            yield "\" 
                  id=\"";
            // line 69
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
            yield "-tab\" 
                  data-bs-toggle=\"tab\" 
                  data-bs-target=\"#";
            // line 71
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
            yield "\" 
                  type=\"button\" 
                  role=\"tab\" 
                  aria-controls=\"";
            // line 74
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
            yield "\" 
                  aria-selected=\"";
            // line 75
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 75)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield "true";
            } else {
                yield "false";
            }
            yield "\">
            ";
            // line 76
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["category"], "html", null, true);
            yield "
          </button>
        </li>
      ";
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
        unset($context['_seq'], $context['key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 80
        yield "    </ul>

    <!-- Tab Content -->
    <div class=\"tab-content pt-3 px-md-3\" id=\"faqTabsContent\">
      ";
        // line 84
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "categories", [], "any", false, false, true, 84));
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
        foreach ($context['_seq'] as $context["key"] => $context["category"]) {
            // line 85
            yield "        <div class=\"tab-pane fade";
            if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 85)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                yield " show active";
            }
            yield "\" 
             id=\"";
            // line 86
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
            yield "\" 
             role=\"tabpanel\" 
             aria-labelledby=\"";
            // line 88
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
            yield "-tab\">
          
          ";
            // line 90
            if (($context["key"] == "all")) {
                // line 91
                yield "            <!-- All FAQs Accordion -->
            <div class=\"accordion accordion-flush\" id=\"faqAccordion\">
              ";
                // line 93
                $context['_parent'] = $context;
                $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "faq_items", [], "any", false, false, true, 93));
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
                    // line 94
                    yield "                <div class=\"accordion-item faq-item\" 
                     data-id=\"";
                    // line 95
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 95), "html", null, true);
                    yield "\"
                     data-question=\"";
                    // line 96
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "question", [], "any", false, false, true, 96)), "html", null, true);
                    yield "\" 
                     data-answer=\"";
                    // line 97
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "answer", [], "any", false, false, true, 97)), "html", null, true);
                    yield "\" 
                     data-keywords=\"";
                    // line 98
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "search_keywords", [], "any", false, false, true, 98)), "html", null, true);
                    yield "\" 
                     data-category=\"";
                    // line 99
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "category", [], "any", false, false, true, 99), "html", null, true);
                    yield "\">
                  <h2 class=\"accordion-header\" id=\"heading";
                    // line 100
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 100), "html", null, true);
                    yield "\">
                    <button class=\"accordion-button";
                    // line 101
                    if ((($tmp =  !CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 101)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " collapsed";
                    }
                    yield "\" 
                            type=\"button\" 
                            data-bs-toggle=\"collapse\" 
                            data-bs-target=\"#collapse";
                    // line 104
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 104), "html", null, true);
                    yield "\" 
                            aria-expanded=\"";
                    // line 105
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 105)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield "true";
                    } else {
                        yield "false";
                    }
                    yield "\" 
                            aria-controls=\"collapse";
                    // line 106
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 106), "html", null, true);
                    yield "\">
                      ";
                    // line 107
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "question", [], "any", false, false, true, 107), "html", null, true);
                    yield "
                    </button>
                  </h2>
                  <div id=\"collapse";
                    // line 110
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 110), "html", null, true);
                    yield "\" 
                       class=\"accordion-collapse collapse";
                    // line 111
                    if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "first", [], "any", false, false, true, 111)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                        yield " show";
                    }
                    yield "\" 
                       aria-labelledby=\"heading";
                    // line 112
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 112), "html", null, true);
                    yield "\" 
                       data-bs-parent=\"#faqAccordion\">
                    <div class=\"accordion-body\">
                      ";
                    // line 115
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "answer", [], "any", false, false, true, 115));
                    yield "
                    </div>
                  </div>
                </div>
              ";
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
                // line 120
                yield "            </div>
          ";
            } else {
                // line 122
                yield "            <!-- Category-specific FAQs -->
            <div class=\"accordion accordion-flush\" id=\"faqAccordion";
                // line 123
                yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), $context["key"]), "html", null, true);
                yield "\">
              ";
                // line 124
                $context["category_items"] = Twig\Extension\CoreExtension::filter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "faq_items", [], "any", false, false, true, 124), function ($__item__) use ($context, $macros) { $context["item"] = $__item__; return (CoreExtension::getAttribute($this->env, $this->source, ($context["item"] ?? null), "category", [], "any", false, false, true, 124) == $context["key"]); });
                // line 125
                yield "              ";
                if ((($tmp = ($context["category_items"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 126
                    yield "                ";
                    $context['_parent'] = $context;
                    $context['_seq'] = CoreExtension::ensureTraversable(($context["category_items"] ?? null));
                    foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
                        // line 127
                        yield "                  <div class=\"accordion-item faq-item\" 
                       data-id=\"";
                        // line 128
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 128), "html", null, true);
                        yield "\"
                       data-question=\"";
                        // line 129
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "question", [], "any", false, false, true, 129)), "html", null, true);
                        yield "\" 
                       data-answer=\"";
                        // line 130
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "answer", [], "any", false, false, true, 130)), "html", null, true);
                        yield "\" 
                       data-keywords=\"";
                        // line 131
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "search_keywords", [], "any", false, false, true, 131)), "html", null, true);
                        yield "\" 
                       data-category=\"";
                        // line 132
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "category", [], "any", false, false, true, 132), "html", null, true);
                        yield "\">
                    <h2 class=\"accordion-header\" id=\"heading";
                        // line 133
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 133), "html", null, true);
                        yield "\">
                      <button class=\"accordion-button collapsed\" 
                              type=\"button\" 
                              data-bs-toggle=\"collapse\" 
                              data-bs-target=\"#collapse";
                        // line 137
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 137), "html", null, true);
                        yield "\" 
                              aria-expanded=\"false\" 
                              aria-controls=\"collapse";
                        // line 139
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 139), "html", null, true);
                        yield "\">
                        ";
                        // line 140
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "question", [], "any", false, false, true, 140), "html", null, true);
                        yield "
                      </button>
                    </h2>
                    <div id=\"collapse";
                        // line 143
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 143), "html", null, true);
                        yield "\" 
                         class=\"accordion-collapse collapse\" 
                         aria-labelledby=\"heading";
                        // line 145
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $context["key"], "html", null, true);
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 145), "html", null, true);
                        yield "\" 
                         data-bs-parent=\"#faqAccordion";
                        // line 146
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::capitalize($this->env->getCharset(), $context["key"]), "html", null, true);
                        yield "\">
                      <div class=\"accordion-body\">
                        ";
                        // line 148
                        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(CoreExtension::getAttribute($this->env, $this->source, $context["item"], "answer", [], "any", false, false, true, 148));
                        yield "
                      </div>
                    </div>
                  </div>
                ";
                    }
                    $_parent = $context['_parent'];
                    unset($context['_seq'], $context['_key'], $context['item'], $context['_parent']);
                    $context = array_intersect_key($context, $_parent) + $_parent;
                    // line 153
                    yield "              ";
                } else {
                    // line 154
                    yield "                <p>";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("لا توجد أسئلة في هذه الفئة حالياً."));
                    yield "</p>
              ";
                }
                // line 156
                yield "            </div>
          ";
            }
            // line 158
            yield "        </div>
      ";
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
        unset($context['_seq'], $context['key'], $context['category'], $context['_parent'], $context['loop']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 160
        yield "    </div>
  </div>
</section>

<!-- Contact Section -->
<section class=\"py-4\">
  <div class=\"outer-container\">
    <div class=\"card rounded-4 border-neutral-primary h-100\">
      <div class=\"card-body\">
        <div class=\"circle-icon-sm bg-background-brand-light mb-4\">
          <img src=\"/";
        // line 170
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["directory"] ?? null), "html", null, true);
        yield "/images/icons/mail.svg\" alt=\"";
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("question"));
        yield "\">
        </div>

        <h5 class=\"fs-18 fw-700\">
          ";
        // line 174
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("التعليقات والاقتراحات"));
        yield "
        </h5>
        <p class=\"mb-4\">";
        // line 176
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("لأي استفسار أو ملاحظات حول الخدمات الحكومية، يرجى ملء المعلومات المطلوبة."));
        yield "</p>

        <a class=\"btn btn-primary\" href=\"/contact-us.html\" role=\"button\">
          ";
        // line 179
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("تواصل معنا"));
        yield "
        </a>
      </div>
    </div>
  </div>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["directory", "content", "loop"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ncim_theme/templates/blocks/faq-content.html.twig";
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
        return array (  513 => 179,  507 => 176,  502 => 174,  493 => 170,  481 => 160,  466 => 158,  462 => 156,  456 => 154,  453 => 153,  442 => 148,  437 => 146,  432 => 145,  426 => 143,  420 => 140,  415 => 139,  409 => 137,  401 => 133,  397 => 132,  393 => 131,  389 => 130,  385 => 129,  381 => 128,  378 => 127,  373 => 126,  370 => 125,  368 => 124,  364 => 123,  361 => 122,  357 => 120,  338 => 115,  332 => 112,  326 => 111,  322 => 110,  316 => 107,  312 => 106,  304 => 105,  300 => 104,  292 => 101,  288 => 100,  284 => 99,  280 => 98,  276 => 97,  272 => 96,  268 => 95,  265 => 94,  248 => 93,  244 => 91,  242 => 90,  237 => 88,  232 => 86,  225 => 85,  208 => 84,  202 => 80,  184 => 76,  176 => 75,  172 => 74,  166 => 71,  161 => 69,  155 => 68,  152 => 67,  135 => 66,  124 => 58,  118 => 55,  112 => 52,  106 => 49,  100 => 46,  94 => 43,  83 => 35,  79 => 34,  71 => 29,  65 => 26,  61 => 25,  53 => 20,  44 => 13,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ncim_theme/templates/blocks/faq-content.html.twig", "/var/www/html/web/themes/custom/ncim_theme/templates/blocks/faq-content.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 66, "if" => 68, "set" => 124];
        static $filters = ["escape" => 20, "t" => 25, "lower" => 96, "raw" => 115, "capitalize" => 123, "filter" => 124];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if', 'set'],
                ['escape', 't', 'lower', 'raw', 'capitalize', 'filter'],
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
