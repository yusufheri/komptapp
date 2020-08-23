$(document).ready(function(){

    number_format = function (number, decimals, dec_point, thousands_sep) {
        number = number.toFixed(decimals);

        var nstr = number.toString();
        nstr += '';
        x = nstr.split('.');
        x1 = x[0];
        x2 = x.length > 1 ? dec_point + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(x1))
            x1 = x1.replace(rgx, '$1' + thousands_sep + '$2');

        return x1 + x2;
    }

    var baseurl = "/api/import/datatable";
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
                    $('td', row).eq(6).addClass('important  text-right')
                    $('td', row).eq(6).addClass('highlight');            
                },
                "columns":[
                    {title: "", "data": null, defaultContent: '' }, 
                    {"title":"Id", "data":"id" , "visible":false},
                    {"title":"Période",  "data":null, render: function(data, type, row){
                        return "<b>Du " + moment(row.fromAt).format('DD-MM-YYYY') + " au " +moment(row.toAt).format('DD-MM-YYYY')+"</b>";
                    }
                    },
                    {"title":"Nom du fichier", "data":null, render: function(data, type, row){
                        return '<a href="/import/'+ row.id +'/view">' + row.filename +'</a>';
                    }},
                    {"title":"Taille", "data":null, render: function(data, type, row) {
                        var val=  row.filesize / Math.pow(1024,2);
                        return val.toFixed(2) + " Mo";
                    }},
                    {"title":"Solde", "data":null, render: function(data, type, row) {
                        var somme_cdf = 0;
                        var  somme_usd = 0;
                        var somme_autre = 0;
                        var devise = ""
                        //console.log(row.detailImports)
                        row.detailImports.forEach(obj => {
                            devise = obj.devise.toString().toUpperCase();
                            if ( devise== "CDF"){
                                somme_cdf += obj.montant;
                            } else if (devise == "USD"){
                                somme_usd += obj.montant;
                            } else {
                                somme_autre += obj.montant;
                            }
                        });
                        var message = ""
                        message = (somme_cdf == 0 )?"": number_format(somme_cdf,2,',',' ') + " CDF ";
                        message += (somme_usd == 0 )?"": ((message == "")?"": " + ")  + number_format(somme_usd,2,',',' ') + " USD "; 
                        
                        return  '<center><b>'+message+'</b></center>' ;
                    }},
                    {"title":"Etat", "data":null, render: function (data, type, row){
                        var success, error;
                        success = 0; error = 0;
                        row.detailImports.forEach(obj => {
                            if(obj.error == true) {error ++;}
                            else success ++;
                        })
                        var pourcent =parseInt((success * 100)/ (success + error));
                        return '<div class="progress">  <div class="progress-bar'+ ((pourcent == 100)?' progress-bar-success':(pourcent < 50)?' progress-bar-danger':' progress-bar-warning') +'  progress-bar-striped active" role="progressbar" style="width:'+ pourcent +'%;" aria-valuenow="'+pourcent+'" aria-valuemin="0" aria-valuemax="100"><span class="sr-only">'+ pourcent +' %</span></div></div>'
                    }},
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
            });

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
            })

            

        }
    };
    xmlhttp.send();
    
        
    
});