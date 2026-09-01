<?php

namespace Drupal\productos_crud\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;

/**
 * Formulario para crear y editar productos.
 */
class ProductoForm extends FormBase {

  /**
   * Get database connection.
   */
  protected function database() {
    return \Drupal::database();
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'productos_crud_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, $id = NULL) {
    $product = NULL;
    if ($id && is_numeric($id)) {
      $product = $this->database()->select('productos_crud', 'p')
        ->fields('p')
        ->condition('id', (int) $id)
        ->execute()
        ->fetchAssoc();
    }

    $form['#attributes']['class'][] = 'productos-crud-form';

    $form['nombre'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Nombre'),
      '#required' => TRUE,
      '#maxlength' => 255,
      '#default_value' => $product['nombre'] ?? '',
      '#placeholder' => $this->t('Ej. Laptop Dell'),
    ];

    $form['codigo'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Código'),
      '#required' => TRUE,
      '#maxlength' => 100,
      '#default_value' => $product['codigo'] ?? '',
      '#placeholder' => $this->t('Ej. LAP-001'),
    ];

    $form['categoria'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Categoría'),
      '#required' => TRUE,
      '#maxlength' => 150,
      '#default_value' => $product['categoria'] ?? '',
      '#placeholder' => $this->t('Ej. Electrónica'),
    ];

    $form['costo'] = [
      '#type' => 'number',
      '#title' => $this->t('Costo'),
      '#step' => '0.01',
      '#min' => 0,
      '#required' => TRUE,
      '#default_value' => $product['costo'] ?? 0,
    ];

    $form['precio'] = [
      '#type' => 'number',
      '#title' => $this->t('Precio'),
      '#step' => '0.01',
      '#min' => 0,
      '#required' => TRUE,
      '#default_value' => $product['precio'] ?? 0,
    ];

    $form['stock'] = [
      '#type' => 'number',
      '#title' => $this->t('Stock'),
      '#min' => 0,
      '#step' => 1,
      '#required' => TRUE,
      '#default_value' => $product['stock'] ?? 0,
    ];

    $form['descripcion'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Descripción'),
      '#rows' => 5,
      '#default_value' => $product['descripcion'] ?? '',
      '#placeholder' => $this->t('Descripción opcional del producto.'),
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $id ? $this->t('Actualizar producto') : $this->t('Guardar producto'),
      '#button_type' => 'primary',
    ];

    $form['actions']['cancel'] = [
      '#type' => 'link',
      '#title' => $this->t('Cancelar'),
      '#url' => Url::fromRoute('productos_crud.list'),
      '#attributes' => ['class' => ['button', 'button--secondary']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    $nombre = trim((string) $form_state->getValue('nombre'));
    $codigo = trim((string) $form_state->getValue('codigo'));
    $categoria = trim((string) $form_state->getValue('categoria'));
    $costo = (float) $form_state->getValue('costo');
    $precio = (float) $form_state->getValue('precio');
    $stock = (int) $form_state->getValue('stock');

    if (mb_strlen($nombre) < 2) {
      $form_state->setErrorByName('nombre', $this->t('El nombre debe tener al menos 2 caracteres.'));
    }

    if (mb_strlen($codigo) < 2) {
      $form_state->setErrorByName('codigo', $this->t('El código debe tener al menos 2 caracteres.'));
    }
    elseif (!preg_match('/^[A-Za-z0-9\-_.\s]+$/', $codigo)) {
      $form_state->setErrorByName('codigo', $this->t('El código solo puede contener letras, números, guiones, puntos y espacios.'));
    }

    if (mb_strlen($categoria) < 2) {
      $form_state->setErrorByName('categoria', $this->t('La categoría debe tener al menos 2 caracteres.'));
    }

    if ($costo < 0) {
      $form_state->setErrorByName('costo', $this->t('El costo no puede ser negativo.'));
    }

    if ($precio < 0) {
      $form_state->setErrorByName('precio', $this->t('El precio no puede ser negativo.'));
    }

    if ($precio > 0 && $costo > $precio) {
      $form_state->setErrorByName('costo', $this->t('El costo no puede ser mayor que el precio de venta.'));
    }

    if ($stock < 0) {
      $form_state->setErrorByName('stock', $this->t('El stock no puede ser negativo.'));
    }

    $route_match = \Drupal::routeMatch();
    $id = $route_match->getParameter('id');
    $existing = $this->database()->select('productos_crud', 'p')
      ->fields('p', ['id'])
      ->condition('codigo', $codigo)
      ->execute()
      ->fetchField();

    if ($existing && (int) $existing !== (int) $id) {
      $form_state->setErrorByName('codigo', $this->t('El código ya existe. Debe ser único.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $route_match = \Drupal::routeMatch();
    $id = $route_match->getParameter('id');

    $values = [
      'nombre' => trim((string) $form_state->getValue('nombre')),
      'codigo' => trim((string) $form_state->getValue('codigo')),
      'categoria' => trim((string) $form_state->getValue('categoria')),
      'costo' => (float) $form_state->getValue('costo'),
      'precio' => (float) $form_state->getValue('precio'),
      'stock' => (int) $form_state->getValue('stock'),
      'descripcion' => trim((string) $form_state->getValue('descripcion')),
      'created' => REQUEST_TIME,
    ];

    if ($id) {
      $this->database()->update('productos_crud')->fields($values)->condition('id', $id)->execute();
      $this->messenger()->addStatus($this->t('Producto actualizado correctamente.'));
    }
    else {
      $this->database()->insert('productos_crud')->fields($values)->execute();
      $this->messenger()->addStatus($this->t('Producto creado correctamente.'));
    }

    $form_state->setRedirect('productos_crud.list');
  }

}
