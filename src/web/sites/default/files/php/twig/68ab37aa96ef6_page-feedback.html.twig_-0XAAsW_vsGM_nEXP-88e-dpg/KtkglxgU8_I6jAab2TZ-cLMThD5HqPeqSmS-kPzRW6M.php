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

/* themes/custom/ncim_theme/templates/blocks/page-feedback.html.twig */
class __TwigTemplate_0bd55d20318f06c78af8a8c11195c86f extends Template
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
        // line 2
        yield "
<section>  
  <form class=\"outer-container py-sm-3\" id=\"feedbackForm\" novalidate>
    <div class=\"d-flex justify-content-between align-items-center gap-3 flex-wrap\">
      <div class=\"text-default d-flex gap-3 align-items-center\">
        <span>";
        // line 7
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_feedback_question", [], "any", false, false, true, 7), "value", [], "any", false, false, true, 7), "html", null, true);
        yield "</span>
        <div class=\"d-flex gap-3\">
          <button type=\"button\" id=\"positiveFeedbackBtn\" class=\"btn btn-primary\">
            ";
        // line 10
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_positive_button_text", [], "any", false, false, true, 10), "value", [], "any", false, false, true, 10), "html", null, true);
        yield "
          </button>
          <button type=\"button\" id=\"negativeFeedbackBtn\" class=\"btn btn-background-neutral-default px-3\">
            ";
        // line 13
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_negative_button_text", [], "any", false, false, true, 13), "value", [], "any", false, false, true, 13), "html", null, true);
        yield "
          </button>
        </div>
      </div>

      <div>
        <div id=\"positiveFeedback\" class=\"fs-14 text-default d-block\">
          ";
        // line 20
        if ((CoreExtension::getAttribute($this->env, $this->source, ($context["statistics"] ?? null), "total_submissions", [], "any", false, false, true, 20) > 0)) {
            // line 21
            yield "            ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["statistics"] ?? null), "positive_percentage", [], "any", false, false, true, 21), "html", null, true);
            yield "% ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("من المستخدمين قالوا نعم من"));
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, ($context["statistics"] ?? null), "total_submissions", [], "any", false, false, true, 21), "html", null, true);
            yield " ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("تعليقًا"));
            yield "
          ";
        } else {
            // line 23
            yield "            ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar(t("لا توجد تعليقات بعد"));
            yield "
          ";
        }
        // line 25
        yield "        </div>

        <button type=\"button\" id=\"closeFeedbackBtn\" class=\"btn d-flex gap-2 align-items-center d-none\">
          ";
        // line 28
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_close_button_text", [], "any", false, false, true, 28), "value", [], "any", false, false, true, 28), "html", null, true);
        yield "
          <i class=\"fa-regular fa-circle-xmark\"></i>
        </button>
      </div>
    </div>

    <div class=\"collapse\" id=\"feedback\">
      <div class=\"mt-4\">
        <div class=\"row row-cols-lg-2\">
          <div>
            <div class=\"text-secondary-paragraph mb-3\">
              <span class=\"fw-600 text-default\">";
        // line 39
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_reason_question_text", [], "any", false, false, true, 39), "value", [], "any", false, false, true, 39), "html", null, true);
        yield "</span>
            </div>

            <div class=\"invalid-feedback mb-3\">";
        // line 42
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_invalid_feedback_message", [], "any", false, false, true, 42), "value", [], "any", false, false, true, 42), "html", null, true);
        yield "</div>
            
            ";
        // line 45
        yield "            ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_feedback_reasons", [], "any", false, false, true, 45)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 46
            yield "              ";
            $context['_parent'] = $context;
            $context['_seq'] = CoreExtension::ensureTraversable(CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_feedback_reasons", [], "any", false, false, true, 46));
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
            foreach ($context['_seq'] as $context["_key"] => $context["reason"]) {
                // line 47
                yield "                ";
                if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, $context["reason"], "value", [], "any", false, false, true, 47)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
                    // line 48
                    yield "                  <div class=\"mb-3 form-check\">
                    <input type=\"checkbox\" class=\"form-check-input reason-checkbox\" 
                           id=\"check";
                    // line 50
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 50), "html", null, true);
                    yield "\" name=\"reason\" value=\"";
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["reason"], "value", [], "any", false, false, true, 50), "html", null, true);
                    yield "\" />
                    <label class=\"form-check-label\" for=\"check";
                    // line 51
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["loop"], "index", [], "any", false, false, true, 51), "html", null, true);
                    yield "\">
                      ";
                    // line 52
                    yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["reason"], "value", [], "any", false, false, true, 52), "html", null, true);
                    yield "
                    </label>
                  </div>
                ";
                }
                // line 56
                yield "              ";
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
            unset($context['_seq'], $context['_key'], $context['reason'], $context['_parent'], $context['loop']);
            $context = array_intersect_key($context, $_parent) + $_parent;
            // line 57
            yield "            ";
        }
        // line 58
        yield "            
            <div class=\"invalid-feedback mb-3\">";
        // line 59
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_invalid_gender_message", [], "any", false, false, true, 59), "value", [], "any", false, false, true, 59), "html", null, true);
        yield "</div>

            ";
        // line 62
        yield "            <div class=\"d-flex align-items-baseline\">
              ";
        // line 63
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_gender_question_text", [], "any", false, false, true, 63), "value", [], "any", false, false, true, 63), "html", null, true);
        yield "
              <div class=\"mb-3 ms-2\">
                <div class=\"mb-3\">
                  <div class=\"form-check form-check-inline\">
                    <input class=\"form-check-input\" type=\"radio\" id=\"radio1\" name=\"gender\" value=\"male\" required />
                    <label class=\"form-check-label\" for=\"radio1\">
                      ";
        // line 69
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_male_option_text", [], "any", false, false, true, 69), "value", [], "any", false, false, true, 69), "html", null, true);
        yield "
                    </label>
                  </div>
                  <div class=\"form-check form-check-inline\">
                    <input class=\"form-check-input\" type=\"radio\" id=\"radio2\" name=\"gender\" value=\"female\" required />
                    <label class=\"form-check-label\" for=\"radio2\">
                      ";
        // line 75
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_female_option_text", [], "any", false, false, true, 75), "value", [], "any", false, false, true, 75), "html", null, true);
        yield "
                    </label>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div>
            <div class=\"mb-3\">
              <label for=\"comment\" class=\"form-label\">";
        // line 85
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_comment_label", [], "any", false, false, true, 85), "value", [], "any", false, false, true, 85), "html", null, true);
        yield "</label>
              <textarea class=\"form-control\" name=\"comment\" id=\"comment\" rows=\"3\" 
                        placeholder=\"";
        // line 87
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_comment_placeholder", [], "any", false, false, true, 87), "value", [], "any", false, false, true, 87), "html", null, true);
        yield "\" 
                        maxlength=\"";
        // line 88
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_comment_max_length_text", [], "any", false, false, true, 88), "value", [], "any", false, false, true, 88), "html", null, true);
        yield "\"></textarea>
              <div class=\"form-text\">الحد الأقصى ";
        // line 89
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_comment_max_length_text", [], "any", false, false, true, 89), "value", [], "any", false, false, true, 89), "html", null, true);
        yield " حرف</div>
            </div>
          </div>
        </div>

        <div class=\"d-flex justify-content-between gap-3 flex-wrap\">
          <div>
            ";
        // line 96
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_additional_info_text", [], "any", false, false, true, 96), "value", [], "any", false, false, true, 96), "html", null, true);
        yield "
            ";
        // line 97
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_participation_statement_li", [], "any", false, false, true, 97), 0, [], "any", false, false, true, 97), "url", [], "any", false, false, true, 97)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 98
            yield "              <a href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_participation_statement_li", [], "any", false, false, true, 98), 0, [], "any", false, false, true, 98), "url", [], "any", false, false, true, 98), "html", null, true);
            yield "\" class=\"text-primary\">
                ";
            // line 99
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_participation_statement_te", [], "any", false, false, true, 99), "value", [], "any", false, false, true, 99), "html", null, true);
            yield "
              </a>
            ";
        }
        // line 102
        yield "            ";
        if ((($tmp = CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_subscription_rules_link", [], "any", false, false, true, 102), 0, [], "any", false, false, true, 102), "url", [], "any", false, false, true, 102)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 103
            yield "              و <a href=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_subscription_rules_link", [], "any", false, false, true, 103), 0, [], "any", false, false, true, 103), "url", [], "any", false, false, true, 103), "html", null, true);
            yield "\" class=\"text-primary\">
                ";
            // line 104
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_subscription_rules_text", [], "any", false, false, true, 104), "value", [], "any", false, false, true, 104), "html", null, true);
            yield "
              </a>
            ";
        }
        // line 107
        yield "          </div>
          <div>
            <button type=\"submit\" class=\"btn btn-primary\">
              ";
        // line 110
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, CoreExtension::getAttribute($this->env, $this->source, ($context["content"] ?? null), "field_submit_button_text", [], "any", false, false, true, 110), "value", [], "any", false, false, true, 110), "html", null, true);
        yield "
            </button>
          </div>
        </div>
      </div>
    </div>
  </form>
</section>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["content", "statistics", "loop"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "themes/custom/ncim_theme/templates/blocks/page-feedback.html.twig";
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
        return array (  286 => 110,  281 => 107,  275 => 104,  270 => 103,  267 => 102,  261 => 99,  256 => 98,  254 => 97,  250 => 96,  240 => 89,  236 => 88,  232 => 87,  227 => 85,  214 => 75,  205 => 69,  196 => 63,  193 => 62,  188 => 59,  185 => 58,  182 => 57,  168 => 56,  161 => 52,  157 => 51,  151 => 50,  147 => 48,  144 => 47,  126 => 46,  123 => 45,  118 => 42,  112 => 39,  98 => 28,  93 => 25,  87 => 23,  75 => 21,  73 => 20,  63 => 13,  57 => 10,  51 => 7,  44 => 2,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "themes/custom/ncim_theme/templates/blocks/page-feedback.html.twig", "/var/www/html/web/themes/custom/ncim_theme/templates/blocks/page-feedback.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["if" => 20, "for" => 46];
        static $filters = ["escape" => 7, "t" => 21];
        static $functions = [];

        try {
            $this->sandbox->checkSecurity(
                ['if', 'for'],
                ['escape', 't'],
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
