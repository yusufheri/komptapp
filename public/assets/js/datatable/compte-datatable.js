$(document).ready(function(){

    function datatable(){
        $('#datatable').notify("Chargement des données en cours ...", {className: "info", position:"center" });
        var baseurl = "/admin/compte/api";
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.open("GET",baseurl,true);
        xmlhttp.onreadystatechange = function(){
            if(xmlhttp.readyState==4 && xmlhttp.status ==200){
                var data = JSON.parse(xmlhttp.responseText);
                $("#count").html(data.length)
                console.log(data)
                /*
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
                    responsive: true,
                    autoFill: true,
                    data:data,
                    "columns":[
                        {"title": "", "data": null, defaultContent: '' }, 
                        {"title": "Id", "data":"id" , "visible":false},
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
                            defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:6px;"><i class="fas fa-eye"></i></button>  <button type="button" class="btn btn-primary btn-xs dt-download" style="margin-right:6px;"><i class="fas fa-download"></i></button><button type="button" class="btn btn-danger btn-xs dt-delete"><i class="fas fa-trash"></i></button></div>'
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
                });*/

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

                

            } else{
                console.error("Error")
            }
        };
        xmlhttp.send();
    }
        
    
});