<div id="card-container" class="container my-card2" style="color:rgb(0, 0, 0);">
  <div class="row mt-4">
    <h4 style="margin-bottom: 50px;">Изменение/Удаление типов объектов</h4><br />
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
var deleteData = function(ID){
  $.ajax( {
    type: 'POST',
    url: '/object_types/delete',
    data:{
      deleteId:ID
    },
    dataType: 'text'
  })
  .done(function (data, textStatus, jqXHR) { 
    $('#status').empty();
    $('#status').append(data + '<br /><br />');
    showObjectData();
  })
  .fail(function (jqXHR,textStatus) {
    alert("При обращении к серверу возникли проблемы: " + textStatus);
  });
};
function showObjectData(){
  $.ajax( {
    type: 'POST',
    url: '/object_types/data',
    dataType: 'json'
  })
  .done(function (data, textStatus, jqXHR) { 
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
  .fail(function (jqXHR,textStatus) {
    alert("При обращении к серверу возникли проблемы: " + textStatus);
  });
};
var editData = function(ID){
  $.ajax( {
    type: 'POST',
    url: '/object_types/types',
    dataType: 'json'
  })
  .done(function (data, textStatus, jqXHR) { 
    select = '<select id="select_object_types" class="form-select" size="10" multiple>';
    i=0;
    $(data).each(function(index, element) { 
      $(element).each(function(ind_cell, val_cell) {
        select += '<option value="'+ i + '">' + element + "</option>";
      })
      i++;
    });
    select += '</select>';

    $('#card-container').empty();
    $object_edit=`
    <form id="object_edit">
      <input id="ID_edit" type="hidden" name="ID_edit" value="`+ ID +`">
      <h4 class="mt-4">Изменить тип объекта</h4><br />
      <div class="container">
        <div class="row mt-4">
          <div class="col-sm"></div>
          <div class="col-sm"><h5>Номер типа объекта: `+ ID +`</h5></div>
          <div class="col-sm"></div>
        </div>
        <div class="row mt-4">
          <div class="col-sm"></div>
          <div class="col-sm"><h5>Наименование типа объекта:</h5></div>
          <div class="col-sm">
            <input id="object_name" type="text" class="form-control">
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
      <div id="statused" class="mt-3"></div>
      <div class="mt-3"></div>
    </form>`;

    $('#card-container').append($object_edit);
  })
  .fail(function (jqXHR,textStatus) {
    alert("При обращении к серверу возникли проблемы: " + textStatus);
  });
};
$("#card-container").on("submit", "#object_edit",function() {
  event.preventDefault();
  $.ajax( {
    type: 'POST',
    url: '/object_types/edit',
    data: {
      editId:$("#ID_edit").val(),
      type_name: $("#object_name").val()
    },
    dataType: 'text'
  })
  .done(function (data, textStatus, jqXHR) { 
    objectData=`
    <div class="row mt-4">
      <h4 style="margin-bottom: 50px;">Изменение/Удаление типов объектов</h4><br />
      <div id="status">`+data+`<br /><br /></div>
      <div id="response"></div><br />
    </div>`;
    $('#card-container').empty();
    $('#card-container').append(objectData);
    showObjectData();
  })
  .fail(function (jqXHR,textStatus) {
    alert("При обращении к серверу возникли проблемы: " + textStatus);
  });
});
</script>