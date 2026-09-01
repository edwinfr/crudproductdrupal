(function ($, Drupal, once) {
  'use strict';

  Drupal.behaviors.productosCrud = {
    attach: function (context, settings) {
      once('productos-crud', '.productos-crud-wrapper', context).forEach(function (element) {
        var $wrapper = $(element);
        var $table = $wrapper.find('table');
        var $tbody = $wrapper.find('.productos-crud-body');
        var $pagination = $wrapper.find('.productos-crud-pagination');
        var pageSize = parseInt($table.attr('data-page-size'), 10) || 5;
        var currentRows = [];
        var currentPage = 0;

        function renderRows(rows) {
          currentRows = rows;
          currentPage = 0;
          renderPage(currentPage);
        }

        function renderPage(page) {
          var totalPages = Math.max(1, Math.ceil(currentRows.length / pageSize));
          if (page < 0) {
            page = 0;
          }
          if (page >= totalPages) {
            page = totalPages - 1;
          }

          currentPage = page;
          var start = currentPage * pageSize;
          var end = start + pageSize;
          var rowsToShow = currentRows.slice(start, end);

          if (!rowsToShow.length) {
            $tbody.html('<tr class="productos-crud-empty-row"><td colspan="8">No se encontraron productos.</td></tr>');
          }
          else {
            var markup = rowsToShow.map(function (row) {
              return '<tr>' +
                '<td>' + row.id + '</td>' +
                '<td>' + row.nombre + '</td>' +
                '<td>' + row.codigo + '</td>' +
                '<td>' + row.categoria + '</td>' +
                '<td>$' + row.costo + '</td>' +
                '<td>$' + row.precio + '</td>' +
                '<td>' + row.stock + '</td>' +
                '<td><a href="' + row.edit + '" class="btn btn-sm btn-warning">Editar</a> ' +
                '<a href="' + row.delete + '" class="btn btn-sm btn-danger" onclick="return confirm(\'¿Eliminar producto?\')">Eliminar</a></td>' +
                '</tr>';
            }).join('');
            $tbody.html(markup);
          }

          var buttons = [];
          for (var i = 0; i < totalPages; i++) {
            buttons.push('<button type="button" class="page-btn ' + (i === currentPage ? 'active' : '') + '" data-page="' + i + '">' + (i + 1) + '</button>');
          }
          $pagination.html(buttons.join(''));
          $pagination.find('.page-btn').on('click', function () {
            renderPage(parseInt($(this).attr('data-page'), 10));
          });
        }

        function getRowsFromTable() {
          return $tbody.find('tr').filter(function () {
            return !$(this).hasClass('productos-crud-empty-row');
          }).map(function () {
            var $row = $(this);
            return {
              id: $row.find('td').eq(0).text().trim(),
              nombre: $row.find('td').eq(1).text().trim(),
              codigo: $row.find('td').eq(2).text().trim(),
              categoria: $row.find('td').eq(3).text().trim(),
              costo: $row.find('td').eq(4).text().trim().replace('$', ''),
              precio: $row.find('td').eq(5).text().trim().replace('$', ''),
              stock: $row.find('td').eq(6).text().trim(),
              edit: $row.find('a.btn-warning').attr('href'),
              delete: $row.find('a.btn-danger').attr('href')
            };
          }).get();
        }

        function filterRows(keyword) {
          var term = keyword.toLowerCase();
          var rows = getRowsFromTable();
          var filtered = rows.filter(function (row) {
            var text = (row.nombre + ' ' + row.codigo + ' ' + row.categoria).toLowerCase();
            return text.indexOf(term) !== -1;
          });
          renderRows(filtered);
        }

        var defaultRows = getRowsFromTable();
        renderRows(defaultRows);

        $wrapper.find('.productos-crud-search-form').on('submit', function (event) {
          event.preventDefault();
          var keyword = $(this).find('input[name="search"]').val();

          if (!keyword || $.trim(keyword) === '') {
            renderRows(getRowsFromTable());
            return;
          }

          $.ajax({
            url: '/admin/productos/search',
            method: 'GET',
            data: { search: keyword },
            success: function (response) {
              var rows = (response.items || []).map(function (item) {
                return {
                  id: item.id,
                  nombre: item.nombre,
                  codigo: item.codigo,
                  categoria: item.categoria,
                  costo: item.costo,
                  precio: item.precio,
                  stock: item.stock,
                  edit: item.edit,
                  delete: item.delete
                };
              });
              renderRows(rows);
            },
            error: function () {
              filterRows(keyword);
            }
          });
        });
      });
    }
  };
})(jQuery, Drupal, once);
