<div class="container my-card2" style="color:rgb(0, 0, 0);">
  <form id="object_add">
    <h4 class="mt-4">Добавить новый объект</h4><br />
    <div class="container">
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm"><h5>Тип объекта:</h5></div>
        <div class="col-sm">
          <div id="div_select_object_types"></div>
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm"><h5>Наименование объекта:</h5></div>
        <div class="col-sm">
          <input id="object_name" type="text" class="form-control">
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm"><h5>Город:</h5></div>
        <div class="col-sm">
          <input id="object_city" type="text" class="form-control">
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm"><h5>Улица:</h5></div>
        <div class="col-sm">
          <input id="object_street" type="text" class="form-control">
        </div>
        <div class="col-sm"></div>
      </div>
    </div>
    <div class="mt-4">
      <span class="input-group-btn">
        <button id="button_object_add" type="submit" class="btn btn-outline-primary">Добавить</button>
      </span>
    </div>
    <div class="mt-5">
      <span class="input-group-btn">
        <button id="reset" type="reset" class="btn btn-outline-primary">Очистить форму</button>
      </span>
    </div>
    <div id="status" class="mt-3"></div>
    <div class="mt-3"></div>
  </form>
</div>

<script>

$(document).ready(function() {
  var data = <?php echo $select_object_types ?>;
  select = '<select id="select_object_types" class="form-select" size="10" multiple>';
  i=0;
  $(data).each(function(index, element) { 
    $(element).each(function(ind_cell, val_cell) {
      select += '<option value="'+ i + '">' + element + "</option>";
    })
    i++;
  });
  select += '</select>';
  $('#div_select_object_types').append(select);
});

$("#object_add").on("submit", function() {
  event.preventDefault();
  $.ajax( {
    type: 'POST',
    url: '/objects/create',
    data: {
      object_type: $("#select_object_types option:selected").text(),
      object_name: $("#object_name").val(),
      object_city: $("#object_city").val(),
      object_street: $("#object_street").val()
    },
    dataType: 'text'
  })
  .done(function (data, textStatus, jqXHR) { 
    $('#status').empty();
    $('#status').append(data);
  })
  .fail(function (jqXHR,textStatus) {
    alert("При обращении к серверу возникли проблемы: " + textStatus);
  });
});

$("#reset").on("click", function() {
  $('#status').empty();
});

</script>