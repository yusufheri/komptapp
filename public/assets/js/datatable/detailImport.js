$(document).ready(function(){
    var url = window.location.href.split('/')
    var id = url[url.length-2];
    var baseurl = "/api/import/"+id+"/datatable";
    var xmlhttp = new XMLHttpRequest();

    xmlhttp.open("GET",baseurl,true);
    xmlhttp.onreadystatechange = function(){
        if(xmlhttp.readyState==4 && xmlhttp.status ==200){
            var data = JSON.parse(xmlhttp.responseText);
            $("#count").html(data.length)
            //console.log(data)
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
                "createdRow": function( row, data, dataIndex ) {
                    if(data.error == true) {
                        $(row).addClass( 'text-danger' );
                    }
                    /*var amount = data.montant;
                    if (amount  < 350000) { //amount.replace(/[\$,]/g, '') * 1 
                        $('td', row).eq(6).addClass('text-danger text-center');     
                    } else {
                        $('td', row).eq(6).addClass('important  text-center')                            
                    }*/
                    $('td', row).eq(6).addClass('important  text-right')
                    $('td', row).eq(6).addClass('highlight');            
                },
                "columns":[
                    {title: "", "data": null, defaultContent: '' }, 
                    {"title":"Id", "data":"id" , "visible":false},
                    {"title":"Date", format: 'dd/mm/yyyy', "data":null, render: function(data, type, row){
                        return moment(row.datePaid).format('DD-MM-YYYY');
                    }
                    },
                    {"title":"ID_Bank", "data":"event_no"},
                    {"title":"Motif", "data":"motif"},
                    {"title":"Noms", "data":"name"},
                    {"title":"Section", "data":null, render: function(data, type, row) {
                        return row.promotion + ' ' + row.section ; }
                    },
                    {"title":"Montant", "data":null, render: function ( data, type, row ) {
                        return '<b>' + row.montant + ' ' + row.devise + '</b>';} 
                    },
                    {"title": "Action", "data": null}
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
                        defaultContent: '<div class="btn-group"> <button type="button" class="btn btn-info btn-xs dt-view" style="margin-right:6px;"><i class="fas fa-eye"></i></button>  <button type="button" class="btn btn-primary btn-xs dt-edit" style="margin-right:6px;"><i class="fas fa-edit"></i></button><button type="button" class="btn btn-danger btn-xs dt-delete"><i class="fas fa-trash"></i></button></div>'
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

            $("#example tbody").on('click', '.dt-view', function(){
                var data = table.row($(this).parents('tr')).data();
                alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
            })

            $("#example").on('click', '.dt-edit', function(){
                var data = table.row($(this).parents('tr')).data();
                alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
            })

            $("#example").on('click', '.dt-delete', function(){
                var data = table.row($(this).parents('tr')).data();
                alert(data.id + " est l'id de la ligne sélectionnée de la personne " + data.name);
            })
            //table.buttons().container().appendTo( $('.col-sm-3:eq(0)', table.table().container() ) );

            /*$('#example tbody').on( 'mouseenter', 'td', function () {
                var colIdx = table.cell(this).index().column;
    
                $( table.cells().nodes() ).removeClass( 'highlight' );
                $( table.column( colIdx ).nodes() ).addClass( 'highlight' );
            } );
            */
            

        }
    };
    xmlhttp.send();
    
        
    
});