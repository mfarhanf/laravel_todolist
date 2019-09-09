$(document).ready(function() {
  function loadTodosTable() {
    $.ajax({
      method: "GET",
      url: "todos",
      data: { userId: userId }
    }).done(function(response) {
      var todos = response.todos;

      $("#delete-selected").prop("disabled", response.deleteSelected);

      if (todos.length === 0) {
        var todosElement =
          '<tr><td class="text-center" colspan="3">No data found.</td></tr>';
      } else {
        var todosElement = "";

        $.each(todos, function(key, value) {
          var checked = value.is_done ? "checked" : "";
          var success = value.is_done ? "class=success" : "";

          todosElement +=
            `<tr id="` +
            value.id +
            `" ` +
            success +
            `>
            <td class="text-center">
              <input type="checkbox" name="todo-ids[` +
            value.id +
            `]" value="` +
            value.id +
            `" ` +
            checked +
            `>
            </td>
            <td>` +
            value.todo +
            `</td>
            <td>
              <button type="button" class="btn btn-link delete">
                <i class="fa fa-btn fa-trash"></i>Delete
              </button>
            </td>
            </tr>`;
        });
      }

      if (todosElement !== "") {
        $("table tbody").html(todosElement);
      }
    });
  }

  function alert(type, message) {
    var element =
      `<div class="alert alert-dismissible show ` +
      type +
      `" role="alert">
        <span>` +
      message +
      `</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>`;

    $("div.alert-section")
      .html(element)
      .alert();
  }

  loadTodosTable();

  $.ajaxSetup({
    headers: {
      "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content")
    }
  });

  $("#add-todo").on("click", function() {
    var todo = $("#todo").val();

    $.ajax({
      method: "POST",
      url: "todos",
      data: { todo: todo, userId: userId }
    })
      .done(function(response) {
        loadTodosTable();

        alert("alert-success", response.success);
        $("#todo").val("");
        $("#todo-form:first-child").removeClass("has-error");
        $("#todo-form .help-block")
          .html("")
          .addClass("hide");
      })
      .error(function(response) {
        var message = response.responseJSON.error;

        $("#todo-form:first-child").addClass("has-error");
        $("#todo-form .help-block")
          .html("<strong>" + message + "</strong>")
          .removeClass("hide");
      });
  });

  $(document).on("click", "button.delete", function() {
    var row = $(this)
      .parents()
      .eq(1);

    $.ajax({
      method: "DELETE",
      url: "todos/" + row.attr("id")
    })
      .done(function(response) {
        alert("alert-success", response.success);
        loadTodosTable();
      })
      .error(function(response) {
        alert("alert-success", response.responseJSON.error);
      });
  });

  $("#delete-selected").on("click", function() {
    var selectedIds = [];
    $("input:checked").map(function() {
      return selectedIds.push($(this).val());
    });

    if (selectedIds.length > 0) {
      $.ajax({
        method: "DELETE",
        url: "todos/0/delete-selected",
        data: { ids: selectedIds, userId: userId }
      })
        .done(function(response) {
          alert("alert-success", response.success);
          loadTodosTable();
        })
        .error(function(response) {
          alert("alert-success", response.responseJSON.error);
        });
    }
  });

  $(document).on("change", "input[type=checkbox]", function() {
    var isChecked = $(this).is(":checked");

    $.ajax({
      method: "PATCH",
      url: "todos/" + $(this).val(),
      data: { isChecked: isChecked }
    }).done(function(response) {
      alert("alert-success", response.success);
      loadTodosTable();
    });
  });
});
