<div id="card-container" class="container my-card2" style="color:rgb(0, 0, 0);">
  <div class="row mt-4">
    <h4 style="margin-bottom: 50px;">Изменение/Удаление графиков работ</h4><br />
    <div id="status"></div>
    <div id="response"></div><br />
  </div>
</div>

<script>
  $(document).ready(function() {
    $('#response').empty();
    var data = <?php echo $response_table ?>;
    var table = '<table class="table">';
    var th = '<thead><tr>';
    var i = 0;

    $(data[0]).each(function(ind_cell, val_cell) {
      th += "<th>" + val_cell + "</th>";
    });

    th += '<th>Изменить</th><th>Удалить</th></tr></thead>';
    table += th;
    var row = '<tbody>';

    $(data).each(function(index, element) {
      if (i > 0) {
        row += '<tr>';
        var col = '';
        $(element).each(function(ind_cell, val_cell) {
          col += "<td>" + val_cell + "</td>";
        })
        col += `
      <td>
        <button type="button" class="btn btn-outline-primary" href='javascript:void(0)' onclick='editData(` + data[index][0] + `)'"> Изменить
        </button>
      </td>
      <td>
        <button type="button" class="btn btn-outline-danger" href='javascript:void(0)' onclick='deleteData(` + data[index][0] + `)'"> Удалить
        </button>
      </td>`;

        row += col;
        row += '</tr>';
      }
      i++;
    });

    table += row;
    table += '</tbody></table>';
    $('#response').append(table);
  });
  var deleteData = function(ID) {
    $.ajax({
        type: 'POST',
        url: '/schedules/delete',
        data: {
          deleteId: ID
        },
        dataType: 'text'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#status').empty();
        $('#status').append(data + '<br /><br />');
        showObjectData();
      })
      .fail(function(jqXHR, textStatus) {
        alert("При обращении к серверу возникли проблемы: " + textStatus);
      });
  };

  function showObjectData() {
    $.ajax({
        type: 'POST',
        url: '/schedules/data',
        dataType: 'json'
      })
      .done(function(data, textStatus, jqXHR) {
        $('#response').empty();
        var table = '<table class="table">';
        var th = '<thead><tr>';
        var i = 0;

        $(data[0]).each(function(ind_cell, val_cell) {
          th += "<th>" + val_cell + "</th>";
        });

        th += '<th>Изменить</th><th>Удалить</th></tr></thead>';
        table += th;
        var row = '<tbody>';

        $(data).each(function(index, element) {
          if (i > 0) {
            row += '<tr>';
            var col = '';
            $(element).each(function(ind_cell, val_cell) {
              col += "<td>" + val_cell + "</td>";
            })
            col += `
        <td>
          <button type="button" class="btn btn-outline-primary" href='javascript:void(0)' onclick='editData(` + data[index][0] + `)'"> Изменить
          </button>
        </td>
        <td>
          <button type="button" class="btn btn-outline-danger" href='javascript:void(0)' onclick='deleteData(` + data[index][0] + `)'"> Удалить
          </button>
        </td>`;

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
        alert("При обращении к серверу возникли проблемы: " + textStatus);
      });
  };
  var editData = function(ID) {
    $.ajax({
        type: 'GET',
        url: '/schedules/brigade_names',
        dataType: 'json'
      })
    .done(function(data, textStatus, jqXHR) {
      $.ajax({
          type: 'GET',
          url: '/objects/object_names',
          dataType: 'json'
        })
      .done(function(obj_data, obj_textStatus, obj_jqXHR) {
        select = '<select id="select_brigades" class="form-select" size="7" multiple>';
        i = 0;
        $(data).each(function(index, element) {
          $(element).each(function(ind_cell, val_cell) {
            select += '<option value="' + i + '">' + element + "</option>";
          })
          i++;
        });
        select += '</select>';

        obj_select = '<select id="select_objects" class="form-select" size="7" multiple>';
        i = 0;
        $(obj_data).each(function(index, element) {
          $(element).each(function(ind_cell, val_cell) {
            obj_select += '<option value="' + i + '">' + element + "</option>";
          })
          i++;
        });
        obj_select += '</select>';

        $('#card-container').empty();
        $object_edit = `
          <form id="object_edit">
            <input id="ID_edit" type="hidden" name="ID_edit" value="` + ID + `">
            <h4 class="mt-4">Изменить график работ</h4><br />
            <div class="container">
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Номер объекта: ` + ID + `</h5></div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Наименование бригады:</h5></div>
                <div class="col-sm">
                  <div id="div_select_brigades">` + select + `</div>
                </div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Название объекта:</h5></div>
                <div class="col-sm">
                  <div id="div_select_objects">` + obj_select + `</div>
                </div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Описание работ</h5></div>
                <div class="col-sm">
                  <input id="object_name" type="text" class="form-control">
                </div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Дата начала работ:</h5></div>
                <div class="col-sm">
                  <input id="work_start_date" type="text" class="form-control" placeholder="2025-07-30">
                </div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Дата окончания работ:</h5></div>
                <div class="col-sm">
                  <input id="work_end_date" type="text" class="form-control" placeholder="2025-08-05">
                </div>
                <div class="col-sm"></div>
              </div>
              <div class="row mt-4">
                <div class="col-sm"></div>
                <div class="col-sm"><h5>Стоимость работ:</h5></div>
                <div class="col-sm">
                  <div class="input-group">
                    <input id="cost" type="number" class="form-control">
                    <div class="input-group-append">
                      <span class="input-group-text">$</span>
                    </div>
                  </div>
                </div>
                <div class="col-sm"></div>
              </div>
            </div>
            <div class="mt-4">
              <span class="input-group-btn">
                <button id="button_object_edit" type="submit" class="btn btn-outline-primary">Изменить</button>
              </span>
            </div>
            <div class="mt-5">
              <span class="input-group-btn">
                <button id="reset" type="reset" class="btn btn-outline-primary">Очистить форму</button>
              </span>
            </div>
            <div id="status" class="mt-3"></div>
            <div class="mt-3"></div>
          </form>`;

        $('#card-container').append($object_edit);

        $('#work_start_date').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true
        });

        $('#work_end_date').datepicker({
          format: 'yyyy-mm-dd',
          autoclose: true,
          todayHighlight: true
        });
      })
      .fail(function(obj_jqXHR, obj_textStatus) {
        alert("При обращении к серверу возникли проблемы: " + obj_textStatus);
      });
    })
    .fail(function(jqXHR, textStatus) {
      alert("При обращении к серверу возникли проблемы: " + textStatus);
    });
  };
  $("#card-container").on("submit", "#object_edit", function() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/schedules/edit',
        data: {
          editId: $("#ID_edit").val(),
          brigade_name: $("#select_brigades option:selected").text(),
          object_name: $("#select_objects option:selected").text(),
          description: $("#object_name").val(),
          from: $("#work_start_date").val(),
          to: $("#work_end_date").val(),
          cost: $("#cost").val()
        },
        dataType: 'text'
      })
      .done(function(data, textStatus, jqXHR) {
        objectData = `
    <div class="row mt-4">
      <h4 style="margin-bottom: 50px;">Изменение/Удаление графиков работ</h4><br />
      <div id="status">` + data + `<br /><br /></div>
      <div id="response"></div><br />
    </div>`;
        $('#card-container').empty();
        $('#card-container').append(objectData);
        showObjectData();
      })
      .fail(function(jqXHR, textStatus) {
        alert("При обращении к серверу возникли проблемы: " + textStatus);
      });
  });
</script>