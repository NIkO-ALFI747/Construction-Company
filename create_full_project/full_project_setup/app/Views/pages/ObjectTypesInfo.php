<div class="row">
  <div class="col-md-4 col-sm-4">
    <div class="container my-card2" style="color:rgb(0, 0, 0);">
      <div id="forms_1">
        <div class="div_filter">
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
                В алфавитном порядке
              </label>
            </div>
            <div style="text-align:left;" class="form-check">
              <input type="radio" name="flexRadioDefault" id="flexRadioDefault4" value="1">
              <label class="form-check-label" for="flexRadioDefault4">
                В обратном алфавитном порядке
              </label>
            </div>
          </form><br /><br />
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-8 col-sm-8">
    <div class="container my-card2" style="color:rgb(0, 0, 0);">
      <h4>Информация о типах объектов строительства</h4><br />
      <div id="response"></div><br />
    </div>
  </div>
</div>

<script>

$(document).ready(function() {
  $('#response').empty();
  var data = <?php echo $response_table ?>;
  var table = '<table class="table">';
  var th = '<thead><tr>';

  var select = '<select id="select_object_columns" class="form-select">';
  var select2 = '<select id="select_object_columns2" class="form-select">'
  var i = 0;

  $(data[0]).each(function(ind_cell, val_cell) { 
    th += "<th>" + val_cell + "</th>";
    select += '<option value="'+ i + '">' + val_cell + "</option>";
    select2 += '<option value="'+ i + '">' + val_cell + "</option>";
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
    if (i > 0){
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


  data = <?php echo $select_object_types ?>;
  select = '<select id="select_object_types" class="form-select">';
  i=0;
  $(data).each(function(index, element) { 
    $(element).each(function(ind_cell, val_cell) {
      select += '<option value="'+ i + '">' + element + "</option>";
    })
    i++;
  });
  select += '</select>';
  $('#div_select_object_types').append(select);


  data = <?php echo $select_object_cities ?>;
  select = '<select id="select_object_cities" class="form-select">';
  i=0;
  $(data).each(function(index, element) { 
    $(element).each(function(ind_cell, val_cell) {
      select += '<option value="'+ i + '">' + element + "</option>";
    })
    i++;
  });
  select += '</select><br />';
  $('#div_select_object_cities').append(select);
});

$("#select_object_columns").ready(function() {
  $("#select_object_columns").prop("selectedIndex", 0);
});
$("#select_object_columns2").ready(function() {
  $("#select_object_columns2").prop("selectedIndex", 0);
});

$("#input_search").on("keyup", function() {
  $.ajax( {
    type: 'POST',
    url: '/object_types/search',
    data: {
      object_column: $("#select_object_columns").val(),
      search_val: $(this).val()
    },
    dataType: 'json'
  })
  .done(function (data, textStatus, jqXHR) { 
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
      if (i > 0){
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
  .fail(function (jqXHR,textStatus) {
    if(textStatus == 'parsererror') {
      $('#response').empty();
      $('#response').append(jqXHR.responseText);
    }
    else {
      alert("При обращении к серверу возникли проблемы: " + textStatus);
    }
  });
});
$('input[name="flexRadioDefault"]').on("click", function() {
  $.ajax( {
    type: 'POST',
    url: '/object_types/sort',
    data: {
      object_column: $("#select_object_columns2").val(),
      sort_val: $(this).val()
    },
    dataType: 'json'
  })
  .done(function (data, textStatus, jqXHR) { 
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
      if (i > 0){
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
  .fail(function (jqXHR,textStatus) {
    if(textStatus == 'parsererror') {
      $('#response').empty();
      $('#response').append(jqXHR.responseText);
    }
    else {
      alert("При обращении к серверу возникли проблемы: " + textStatus);
    }
  });
});
$('#reset').on("click", function() {
  $("#select_object_types").ready(function() {
    $("#select_object_types").prop("selectedIndex", -1);
  });
  $("#select_object_cities").ready(function() {
    $("#select_object_cities").prop("selectedIndex", -1);
  });
  $.ajax( {
    type: 'POST',
    url: '/object_types/reset',
    dataType: 'json'
  })
  .done(function (data, textStatus, jqXHR) { 
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
      if (i > 0){
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
  .fail(function (jqXHR,textStatus) {
    if(textStatus == 'parsererror') {
      $('#response').empty();
      $('#response').append(jqXHR.responseText);
    }
    else {
      alert("При обращении к серверу возникли проблемы: " + textStatus);
    }
  });
})

</script>