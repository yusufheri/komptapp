 Dropzone.autoDiscover = false;

$(document).ready(function () {
    $("#id_dropzone").dropzone({
        maxFiles: 25,
        acceptedFiles: "text/csv,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
        url: "/importation/ajax_file_upload_handler",
        success: function (file, response) {
            console.log(response);
        }
    });

    $("#id_dropzone").on("complete", function(file) {
        $("#id_dropzone").removeFile(file);
    });
})