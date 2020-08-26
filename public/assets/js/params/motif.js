
$(document).ready(function(){  
    
    function datatable(url = "/admin/motif/api"){
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
                            return "<center>" + moment(row.createdAt).format('DD-MM-YYYY H:m').toString() + "</center>"
                        }},
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
                            defaultContent: '<center> <div class="btn-group"><button type="button" class="btn btn-info btn-xs dt-edit" style="margin-right:6px;"><i class="fas fa-edit"></i></button>  <button type="button" class="btn btn-danger btn-xs dt-delete" ><i class="fas fa-trash"></i></button></div></center>'
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
                
                $("#example").on('click', '.dt-edit', function(){
                    var data = table.row($(this).parents('tr')).data();
                    try {
                        console.log("Début du proccess..")
                        $.ajax({
                            url:"/admin/motif/"+ data.id.toString() +"/edit_form_motif",
                            method:"POST",
                            type:"POST",
                            beforeSend:function(){
                                $(".modalCompte").html("<center><h2>Chargement en cours...</h2></center>")
                                $("#FormCompte").modal('show')
                            },
                            success: function(data){                           
                                $(".modalCompte").html(data)                            
                            }, error: function(error){
                                $(".modalCompte").html(error)
                            }, complete:function(){
                                $("#header").html("<header>Modification du <b>Motif</b></header>")
                                $("#btnSave").html('<i class="fa fa-check"></i> Modifier')
                            }
                
                        })
                    } catch (error) {
                        //console.error("error")
                    }
                    finally{
                        //console.log("finally")
                    }                   
                })

                $("#example").on('click', '.dt-delete', function(e){
                    e.preventDefault();
                    var data = table.row($(this).parents('tr')).data();
                    try {
                        if (confirm('Voulez-vous supprimer ce motif ?')) 
                        {
                            $.ajax({
                                method:"POST",
                                type:"POST",
                                url:"/admin/motif/"+data.id.toString() + "/delete",
                                beforeSend: function(){
                                    $('#example').notify("Suppression en cours...", {className: "info", position:"t c" });
                                    //button.fadeOut(3000).fadeIn(3000);
                                }, success: function(data) {
                                    //console.log(data)
                                    $('#example').notify("Suppression réussie avec succès...", {className: "success", position:"t c" });
                                    //location.reload()
                                    datatable()
                                }, error: function(error){
                                    console.error(error);
                                }
        
                            })
                        } else {
                            $('#example').notify("Suppression annulée avec succès...", {className: "info", position:"t c" });
                        }
                        
                    } catch (error) {
                        //console.error("error")
                    }
                    finally{
                        //console.log("finally")
                    }
                })



            }
        };
        xmlhttp.send();
    }

    datatable();

    $("#FormCompte").on("click","#btnCancel", function() {
        $("#FormCompte").modal('hide')
    })

    $("#addCpte").on('click', function(){
        $.ajax({
            url:"/admin/motif/create_form",
            method:"POST",
            type:"POST",
            beforeSend:function(){
                $(".modalCompte").html("<center><h2>Chargement en cours...</h2></center>")
                $("#FormCompte").modal('show')
            },
            success: function(data){
                $(".modalCompte").html(data)
            }, error: function(error){
                $(".modalCompte").html(error)
            }, complete:function(){
                $('.js-example-basic-single').select2();
            }

        })
    })

    $("#FormCompte").on('submit','form', function(e){
        e.preventDefault();
        var type = $(this).attr('id');
        var id = $("input[name='id']").val();
        var url = (type == "create")?"/admin/motif/new":"/admin/motif/"+ id.toString() +"/edit"
        $.ajax({
            url: url,
            type: 'POST',
            method: 'POST',
            data: $("form[name='eny_motif']").serialize(),
            beforeSend : function(){
                $('#FormCompte').notify("Enregistrement en cours ...", {className: "info", position:"t c" });
                $("#btnSave").addClass('disabled')
                $("#btnCancel").addClass('disabled')
            },
            success: function(data) {
                //console.log(data.indexOf("succès"))
                if(data.indexOf("succès") >= 0) {
                    $('#infoBox').notify(data, {className: "success", position:"t c" }); 
                    $("form[name='eny_compte']").trigger("reset"); 
                    $("#message").html("")
                    datatable();  
                } else {
                    $("#message").html(data)
                    $('#infoBox').notify("Erreur de validation!!", {className: "error", position:"t c" });
                }
                            
            }, error : function(error) {
                //console.error(error.responseText);
                $('#infoBox').notify("Une erreur est survenue lors de la création du motif " , {className: "error", position:"t c" });
            }, complete: function() {
                $("#btnSave").removeClass('disabled')
                $("#btnCancel").removeClass('disabled')
                if (type == "edit") { $("#FormCompte").modal('hide') }
            }
        })
    })
})