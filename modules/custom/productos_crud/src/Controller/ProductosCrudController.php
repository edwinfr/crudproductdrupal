<?php

namespace Drupal\productos_crud\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Controller para listar, buscar y borrar productos.
 */
class ProductosCrudController extends ControllerBase {

  /**
   * Get the database connection.
   */
  protected function database() {
    return \Drupal::database();
  }

  /**
   * Listado con búsqueda y renderizado del listado HTML.
   */
  public function list() {
    $query = $this->database()->select('productos_crud', 'p')
      ->fields('p', ['id', 'nombre', 'codigo', 'categoria', 'costo', 'precio', 'stock', 'descripcion']);

    $search = trim((string) \Drupal::request()->query->get('search', ''));
    if ($search !== '') {
      $or = $query->orConditionGroup();
      $or->condition('p.nombre', '%' . $search . '%', 'LIKE')
        ->condition('p.codigo', '%' . $search . '%', 'LIKE')
        ->condition('p.categoria', '%' . $search . '%', 'LIKE');
      $query->condition($or);
    }

    $results = $query->orderBy('p.id', 'DESC')->execute()->fetchAll();

    return [
      '#theme' => 'productos_list',
      '#items' => $results,
      '#filter' => $search,
      '#attached' => [
        'library' => ['productos_crud/productos_crud'],
      ],
    ];
  }

  /**
   * Search AJAX endpoint.
   */
  public function search(Request $request) {
    $search = trim((string) $request->query->get('search', ''));
    $query = $this->database()->select('productos_crud', 'p')
      ->fields('p', ['id', 'nombre', 'codigo', 'categoria', 'costo', 'precio', 'stock', 'descripcion']);

    if ($search !== '') {
      $or = $query->orConditionGroup();
      $or->condition('p.nombre', '%' . $search . '%', 'LIKE')
        ->condition('p.codigo', '%' . $search . '%', 'LIKE')
        ->condition('p.categoria', '%' . $search . '%', 'LIKE');
      $query->condition($or);
    }

    $results = $query->orderBy('p.id', 'DESC')->execute()->fetchAll();

    return new JsonResponse([
      'items' => array_map(function ($item) {
        return [
          'id' => (int) $item->id,
          'nombre' => $item->nombre,
          'codigo' => $item->codigo,
          'categoria' => $item->categoria,
          'costo' => (float) $item->costo,
          'precio' => (float) $item->precio,
          'stock' => (int) $item->stock,
          'edit' => Url::fromRoute('productos_crud.edit', ['id' => $item->id])->toString(),
          'delete' => Url::fromRoute('productos_crud.delete', ['id' => $item->id])->toString(),
        ];
      }, $results),
    ]);
  }

  /**
   * Delete product.
   */
  public function delete($id) {
    $this->database()->delete('productos_crud')->condition('id', $id)->execute();
    $this->messenger()->addStatus($this->t('Producto eliminado correctamente.'));
    return new RedirectResponse(Url::fromRoute('productos_crud.list')->toString());
  }

}
