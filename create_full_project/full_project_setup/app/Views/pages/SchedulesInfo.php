<div class="row">
  <div class="col-md-3 col-sm-3">
    <div class="container my-card2" style="color:rgb(0, 0, 0);">
      <div id="forms_1">
        <div class="div_filter">
          <div id="div_filter">
            <form id="filter_form">
              <h5>Фильтры</h5>
              <span class="head">Стоимость работ</span><br />
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">От</span>
                </div>
                <input type="text" id="min_cost" class="form-control">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">До</span>
                </div>
                <input type="text" id="max_cost" class="form-control">
              </div>
              <span class="head">Срок работ</span><br />
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">От</span>
                </div>
                <input type="text" id="min_date" class="form-control" placeholder="Select a date">
              </div>
              <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">До</span>
                </div>
                <input type="text" id="max_date" class="form-control" placeholder="Select a date">
              </div>
              <span class="head">Бригады</span><br />
              <div id="div_select_brigades"></div>
              <span class="head">Объекты</span>
              <div id="div_select_objects"></div>
              <span class="input-group-btn">
                <input id="reset" type="button" class="btn btn-outline-primary" value="Сбросить">
              </span>
            </form>
          </div><br />
          <div id="div_search">
            <h5>Поиск</h5>
            <span class="head">Поле для поиска</span><br />
            <div id="div_select_object_columns"></div>
            <div class="input-group">
              <input id="input_search" type="search" class="form-control" placeholder="Введите значение для поиска">
            </div>
          </div><br /><br />
          <form id="filter_form2">
            <h5>Сортировка</h5>
            <span class="head">Поле для сортировки</span><br />
            <div id="div_select_object_columns2"></div>
            <div style="text-align:left;" class="form-check">
              <input type="radio" name="flexRadioDefault" id="flexRadioDefault3" value="0" checked>
              <label class="form-check-label" for="flexRadioDefault3">
                По возрастанию (прямой порядок)
              </label>
            </div>
            <div style="text-align:left;" class="form-check">
              <input type="radio" name="flexRadioDefault" id="flexRadioDefault4" value="1">
              <label class="form-check-label" for="flexRadioDefault4">
                По убыванию (обратный порядок)
              </label>
            </div>
          </form><br /><br />
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-9 col-sm-9">
    <div class="container my-card2" style="color:rgb(0, 0, 0);">
      <h4>Информация о графике работ на объектах</h4><br />
      <div id="response"></div><br />
    </div>
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#min_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    });

    $('#max_date').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true,
      todayHighlight: true
    });

    $('#min_date').on('changeDate', function(e) {
      event.preventDefault();
      $.ajax({
          type: 'POST',
          url: '/schedules/filter_cost',
          data: {
            min_cost: $("#min_cost").val(),
            max_cost: $("#max_cost").val(),
            min_date: $("#min_date").val(),
            max_date: $("#max_date").val(),
          },
          dataType: 'json'
        })
        .done(function(data, textStatus, jqXHR) {
          $('#response').empty();

          var table = '<table class="table">';
          var th = '<thead><tr>';

          $(data[0]).each(function(ind_cell, val_cell) {
            th += "<th>" + val_cell + "</th>";
          });

          th += '</tr></thead>';
          table += th;
          var row = '<tbody>';
          var i = 0;

          $(data).each(function(index, element) {
            if (i > 0) {
              row += '<tr>';
              var col = '';
              $(element).each(function(ind_cell, val_cell) {
                col += "<td>" + val_cell + "</td>";
              })
              row += col;
              row += '</tr>';
            }
            i++;
          });

          table += row;
          table += '</tbody></table>';
          $('#response').append(table);
        })
        .fail(function(jqXHR, textStatus) {
          if (textStatus == 'parsererror') {
            $('#response').empty();
            $('#response').append(jqXHR.responseText);
          } else {
            alert("При обращении к серверу возникли проблемы: " + textStatus);
          }
        });
    });

    $('#max_date').on('changeDate', function(e) {
      event.preventDefault();
      $.ajax({
          type: 'POST',
          url: '/schedules/filter_cost',
          data: {
            min_cost: $("#min_cost").val(),
            max_cost: $("#max_cost").val(),
            min_date: $("#min_date").val(),
            max_date: $("#max_date").val(),
          },
          dataType: 'json'
        })
        .done(function(data, textStatus, jqXHR) {
          $('#response').empty();

          var table = '<table class="table">';
          var th = '<thead><tr>';

          $(data[0]).each(function(ind_cell, val_cell) {
            th += "<th>" + val_cell + "</th>";
          });

          th += '</tr></thead>';
          table += th;
          var row = '<tbody>';
          var i = 0;

          $(data).each(function(index, element) {
            if (i > 0) {
              row += '<tr>';
              var col = '';
              $(element).each(function(ind_cell, val_cell) {
                col += "<td>" + val_cell + "</td>";
              })
              row += col;
              row += '</tr>';
            }
            i++;
          });

          table += row;
          table += '</tbody></table>';
          $('#response').append(table);
        })
        .fail(function(jqXHR, textStatus) {
          if (textStatus == 'parsererror') {
            $('#response').empty();
            $('#response').append(jqXHR.responseText);
          } else {
            alert("При обращении к серверу возникли проблемы: " + textStatus);
          }
        });
    });









    $('#response').empty();
    var data = <?php echo $response_table ?>;
    var table = '<table class="table">';
    var th = '<thead><tr>';

    var select = '<select id="select_object_columns" class="form-select">';
    var select2 = '<select id="select_object_columns2" class="form-select">'
    var i = 0;

    $(data[0]).each(function(ind_cell, val_cell) {
      th += "<th>" + val_cell + "</th>";
      select += '<option value="' + i + '">' + val_cell + "</option>";
      select2 += '<option value="' + i + '">' + val_cell + "</option>";
      i++;
    });
    select += '</select><br />';
    select2 += '</select><br />';
    $('#div_select_object_columns').append(select);
    $('#div_select_object_columns2').append(select2);

    table += th;
    var row = '<tbody>';
    i = 0;

    $(data).each(function(index, element) {
      if (i > 0) {
        row += '<tr>';
        var col = '';

        $(element).each(function(ind_cell, val_cell) {
          col += "<td>" + val_cell + "</td>";
        })

        row += col;
        row += '</tr>';
      }
      i++;
    });

    table += row;
    table += '</tbody></table>';

    $('#response').append(table);


    data = <?php echo $select_brigades ?>;
    select = '<select id="select_brigades" class="form-select">';
    i = 0;
    $(data).each(function(index, element) {
      $(element).each(function(ind_cell, val_cell) {
        select += '<option value="' + i + '">' + element + "</option>";
      })
      i++;
    });
    select += '</select>';
    $('#div_select_brigades').append(select);


    data = <?php echo $select_objects ?>;
    select = '<select id="select_objects" class="form-select">';
    i = 0;
    $(data).each(function(index, element) {
      $(element).each(function(ind_cell, val_cell) {
        select += '<option value="' + i + '">' + element + "</option>";
      })
      i++;
    });
    select += '</select><br />';
    $('#div_select_objects').append(select);

  });

  $("#select_brigades").ready(function() {
    $("#select_brigades").prop("selectedIndex", -1);
  });
  $("#select_objects").ready(function() {
    $("#select_objects").prop("selectedIndex", -1);
  });
  $("#select_object_columns").ready(function() {
    $("#select_object_columns").prop("selectedIndex", 0);
  });
  $("#select_object_columns2").ready(function() {
    $("#select_object_columns2").prop("selectedIndex", 0);
  });


  $("#div_filter").on("change", "select", function() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/schedules/filter',
        data: {
          object_type: $("#select_brigades option:selected").text(),
          object_city: $("#select_objects option:selected").text()
        },
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();

        var table = '<table class="table">';
        var th = '<thead><tr>';

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '</tr></thead>';
        table += th;
        var row = '<tbody>';
        var i = 0;

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            row += col;
            row += '</tr>';
          }
          i++;
        });

        table += row;
        table += '</tbody></table>';
        $('#response').append(table);
      })
      .fail(function(jqXHR, textStatus) {
        if (textStatus == 'parsererror') {
          $('#response').empty();
          $('#response').append(jqXHR.responseText);
        } else {
          alert("При обращении к серверу возникли проблемы: " + textStatus);
        }
      });
  });

  $("#div_filter").on("keyup", "input", function() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/schedules/filter_cost',
        data: {
          min_cost: $("#min_cost").val(),
          max_cost: $("#max_cost").val(),
          min_date: $("#min_date").val(),
          max_date: $("#max_date").val(),
        },
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();

        var table = '<table class="table">';
        var th = '<thead><tr>';

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '</tr></thead>';
        table += th;
        var row = '<tbody>';
        var i = 0;

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            row += col;
            row += '</tr>';
          }
          i++;
        });

        table += row;
        table += '</tbody></table>';
        $('#response').append(table);
      })
      .fail(function(jqXHR, textStatus) {
        if (textStatus == 'parsererror') {
          $('#response').empty();
          $('#response').append(jqXHR.responseText);
        } else {
          alert("При обращении к серверу возникли проблемы: " + textStatus);
        }
      });
  });
  $("#input_search").on("keyup", function() {
    $.ajax({
        type: 'POST',
        url: '/schedules/search',
        data: {
          object_column: $("#select_object_columns").val(),
          search_val: $(this).val()
        },
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();

        var table = '<table class="table">';
        var th = '<thead><tr>';

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '</tr></thead>';
        table += th;
        var row = '<tbody>';
        var i = 0;

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            row += col;
            row += '</tr>';
          }
          i++;
        });

        table += row;
        table += '</tbody></table>';
        $('#response').append(table);
      })
      .fail(function(jqXHR, textStatus) {
        if (textStatus == 'parsererror') {
          $('#response').empty();
          $('#response').append(jqXHR.responseText);
        } else {
          alert("При обращении к серверу возникли проблемы: " + textStatus);
        }
      });
  });
  $('input[name="flexRadioDefault"]').on("click", function() {
    $.ajax({
        type: 'POST',
        url: '/schedules/sort',
        data: {
          object_column: $("#select_object_columns2").val(),
          sort_val: $(this).val()
        },
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();

        var table = '<table class="table">';
        var th = '<thead><tr>';

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '</tr></thead>';
        table += th;
        var row = '<tbody>';
        var i = 0;

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            row += col;
            row += '</tr>';
          }
          i++;
        });

        table += row;
        table += '</tbody></table>';
        $('#response').append(table);
      })
      .fail(function(jqXHR, textStatus) {
        if (textStatus == 'parsererror') {
          $('#response').empty();
          $('#response').append(jqXHR.responseText);
        } else {
          alert("При обращении к серверу возникли проблемы: " + textStatus);
        }
      });
  });
  $('#reset').on("click", function() {
    $('#min_cost').val('');
    $('#max_cost').val('');
    $('#min_date').val('').datepicker('update');
    $('#max_date').val('').datepicker('update');
    $("#select_brigades").ready(function() {
      $("#select_brigades").prop("selectedIndex", -1);
    });
    $("#select_objects").ready(function() {
      $("#select_objects").prop("selectedIndex", -1);
    });
    $.ajax({
        type: 'POST',
        url: '/schedules/reset',
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();

        var table = '<table class="table">';
        var th = '<thead><tr>';

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '</tr></thead>';
        table += th;
        var row = '<tbody>';
        var i = 0;

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            row += col;
            row += '</tr>';
          }
          i++;
        });

        table += row;
        table += '</tbody></table>';
        $('#response').append(table);
      })
      .fail(function(jqXHR, textStatus) {
        if (textStatus == 'parsererror') {
          $('#response').empty();
          $('#response').append(jqXHR.responseText);
        } else {
          alert("При обращении к серверу возникли проблемы: " + textStatus);
        }
      });
  })
</script>