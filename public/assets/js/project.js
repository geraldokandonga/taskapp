$(function () {
    //Add Project
    $(".btn-add-project").click(function () {
        initForm();
        $("#project_modal").modal("show");
    });

    //Edit Project
    $("body").on("click", ".btn-edit-project", function () {
        let projectId = $(this).closest("li.project-row").data("id");
        $.ajax({
            type: "GET",
            dataType: "json",
            url: baseSiteURL + "/projects/" + projectId,
            success: function (response) {
                if (response.status == "success") {
                    $("#project_id").val(response.data.id);
                    $("#project_name").val(response.data.name);
                    $("#project_form").removeClass("was-validated");
                    $("#project_modal").modal("show");
                } else {
                    toastr["error"](response.message);
                    $("#project-row-" + projectId).remove();
                }
            },
        });
    });

    // Submit update / add project
    $("#project_form").submit(function (event) {
        let projectForm = $(this);

        if (projectForm[0].checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        } else {
            let reqParam = {
                id: $(this).find("#project_id").val(),
                name: $(this).find("#project_name").val(),
                _token: $(this).find("input[name='_token']").val(),
                _method: $(this).find("#_method").val(),
            };
            updateProject(reqParam);
        }
        projectForm.addClass("was-validated");
        return false;
    });

    // Delete Project
    $("body").on("click", ".btn-delete-project", function () {
        let projectId = $(this).closest("li.project-row").data("id");
        let token = $("#csrf_token").val();
        bootbox.confirm(
            "Are you sure to delete this project?",
            function (result) {
                if (result) {
                    //Delete the project
                    $.ajax({
                        type: "DELETE",
                        dataType: "json",
                        data: { _token: token },
                        url: gSiteURL + "/projects/" + projectId,
                        success: function (response) {
                            if (response.status == "success") {
                                $("#project-row-" + taskId).remove();
                                toastr["success"](response.message);
                            } else {
                                toastr["error"](response.message);
                            }
                        },
                    });
                }
            }
        );
    });

    //Update project function with reqParam object
    function updateProject(reqParam, url = "/projects") {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: baseSiteURL + url,
            data: reqParam,
            success: function (response) {
                if (response.status == "success") {
                    if (response.hasOwnProperty("html")) {
                        $("#project_list").html(response.html);
                    }

                    $("#project_modal").modal("hide");
                    toastr["success"](response.message);
                } else {
                    toastr["error"](response.message);
                }
            },
        });
    }

    //Init edit/add form
    function initForm() {
        $("#project_id").val("");
        $("#project_name").val("");
        $("#project_form").removeClass("was-validated");
        $("#_method").val("POST");
    }

    // redirect to show page when project is selected
    $("#selected_project_id").change(function () {
        var value = $(this).val();
        window.location = "projects/" + value;
    });
});
