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

/* footer.html.twig */
class __TwigTemplate_a4e22ad887d39f601aced9746b523c32 extends Template
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
    }

    protected function doDisplay(array $context, array $blocks = []): iterable
    {
        $macros = $this->macros;
        // line 1
        yield "<footer class=\"bg-[#0F172A] text-gray-400 fixed bottom-0 w-full\">
\t<div class=\"container mx-auto py-8 px-4\">
\t\t<div class=\"flex flex-col md:flex-row justify-between items-center\">
\t\t\t<div class=\"text-center md:text-left mb-6 md:mb-0\">
\t\t\t\t<p class=\"text-xl font-semibold text-white\">MyWatchGuide</p>
\t\t\t\t<p class=\"text-sm\">Suivez ce que vous regardez !</p>
\t\t\t</div>
\t\t\t<nav class=\"flex space-x-8\">
\t\t\t\t<a href=\"/privacy\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Politique de confidentialité</a>
\t\t\t\t<a href=\"/terms\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Conditions d'utilisation</a>
\t\t\t\t<a href=\"/contact\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Contact</a>
\t\t\t</nav>
\t\t</div>
\t\t<div class=\"text-center mt-6 text-sm text-gray-400\">
\t\t\t&copy;
\t\t\t";
        // line 16
        yield $this->env->getRuntime('Twig\Runtime\EscaperRuntime')->escape($this->extensions['Twig\Extension\CoreExtension']->formatDate("now", "Y"), "html", null, true);
        yield "
\t\t\t<span class=\"text-white\">MyWatchGuide</span>. Tous droits réservés.
\t\t</div>
\t</div>
</footer>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "footer.html.twig";
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
        return array (  59 => 16,  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "footer.html.twig", "C:\\Projects\\mywatchguide\\templates\\footer.html.twig");
    }
}
