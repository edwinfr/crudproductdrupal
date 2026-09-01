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

/* modules/custom/productos_crud/templates/productos-list.html.twig */
class __TwigTemplate_bdd328648492f9caff896aba374a3f04 extends Template
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
        // line 1
        yield "<div class=\"productos-crud-wrapper\">
  <div class=\"row mb-3\">
    <div class=\"col-md-8\">
      <form method=\"get\" action=\"";
        // line 4
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("productos_crud.list"));
        yield "\" class=\"productos-crud-search-form d-flex gap-2 align-items-center\">
        <input type=\"text\" name=\"search\" class=\"form-control\" value=\"";
        // line 5
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["filter"] ?? null), "html", null, true);
        yield "\" placeholder=\"Buscar producto...\" />
        <button type=\"submit\" class=\"btn btn-primary\">Buscar</button>
        <a href=\"";
        // line 7
        yield $this->extensions['Drupal\Core\Template\TwigExtension']->renderVar($this->extensions['Drupal\Core\Template\TwigExtension']->getPath("productos_crud.add"));
        yield "\" class=\"btn btn-success\">Agregar</a>
      </form>
    </div>
  </div>

  <div class=\"table-responsive\">
    <table class=\"table table-striped table-bordered\" data-page-size=\"5\">
      <thead>
        <tr>
          <th>ID</th>
          <th>Nombre</th>
          <th>Código</th>
          <th>Categoría</th>
          <th>Costo</th>
          <th>Precio</th>
          <th>Stock</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody class=\"productos-crud-body\">
        ";
        // line 27
        $context['_parent'] = $context;
        $context['_seq'] = CoreExtension::ensureTraversable(($context["items"] ?? null));
        $context['_iterated'] = false;
        foreach ($context['_seq'] as $context["_key"] => $context["item"]) {
            // line 28
            yield "          <tr data-name=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "nombre", [], "any", false, false, true, 28)), "html", null, true);
            yield "\" data-code=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "codigo", [], "any", false, false, true, 28)), "html", null, true);
            yield "\" data-category=\"";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, Twig\Extension\CoreExtension::lower($this->env->getCharset(), CoreExtension::getAttribute($this->env, $this->source, $context["item"], "categoria", [], "any", false, false, true, 28)), "html", null, true);
            yield "\">
            <td>";
            // line 29
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 29), "html", null, true);
            yield "</td>
            <td>";
            // line 30
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "nombre", [], "any", false, false, true, 30), "html", null, true);
            yield "</td>
            <td>";
            // line 31
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "codigo", [], "any", false, false, true, 31), "html", null, true);
            yield "</td>
            <td>";
            // line 32
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "categoria", [], "any", false, false, true, 32), "html", null, true);
            yield "</td>
            <td>\$";
            // line 33
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "costo", [], "any", false, false, true, 33), "html", null, true);
            yield "</td>
            <td>\$";
            // line 34
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "precio", [], "any", false, false, true, 34), "html", null, true);
            yield "</td>
            <td>";
            // line 35
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, CoreExtension::getAttribute($this->env, $this->source, $context["item"], "stock", [], "any", false, false, true, 35), "html", null, true);
            yield "</td>
            <td>
              <a href=\"";
            // line 37
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("productos_crud.edit", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 37)]), "html", null, true);
            yield "\" class=\"btn btn-sm btn-warning\">Editar</a>
              <a href=\"";
            // line 38
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, $this->extensions['Drupal\Core\Template\TwigExtension']->getPath("productos_crud.delete", ["id" => CoreExtension::getAttribute($this->env, $this->source, $context["item"], "id", [], "any", false, false, true, 38)]), "html", null, true);
            yield "\" class=\"btn btn-sm btn-danger\" onclick=\"return confirm('¿Eliminar producto?')\">Eliminar</a>
            </td>
          </tr>
        ";
            $context['_iterated'] = true;
        }
        // line 41
        if (!$context['_iterated']) {
            // line 42
            yield "          <tr class=\"productos-crud-empty-row\">
            <td colspan=\"8\">No hay productos registrados.</td>
          </tr>
        ";
        }
        $_parent = $context['_parent'];
        unset($context['_seq'], $context['_key'], $context['item'], $context['_parent'], $context['_iterated']);
        $context = array_intersect_key($context, $_parent) + $_parent;
        // line 46
        yield "      </tbody>
    </table>
  </div>

  <div class=\"productos-crud-pagination\" aria-label=\"Paginación de productos\"></div>

  ";
        // line 52
        if ((($tmp = ($context["pager"] ?? null)) && $tmp instanceof Markup ? (string) $tmp : $tmp)) {
            // line 53
            yield "    ";
            yield $this->extensions['Drupal\Core\Template\TwigExtension']->escapeFilter($this->env, ($context["pager"] ?? null), "html", null, true);
            yield "
  ";
        }
        // line 55
        yield "</div>
";
        $this->env->getExtension('\Drupal\Core\Template\TwigExtension')
            ->checkDeprecations($context, ["filter", "items", "pager"]);        yield from [];
    }

    /**
     * @codeCoverageIgnore
     */
    public function getTemplateName(): string
    {
        return "modules/custom/productos_crud/templates/productos-list.html.twig";
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
        return array (  163 => 55,  157 => 53,  155 => 52,  147 => 46,  138 => 42,  136 => 41,  128 => 38,  124 => 37,  119 => 35,  115 => 34,  111 => 33,  107 => 32,  103 => 31,  99 => 30,  95 => 29,  86 => 28,  81 => 27,  58 => 7,  53 => 5,  49 => 4,  44 => 1,);
    }

    public function getSourceContext(): Source
    {
        return new Source("", "modules/custom/productos_crud/templates/productos-list.html.twig", "/opt/lampp/htdocs/drupal10/modules/custom/productos_crud/templates/productos-list.html.twig");
    }
    
    public function checkSecurity()
    {
        static $tags = ["for" => 27, "if" => 52];
        static $filters = ["escape" => 5, "lower" => 28];
        static $functions = ["path" => 4];

        try {
            $this->sandbox->checkSecurity(
                ['for', 'if'],
                ['escape', 'lower'],
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
