

$(document).ready(function(){  
    
    
    function datatable(url = "/admin/rubrique/api"){
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
                        {"title": "Créée", "data": null, render: function(data, type, row) {
                            return moment(row.createdAt).format('DD-MM-YYYY')
                        }},
                        {"title": "Code", "data": "code"},
                        {"title": "Libellé", "data": "name"},
                        {"title": "Montant", "data": null, render: function(data, type, row) {
                            //console.log(data.detailRubriques.length);
                            let taille = data.detailRubriques.length-1;
                            let repartion_comptes = 0;
                            let amount = data.detailRubriques[taille].amount;
                            let devise = data.detailRubriques[taille].devise.name;

                            row.rubriqueComptes.forEach(elt => {
                                if(elt.deletedAt == null) repartion_comptes += elt.amount;
                            })
                            let reste = amount - repartion_comptes;
                            
                            reste = reste.toFixed(2);

                            amount = new Intl.NumberFormat("de-DE", {style: "currency", currency: devise.toString()}).format(amount)
                            reste = new Intl.NumberFormat("de-DE", {style: "currency", currency: devise.toString()}).format(reste)

                            
                            if (reste == 0 || reste =="0,00 CDF") {
                                return '<span class="float-right"><b> '+ amount.toString() + '</b></span>'
                            } else {
                                return '<span class="float-right"><b> '+ amount.toString() +' (<span class="text-danger">'+ reste.toString() +'</span>)</b></span>'
                                //return '<span class="float-right"><b> '+ amount.toString() + " " + devise.toString()+' </b></span>'
                            }
                            
                        }},
                        {"title": "Comptes", "data": null, render: function(data, type, row){
                            let taille = data.detailRubriques.length-1;
                            let repartion_comptes = 0;
                            let amount = data.detailRubriques[taille].amount;
                            var count_rubriqueComptes = 0;
                            row.rubriqueComptes.forEach(elt => {
                                console.log(elt.deletedAt)
                                if(elt.deletedAt == null) {repartion_comptes += elt.amount;count_rubriqueComptes++;}
                            })
                            if (amount == repartion_comptes || repartion_comptes > amount){ 
                                return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="viewComptes" class="btn red btn-outline btn-circle btn-xs btn2" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-eye"></i> </button><button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" disabled data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';
                            } else {
                                return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="viewComptes" class="btn red btn-outline btn-circle btn-xs btn2" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-eye"></i> </button> <button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';
                            }
                            
                        }},
                        //{"title": "Description", "data": "content"},
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
                            defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-circle btn-xs dt-view" style="margin-right:6px;"><i class="fas fa-edit"></i> Edition</button></div>'
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
                
                $("#example").on('click', '#addCompte', function(){   
                    var id = $(this).data("id");
                    $.ajax({
                        url:"/admin/rubrique/create_compte/"+id.toString() +"",
                        method:"POST",
                        type:"POST",
                        beforeSend:function(){
                            $(".modalCenter2").html("<center><h2>Chargement en cours...</h2></center>")
                            $("#exampleModalCenter2").modal('show')
                        },
                        success: function(data){
                            $(".modalCenter2").html(data)
                        }, error: function(error){
                            $(".modalCenter2").html(error)
                        }, complete:function(){
                            $('.js-example-basic-single').select2();
                        }

                    })
                })

                $("#example").on('click', '#viewComptes', function(e){
                    e.preventDefault();
                    var id = $(this).data("id");
                    $.ajax({
                        url:"/admin/rubrique/view_comptes/"+id.toString() +"",
                        method:"POST",
                        type:"POST",
                        beforeSend:function(){
                            $(".modalCenter3").html("<center><h2>Chargement en cours...</h2></center>")
                            $("#exampleModalCenter3").modal('show')
                        },
                        success: function(data){
                            $("#exampleModalLongTitleViewCompte").html("Liste des comptes")
                            $(".modalCenter3").html(data)
                            $("#exampleComptes").DataTable({
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
                            })
                        }, error: function(error){
                            $(".modalCenter3").html(error)
                        }, complete:function(){
                            $('.js-example-basic-single').select2();
                        }

                    })
                })

                /*
                    $("#example").on('click', '.dt-delete', function(){                                
                        var data = table.row($(this).parents('tr')).data();
                        //alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
                        $.ajax({
                            url:"/admin/rubrique/" + data.id.toString() + "/delete",
                            method:"DELETE",
                            beforeSend: function(){
                                $('#datatable').notify("Suppression en cours...", {className: "info", position:"t c" });
                            }, success: function(data){
                                $('#datatable').notify(data, {className: "success", position:"t c" });
                            }, error: function(error){
                                console.error(error);
                            }
                        })
                    })
                */

                $("#example").on('click', '.dt-view', function(){                    
                    
                    var data = table.row($(this).parents('tr')).data();
                    try {
                            window.location.href="/admin/rubrique/"+data.id.toString()+"/view"
                            console.log("success")
                            console.log(data)
                    } catch (error) {
                        console.error("error")
                        console.log(data)
                    }
                    finally{
                        console.log("finally")
                        console.log(data)
                    }
                    
                    //
                    //alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
                })

            }
        };
        xmlhttp.send();
    }

    $("#btnCancel").on('click', function(e) {
        $('form').trigger("reset");
    })

    $("#addRubrique").on('click', function(e){
        $.ajax({
            url:"/admin/rubrique/create_rubrique",
            beforeSend:function(){
                $(".modalCenter1").html('<center><h2><sapn class="fa fa-loading"></span> Chargement en cours...</h2></center>')
                $("#exampleModalCenter").modal('show')
            },
            success: function(data){
                $(".modalCenter1").html(data)
            }, error: function(error){
                $(".modalCenter1").html(error)
            }, complete:function(){
                $('.js-example-basic-multiple').select2();
                $('.js-example-basic-single').select2();
            }

        })
    })

    datatable();
    
    $(".modalCenter1").on('submit', 'form', function(e){
        e.preventDefault();

        $.ajax({
            url: "/admin/rubrique/new",
            type: 'POST',
            method: 'POST',
            data: $("#formRubrique").serialize(),
            beforeSend : function(){
                $('#formRubrique').notify("Enregistrement en cours ...", {className: "info", position:"t c" });
                $("#btnSave").addClass('disabled')
                $("#btnCancel").addClass('disabled')
            },
            success: function(data) {
                //console.log(data.indexOf("succès"))
                if(data.indexOf("succès") >= 0) {
                    $('#formRubrique').notify(data, {className: "success", position:"t c" }); 
                    $('form').trigger("reset");
                    //$('#exampleModalCenter').modal('hide')
                    datatable();  
                    $("#message").html("")
                } else {
                    $("#message").html(data)
                    $('#formRubrique').notify("Erreur de validation!!", {className: "error", position:"t c" });
                }
                            
            }, error : function(error) {
                $('#formRubrique').notify(error, {className: "error", position:"t c" });
            }, complete: function() {
                $("#btnSave").removeClass('disabled')
                $("#btnCancel").removeClass('disabled')
            }
        })
    })

    $(".modalCenter2").on('submit', 'form', function(e){
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            method: 'POST',
            data: $("#formRubriqueCompte").serialize(),
            beforeSend : function(){
                $('#formRubriqueCompte').notify("Enregistrement en cours ...", {className: "info", position:"t c" });
                $("#btnSave").addClass('disabled')
                $("#btnCancel").addClass('disabled')
            },
            success: function(data) {
                //console.log(data.indexOf("succès"))
                if(data.indexOf("succès") >= 0) {
                    $('#formRubriqueCompte').notify(data, {className: "success", position:"t c" }); 
                    $('form').trigger("reset");
                    //$('#exampleModalCenter').modal('hide')
                    datatable();  
                    $("#message").html("")
                } else {
                    $("#message").html(data)
                    $('#formRubriqueCompte').notify("Une exception s'est produite !!", {className: "error", position:"t r" });
                }
                            
            }, error : function(error) {
                $('#formRubriqueCompte').notify(error, {className: "error", position:"t c" });
            }, complete: function() {
                $("#btnSave").removeClass('disabled')
                $("#btnCancel").removeClass('disabled')
            }
        })
    })
})