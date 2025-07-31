<div class="container my-card2" style="color:rgb(0, 0, 0);">
  <form id="object_add">
    <h4 class="mt-4">Добавить новый график работ</h4><br />
    <div class="container">
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Наименование бригады:</h5>
        </div>
        <div class="col-sm">
          <div id="div_select_brigades"></div>
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Название объекта:</h5>
        </div>
        <div class="col-sm">
          <div id="div_select_objects"></div>
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Описание работ</h5>
        </div>
        <div class="col-sm">
          <input id="object_name" type="text" class="form-control">
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Дата начала работ:</h5>
        </div>
        <div class="col-sm">
          <input id="work_start_date" type="text" class="form-control" placeholder="2025-07-30">
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Дата окончания работ:</h5>
        </div>
        <div class="col-sm">
          <input id="work_end_date" type="text" class="form-control" placeholder="2025-08-05">
        </div>
        <div class="col-sm"></div>
      </div>
      <div class="row mt-4">
        <div class="col-sm"></div>
        <div class="col-sm">
          <h5>Стоимость работ:</h5>
        </div>
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

    var data = <?php echo $select_brigades ?>;
    select = '<select id="select_brigades" class="form-select" size="7" multiple>';
    i = 0;
    $(data).each(function(index, element) {
      $(element).each(function(ind_cell, val_cell) {
        select += '<option value="' + i + '">' + element + "</option>";
      })
      i++;
    });
    select += '</select>';
    $('#div_select_brigades').append(select);


    var data = <?php echo $select_objects ?>;
    select = '<select id="select_objects" class="form-select" size="7" multiple>';
    i = 0;
    $(data).each(function(index, element) {
      $(element).each(function(ind_cell, val_cell) {
        select += '<option value="' + i + '">' + element + "</option>";
      })
      i++;
    });
    select += '</select>';
    $('#div_select_objects').append(select);
  });

  $("#object_add").on("submit", function() {
    event.preventDefault();
    $.ajax({
        type: 'POST',
        url: '/schedules/create',
        data: {
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
        $('#status').empty();
        $('#status').append(data);
      })
      .fail(function(jqXHR, textStatus) {
        alert("При обращении к серверу возникли проблемы: " + textStatus);
      });
  });

  $("#reset").on("click", function() {
    $('#status').empty();
  });
</script>