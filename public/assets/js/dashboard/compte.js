
$(document).ready(function(){  
    
    function datatable(url = "/admin/compte/api"){
        $('#datatable').notify("Chargement des données en cours ...", {className: "info", position:"t c" });
        var baseurl = url;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET",baseurl,true);
        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState==4 && xmlhttp.status ==200){
                var data = JSON.parse(xmlhttp.responseText);
                $("#count").html(data.length)   
                var table = $("#example").DataTable({
                    "language": {
                        "decimal":        "",
                        "emptyTable":     "<h1>Aucune donnée disponible</h1>",
                        "info":           "Afficher _START_ à _END_ sur _TOTAL_ ligne(s)",
                        "infoEmpty":      "Afficher 0 à 0 sur 0 ligne(s)",
                        "infoFiltered":   "(<b>Filtré de _MAX_ ligne(s) au total</b>)",
                        "infoPostFix":    "",
                        "thousands":      ",",
                        "lengthMenu":     "Afficher _MENU_ lignes",
                        "loadingRecords": "Chargement...",
                        "processing":     "Traitement en cours...",
                        "search":         "Recherche:",
                        "zeroRecords":    "<h2>Aucun enregistrements correspondants trouvés</h2>",
                        "paginate": {
                            "first":      "Premier",
                            "last":       "Dernier",
                            "next":       "Suivant",
                            "previous":   "Précédent"
                        },
                        "aria": {
                            "sortAscending":  ": activate to sort column ascending",
                            "sortDescending": ": activate to sort column descending"
                        }
                    },
                    destroy: true,
                    responsive: true,
                    autoFill: true,
                    data:data,
                    "columns":[
                        {"title": "", "data": null, defaultContent: '' }, 
                        {"title": "Id", "data":"id" , "visible":false},
                        {"title": "Créé", "data": null, render: function(data, type, row) {
                            return moment(row.createdAt).format('DD-MM-YYYY H:m')
                        }},
                        {"title": "Code", "data": "code"},
                        {"title": "Libellé", "data": "name"},
                        {"title": "Description", "data": "content"},
                        {"title": "", "data": null}
                    ],
                    columnDefs: [
                        {
                            "searchable": false,
                            "orderable": false,
                            "targets": 0
                        },
                        { 
                            width: '3%', 
                            targets: 0  //la primer columna tendra una anchura del  20% de la tabla
                        },                       
                        {
                            targets: -1, //-1 est la dernière colonne et 0 la première colonne
                            data: null,
                            defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:6px;"><i class="fas fa-edit"></i></button>  <button type="button" class="btn btn-danger btn-xs dt-delete"><i class="fas fa-trash"></i></button></div>'
                        },
                        { orderable: false, searchable: false, targets: -1 } 
                    ],
                });

                $("#example tfoot th").each(function() {
                    var title = $(this).text();
                    $(this).html('<input type="text" class="form-control" placeholder="' + title +'"/>');
                });

                table.columns().every(function(){
                    var that = this;
                    $('input', this.footer()).on('keyup change', function() {
                        if(that.search !== this.value){
                            that.search(this.value).draw();
                        }
                    })
                });

                /*
                $("#example tbody").on('click', '.dt-view', function(){
                    var data = table.row($(this).parents('tr')).data();
                    location.href = "/import/"+data.id+"/view"
                })

                $("#example").on('click', '.dt-download', function(){
                    var data = table.row($(this).parents('tr')).data();
                    location.href = "/import/"+data.id+"/download/"
                })

                $("#example").on('click', '.dt-delete', function(){
                    var data = table.row($(this).parents('tr')).data();
                    alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
                })*/

                

            }
        };
        xmlhttp.send();
    }

    $("#btnCancel").on('click', function(e) {
        $('form').trigger("reset");
    })

    datatable();

    $("form").on('submit', function(e){
        e.preventDefault();

        $.ajax({
            url: "/admin/compte/new",
            type: 'POST',
            method: 'POST',
            data: $("#formCompte").serialize(),
            beforeSend : function(){
                $('#formCompte').notify("Enregistrement en cours ...", {className: "info", position:"t c" });
                $("#btnSave").addClass('disabled')
                $("#btnCancel").addClass('disabled')
            },
            success: function(data) {
                //console.log(data.indexOf("succès"))
                if(data.indexOf("succès") >= 0) {
                    $('#formCompte').notify(data, {className: "success", position:"t c" }); 
                    $('form').trigger("reset"); 
                    $("#message").html("")
                    datatable();  
                } else {
                    $("#message").html(data)
                    $('#formCompte').notify("Erreur de validation!!", {className: "error", position:"t c" });
                }
                            
            }, error : function(error) {
                $('#formCompte').notify(error, {className: "error", position:"t c" });
            }, complete: function() {
                $("#btnSave").removeClass('disabled')
                $("#btnCancel").removeClass('disabled')
            }
        })
    })
})