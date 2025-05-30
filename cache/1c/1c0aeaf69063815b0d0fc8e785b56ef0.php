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

/* header.html.twig */
class __TwigTemplate_627d58ada9326513569b656585608512 extends Template
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
        yield "<header class=\"bg-[#0F172A] text-white shadow-lg sticky top-0 z-50\">
\t<div class=\"container mx-auto flex items-center justify-between py-4 px-6\">
\t\t<a href=\"#\" class=\"flex items-center space-x-2\">
\t\t\t<span class=\"text-xl font-semibold\">MyWatchGuide</span>
\t\t</a>
\t\t<nav class=\"hidden md:flex space-x-8 items-center\">
\t\t\t<a href=\"#\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Populaire</a>
\t\t\t<a href=\"#\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Rechercher</a>
\t\t\t<a href=\"#\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Films</a>
\t\t\t<a href=\"#\" class=\"hover:text-gray-300 transition duration-300 text-sm font-medium\">Séries</a>
\t\t</nav>
\t\t<a href=\"#\" class=\"hidden md:inline-flex items-center text-sm font-medium text-gray-300 hover:text-white transition duration-300\">
\t\t\tConnexion
\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-4 w-4 ml-1\" fill=\"none\" viewbox=\"0 0 24 24\" stroke=\"currentColor\">
\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M5 12h14m-7-7l7 7-7 7\"/>
\t\t\t</svg>
\t\t</a>
\t\t<button class=\"md:hidden text-gray-300 focus:outline-none hover:text-white transition duration-300\" id=\"menu-toggle\">
\t\t\t<svg xmlns=\"http://www.w3.org/2000/svg\" class=\"h-6 w-6\" fill=\"none\" viewbox=\"0 0 24 24\" stroke=\"currentColor\">
\t\t\t\t<path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 6h16M4 12h16M4 18h16\"/>
\t\t\t</svg>
\t\t</button>
\t</div>
</header>
<script>
\t// Toggle menu visibility for small screens
document.getElementById('menu-toggle').addEventListener('click', () => {
const menu = document.getElementById('menu');
menu.classList.toggle('hidden');
menu.classList.toggle('flex');
});
</script>
";
        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "header.html.twig";
    }

    /**
     * @codeCoverageIgnore
     */
    public function getDebugInfo(): array
    {
        return array (  42 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "header.html.twig", "C:\\Projects\\mywatchguide\\templates\\header.html.twig");
    }
}
