$(function () {
    //Drag and drop
    $("#task_list")
        .sortable({
            placeholder: "drop-placeholder",
        })
        .bind("sortupdate", function (e, ui) {
            var token = $("#csrf_token").val();
            let order = [];
            let id = null;
            $("#task_list .task-row").each(function (index, element) {
                order.push({
                    id: $(this).attr("data-id"),
                    priority: index + 1,
                });
                id = $(this).attr("data-id");
            });

            let reqParam = {
                action: "priority",
                order: order,
                _token: token,
            };
            updateTask(reqParam, id);
        });

    //Add Task
    $(".btn-add-task").click(function () {
        initForm();
        $("#task_priority").val(1);
        $("#new_task_modal").modal("show");
    });

    //Edit Task
    $("body").on("click", ".btn-edit-task", function () {
        let taskId = $(this).closest("li.task-row").data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: baseSiteURL + "/tasks/" + taskId,
            success: function (response) {
                if (response.status == "success") {
                    $("#task_id").val(response.data.id);
                    $("#task_name").val(response.data.name);
                    $("#task_priority").val(response.data.priority);
                    $("#edit_task_form").removeClass("was-validated");
                    $("#edit_task_modal").modal("show");
                } else {
                    toastr["error"](response.message);
                    $("#task-row-" + taskId).remove();
                }
            },
        });
    });

    // Submit update / add task
    $("#edit_task_form").submit(function (event) {
        let taskForm = $(this);

        if (taskForm[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let reqParam = {
                id: $(this).find("#task_id").val(),
                name: $(this).find("#task_name").val(),
                priority: $(this).find("#task_priority").val(),
                _token: $(this).find("input[name='_token']").val(),
            };
            updateTask(reqParam, $(this).find("#task_id").val());
        }
        taskForm.addClass("was-validated");
        return false;
    });

    // Submit new task
    $("#new_task_form").submit(function (event) {
        let taskForm = $(this);

        if (taskForm[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let reqParam = {
                id: $(this).find("#task_id").val(),
                name: $(this).find("#task_name").val(),
                priority: $(this).find("#task_priority").val(),
                project_id: $(this).find("#project_id").val(),
                _token: $(this).find("input[name='_token']").val(),
            };
            createTask(reqParam);
        }
        taskForm.addClass("was-validated");
        return false;
    });

    // Delete Task
    $("body").on("click", ".btn-delete-task", function () {
        let taskId = $(this).closest("li.task-row").data("id");
        let token = $("#csrf_token").val();
        bootbox.confirm("Are you sure to delete this task?", function (result) {
            if (result) {
                //Delete the task
                $.ajax({
                    type: "DELETE",
                    dataType: "json",
                    data: { _token: token },
                    url: baseSiteURL + "/tasks/" + taskId + "/destroy",
                    success: function (response) {
                        if (response.status == "success") {
                            $("#task-row-" + taskId).remove();
                            toastr["success"](response.message);
                        } else {
                            toastr["error"](response.message);
                        }
                    },
                });
            }
        });
    });

    //Create new task function with reqParam object
    function createTask(reqParam) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseSiteURL + "/tasks",
            data: reqParam,
            success: function (response) {
                if (response.status == "success") {
                    if (response.hasOwnProperty("html")) {
                        $("#task_list").html(response.html);
                    }
                    $("#new_task_modal").modal("hide");
                    toastr["success"](response.message);
                    setTimeout(() => {
                        window.location.reload();
                    }, 300);
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }

    // Update task
    function updateTask(reqParam, taskId) {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseSiteURL + "/tasks/" + taskId + "/update",
            data: reqParam,
            success: function (response) {
                if (response.status == "success") {
                    if (response.hasOwnProperty("html")) {
                        $("#task_list").html(response.html);
                    }
                    $("#edit_task_modal").modal("hide");
                    toastr["success"](response.message);
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }

    //Init edit/add form
    function initForm() {
        $("#task_id").val("");
        $("#task_name").val("");
        $("#task_priority").val("");
        $("#edit_task_form").removeClass("was-validated");
    }
});
