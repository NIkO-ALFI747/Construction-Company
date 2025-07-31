<div class="container my-card2" style="color:rgb(0, 0, 0);">
  <form id="object_add">
    <h4 class="mt-4">Добавить новый тип объекта</h4><br />
    <div class="container">
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

$("#object_add").on("submit", function() {
  event.preventDefault();
  $.ajax( {
    type: 'POST',
    url: '/object_types/create',
    data: {
      type_name: $("#object_name").val()
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