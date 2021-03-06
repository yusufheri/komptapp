

$(document).ready(function(){  
    
    
    function datatable(url = "/admin/rubriques/api"){
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
                        {"title": "Libellé", "data": null, render: function(data, type, row) {
                            return '<span class="text-primary">' + data.name + '</span>';
                        }},
                        {"title": "Montant (restant à repartir)", "data": null, render: function(data, type, row) {
                            //console.log(data.enyDetailRubriques);
                            
                            let taille = data.enyDetailRubriques.length-1;
                            let amount = 0 ; let reste = null ;
                            if (taille > -1) {
                                
                                amount = data.enyDetailRubriques[taille].amount;
                                let repartion_comptes = 0;
                                let devise = data.enyDetailRubriques[taille].devise.name;
                                
                                row.enyRubriqueCpts.forEach(elt => {
                                    if(elt.deletedAt == null) repartion_comptes += elt.amount;
                                })

                                reste = amount - repartion_comptes;
                                
                                reste = reste.toFixed(2);
                                
                                amount = new Intl.NumberFormat("de-DE", {style: "currency", currency: devise.toString()}).format(amount)
                                reste = new Intl.NumberFormat("de-DE", {style: "currency", currency: devise.toString()}).format(reste)
                            
                            } else {
                                return '<span class="float-right"> </span>'
                            }                            
                        
                            if (reste == 0 || reste =="0,00 CDF") {
                                return '<span class="float-right"><b> '+ amount.toString() + '</b></span>'
                            } else {
                                return '<span class="float-right"><b> '+ amount.toString() +' (<span class="text-danger">'+ reste.toString() +'</span>)</b></span>'
                            }
                            
                            
                        }},
                        {"title": "Comptes", "data": null, render: function(data, type, row){
                            
                            let taille = data.enyDetailRubriques.length-1;
                            let repartion_comptes = 0;
                            let amount = 0;

                            if (taille >  -1 ) amount = data.enyDetailRubriques[taille].amount;

                            var count_rubriqueComptes = 0;
                            row.enyRubriqueCpts.forEach(elt => {
                                if(elt.deletedAt == null) {repartion_comptes += elt.amount;count_rubriqueComptes++;}
                            })
                            //return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s)</center>';
                            if (amount == repartion_comptes || repartion_comptes > amount){ 
                                //return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="viewComptes" class="btn red btn-outline btn-circle btn-xs btn2" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-eye"></i> </button><button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" disabled data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';                                
                                return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" disabled data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';                                
                            } else {
                                //return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="viewComptes" class="btn red btn-outline btn-circle btn-xs btn2" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-eye"></i> </button> <button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';
                                return '<center><b>'+ count_rubriqueComptes.toString() +'</b> cpt(s) <button id="addCompte" class="btn blue-bgcolor btn-outline btn-xs btn-circle btn1" data-toggle="modal"  data-id="'+ data.id +'"> <i class="fa fa-plus"></i> </button></center>';
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
                            defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-circle btn-xs dt-view" style="margin-right:6px;"><i class="fas fa-edit"></i> Voir plus</button></div>'
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
                        url:"/admin/rubriques/create_compte/"+id.toString() +"",
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
                            //$('.js-example-basic-single').select2();
                        }

                    })
                })

                
                $("#example").on('click', '.dt-view', function(){                    
                    
                    var data = table.row($(this).parents('tr')).data();
                    try {
                            window.location.href="/admin/rubriques/"+data.id.toString()+"/view"
                            console.log("success")
                            //console.log(data)
                    } catch (error) {
                        console.error("error")
                        //console.log(data)
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

    datatable();    
    
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