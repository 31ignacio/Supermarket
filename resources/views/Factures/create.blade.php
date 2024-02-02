@extends('layouts.master2')

@section('content')
    <div class="container">

        <div class="callout callout-info">
            <div id="msg300"></div>

            <div class="row">

                <div class="col-md-3">

                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" id="date" class="form-control" style="width: 100%;border-radius:10px;">
                    </div><!-- /input-group -->
                </div>

                <div class="col-md-3">

                    <div class="form-group">
                        <label>Clients</label>
                        <input type="text" id="client" class="form-control" style="width: 100%;border-radius:10px;">

                    </div><!-- /input-group -->
                </div>


                <div class="col-md-3">
                    <div class="form-group">
                        <label>Produit type</label>
                        <select class="form-control" id="produitType" style="width: 100%;border-radius:10px;">
                            <option></option>
                            @foreach ($produitTypes as $produitType)
                                <option value="{{ $produitType->id }}">{{ $produitType->produitType }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>



            <form id="monFormulaire">
                <div id="msg25"></div>
                <div class="row">


                    <div class="mb-3 col-md-3">
                        <label for="produit">Produits</label>
                        <select class="form-control select2" id="produit" style="width: 100%;border-radius:10px;">
                            <option></option>
                            @foreach ($produits as $produit)
                                <option value="{{ $produit->libelle }}" data-produitType="{{ $produit->produitType_id }}"
                                    data-prix="{{ $produit->prix }}" data-stock="{{ $produit->stock_actuel }}">
                                    {{ $produit->libelle }}
                                </option>
                            @endforeach
                        </select>


                    </div>

                    <div id="message" style="color: red;"></div>

                    <br>

                    <div class="mb-3 col-md-2">

                        <!-- /btn-group -->
                        <label for="quantite">Quantité</label>
                        <input type="number" value="0" min=0 class="form-control" id='quantite'
                            style="width: 100%;border-radius:10px;">

                    </div>
                    <br><br><br>


                    <div class="mb-3 col-md-2">
                        {{-- <div class="input-group-prepend">
                            <button type="button" class="btn-sm btn-info">TVA(%)</button>
                        </div> --}}
                        <!-- /btn-group -->
                        <label for="tva">TVA(%)</label>
                        <input type="number" min=0 class="form-control" id='tva'
                            style="width: 100%;border-radius:10px;">
                    </div>
                    <br>

                    <div class="mb-5 col-md-4">
                        <button type="button" class="btn  btn-info" style="margin-top:30px;" onclick="ajouterAuTableau()"
                            title="ajouter"><i class="fas fa-plus"></i>Ajouter</button>
                        <button type="button" class="btn  btn-danger" style="margin-top:30px;"
                            onclick="supprimerDerniereLigne()" title="annuler"><i class="fas fa-times"></i>Annuler</button>

                    </div><br>

                </div>

                <div class="row">

                </div>
                <!-- /.row -->
            </form>


        </div>


        <!-- Main content -->
        <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
                <div class="col-12">

                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->

            <!-- Table row -->
            <div class="row">
                {{-- <div class="col-md-2"></div> --}}
                <div class="col-12 table-responsive">
                    <table class="table table-striped" id="monTableau">
                        <thead>
                            <tr>
                                <th>Quantité</th>
                                <th>Produit</th>
                                <th>Prix</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody id="monTableauBody">
                            <!-- Les lignes de tableau seront ajoutées ici -->
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-6">

                </div>
                <!-- /.col -->
                <div class="col-sm-12 col-md-6">
                    {{-- <p class="lead">Amount Due 2/22/2014</p> --}}

                    <div class="table-responsive">
                        <table class="table table-responsive">

                            <tr>
                                <th style="width:50%">Total HT:</th>
                                <td id="totalHT">0</td>
                            </tr>
                            <tr>
                                <th>Total TVA</th>
                                <td id="totalTVA">0</td>
                            </tr>
                            <tr>
                                <th>Total TTC</th>
                                <td id="totalTTC" class="right badge-md badge-info">0</td>
                            </tr>
                            <tr>
                                <th>Montant perçu</th>
                                <td class="d-flex">
                                    <input type="text" class="form-control mr-2" id="montantPaye" required
                                        oninput="ajouterValider()">
                                    {{-- <a href="#" class="btn btn-sm btn-success"><i class="fas fa-check"></i></a> --}}
                                </td>

                            </tr>
                            <tr>
                                <th>Reliquat</th>
                                <td><input type="text" class="form-control" id="montantRendu" required
                                        style="background-color: rgb(246, 222, 4)" disabled></td>

                            </tr>
                            <tr>
                                <th>Remise(%) </th>
                                <td><input type="text" class="form-control" id="remise" required
                                        oninput="ajouterValider()"></td>

                            </tr>
                            <tr>
                                <th>Montant payé</th>
                                <td class="d-flex">
                                    <input type="text" class="form-control mr-2" id="montantFinal"
                                        style="background-color: rgb(4, 246, 4)" required disabled>
                                    {{-- <button type="button" class="btn btn-sm btn-success"  title="valider"><i class="fas fa-check"></i></button>    --}}


                                </td>

                            </tr>

                        </table>
                        <div id="msg30"></div>

                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-12">
                   

                    <button type="button" class="btn btn-info float-right valider"
                        style="margin-right: 5px;"onclick="enregistrerDonnees()">
                        <i class="fas fa-download"></i> Valider
                    </button>

                </div>
            </div>
        </div>
        <!-- /.invoice -->
        <div id="msg200"></div>

    </div>
    <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

    {{-- Ajouter produit dans le tableau --}}
    <script>
        function ajouterAuTableau() {
            // Récupérer les valeurs du formulaire
            //var quantite = document.getElementById("quantite").value;
            //var quantite = parseFloat(document.getElementById("quantite").value);
            var quantite = document.getElementById("quantite").value;
            // var produit = document.getElementById("produit").value;
            // var selectProduit = $('#produit');
            //alert(quantite);
            var produit = document.getElementById("produit").value;
            //var prix = $("option:selected", this).data("prix");
            // Sélectionnez l'élément de liste déroulante par son ID
            var selectProduit = $('#produit');

            // Récupérez la valeur du prix de l'option sélectionnée lors du chargement de la page
            var prix = $('option:selected', selectProduit).data('prix');

            //alert(prix)

            if (quantite.trim() === "" || isNaN(parseFloat(quantite)) || produit.trim() === "") {
        // Ajoutez ici le code pour afficher un message d'erreur ou faites une action appropriée
        $('#msg25').html(`<p class="text-danger">
                            <strong>Veuillez remplir tous les champs (quantité, produit) avec des valeurs valides.</strong>
                        </p>`);
        // Masquer le message après 3 secondes
        setTimeout(function() {
            $('#msg25').html('');
        }, 5000); // 5000 millisecondes équivalent à 5 secondes
        } else {

                    // Calculer le total en multipliant la quantité par le prix
                    var total = quantite * prix;

                    // Sélectionner le tableau
                    var tableauBody = document.getElementById("monTableauBody");

                    // Créer une nouvelle ligne dans le tableau
                    var newRow = tableauBody.insertRow(tableauBody.rows.length);

                    // Insérer les cellules avec les valeurs du formulaire
                    var cell1 = newRow.insertCell(0);
                    var cell2 = newRow.insertCell(1);
                    var cell3 = newRow.insertCell(2);
                    var cell4 = newRow.insertCell(3);

                    cell1.innerHTML = quantite;
                    cell2.innerHTML = produit;
                    cell3.innerHTML = prix;
                    cell4.innerHTML = total.toFixed(); // Afficher le total avec deux décimales




                    // Mettre à jour le total HT
                    mettreAJourTotalHT();

                    // Réinitialiser le formulaire
                    //document.getElementById("monFormulaire").reset();

                    // Vider les champs sauf TVA
                    document.getElementById("quantite").value = "";
                    // document.getElementById("produit").value = "";
                    document.getElementById("prix").value = "";

                    // Restaurer la valeur de TVA
                    //document.getElementById("tva").value = tva;
                }
            }

            function mettreAJourTotalHT() {
                // Sélectionner le tableau
                var tva = document.getElementById("tva").value;
                //var montantPaye = parseFloat(document.getElementById("montantPaye").value);

                var tableauBody = document.getElementById("monTableauBody");
                var totalHT = 0;

                for (var i = 0; i < tableauBody.rows.length; i++) {
                    var cell = tableauBody.rows[i].cells[3]; // 4ème cellule contenant le total
                    totalHT += parseFloat(cell.innerHTML);
                }
                totalTVA = (totalHT * tva) / 100
                totalTTC = (totalHT + totalTVA)
                // Afficher le total HT mis à jour dans la cellule correspondante
                document.getElementById("totalHT").innerHTML = totalHT.toFixed(); // Afficher le total avec deux décimales
                document.getElementById("totalTVA").innerHTML = totalTVA.toFixed(); // Afficher le total avec deux décimales
                document.getElementById("totalTTC").innerHTML = totalTTC.toFixed(); // Afficher le total avec deux décimales
                //document.getElementById("montantRendu").innerHTML = montantRendu.toFixed();  // Utilisez toFixed pour formater en nombre à virgule fixe

            }


            function supprimerDerniereLigne() {
                // Sélectionner le tableau
                var tableauBody = document.getElementById("monTableauBody");

                // Vérifier s'il y a des lignes dans le tableau
                if (tableauBody.rows.length > 0) {
                    // Supprimer la dernière ligne
                    tableauBody.deleteRow(tableauBody.rows.length - 1);
                    // Mettre à jour le total HT
                    mettreAJourTotalHT();
                }
            }
    </script>

    {{-- Valider pour montant final --}}
    <script>
        function ajouterValider() {
            // Récupérer les valeurs du formulaire
            //var quantite = document.getElementById("quantite").value;
            var montantPercu = parseFloat(document.getElementById("montantPaye").value);
            var remise = document.getElementById("remise").value;
            //alert(remise)

            var totalTTC = document.getElementById('totalTTC').innerText;

            //alert(totalTTC)
            var montantRendu = 0;

            if (montantPercu === "" || totalTTC === 0) {
                // Ajoutez ici le code pour afficher un message d'erreur ou faites une action appropriée
                $('#msg30').html(` <p  class="text-danger">
                        <strong>Veuillez remplir tous les champs.</strong>
                                    </p>`);
                // Masquer le message après 3 secondes
                setTimeout(function() {
                    $('#msg30').html('');
                }, 5000); // 3000 millisecondes équivalent à 3 secondes
            } else {

                // Calculer le total en multipliant la quantité par le prix
                if (isNaN(remise)) {
                    // Si la remise n'est pas un nombre, utilisez le totalTTC directement
                    var montantFinal = totalTTC;
                } else {
                    // Si la remise est un nombre, calculez le montant final en appliquant la remise
                    var montantFinal = totalTTC - (totalTTC * remise) / 100;
                }

                var montantRendu = montantPercu - montantFinal;

                document.getElementById("montantFinal").value = montantFinal
                    .toFixed(); // Afficher le total avec deux décimales

                //alert(montantRendu)
                document.getElementById("montantRendu").value = montantRendu
                    .toFixed(); // Afficher le total avec deux décimales

            }
        }
    </script>


    {{-- Enregistrer une facture --}}
    <script>
        function enregistrerDonnees(donnees,button) {
            // Récupérer toutes les lignes du tableau
            var tableauBody = document.getElementById("monTableauBody");
            var date = document.getElementById("date").value;
            var client = document.getElementById("client").value;
            var totalHT = document.getElementById("totalHT").textContent;
            var totalTVA = document.getElementById("totalTVA").textContent;
            var totalTTC = document.getElementById("totalTTC").textContent;
            var montantPaye = document.getElementById("montantPaye").value;
            var produitType = document.getElementById("produitType").value;
            var remise = document.getElementById("remise").value;
            var montantFinal = document.getElementById("montantFinal").value;
          //  alert(montantPaye)
            //alert(totalTTC)

            if (produitType === "") {
                $('#msg30').html(`
        <p class="text-danger">
            <strong>Veuillez remplir tous les champs obligatoires.</strong>
        </p>`);

                // Masquer le message après 3 secondes
                setTimeout(function() {
                    $('#msg30').html('');
                }, 3000);

        //        if (montantPaye < totalTTC) {
        // // Afficher un message d'erreur si le montant payé est inférieur au total TTC
        // $('#msg30').html(`
        //     <p class="text-danger">
        //         <strong>Le montant perçu ne peut pas être inférieur au total TTC.</strong>
        //     </p>`
        // );

        // // Effacer le contenu des champs montantPaye et montantRendu après 5 secondes
        // setTimeout(function() {
        //     $('#montantPaye, #montantRendu').val('');
        //     $('#msg30').html('');
        // }, 5000);

        } else if (montantPaye === "") {
            // Afficher un message d'erreur si le montant payé est vide
            $('#msg30').html(`
                <p class="text-danger">
                    <strong>Le montant perçu est vide.</strong>
                </p>`
            );

            // Masquer le message après 3 secondes
            setTimeout(function() {
                $('#msg30').html('');
            }, 3000);
        }else {

                var donnees = [];

                for (var i = 0; i < tableauBody.rows.length; i++) {
                    var ligne = tableauBody.rows[i];
                    var quantite = ligne.cells[0].textContent;
                    var produit = ligne.cells[1].textContent;
                    var prix = ligne.cells[2].textContent;
                    var total = ligne.cells[3].textContent;
                    //alert(totalHT)
                    donnees.push({
                        quantite: quantite,
                        produit: produit,
                        prix: prix,
                        total: total
                    });

                }
                $('.valider').hide();

                // Envoyer les données au serveur via une requête AJAX
                $.ajax({

                    type: "POST",
                    url: "{{ route('facture.store') }}", // L'URL de votre route Laravel
                    data: {
                        _token: '{{ csrf_token() }}',
                        donnees: JSON.stringify(donnees),
                        client,
                        date,
                        totalTTC,
                        totalHT,
                        totalTVA,
                        montantPaye,
                        produitType,
                        remise,
                        montantFinal
                    },
                    success: function(response) {
                        var routeURL =
                            "http://127.0.0.1:8000/facture"; // Remplacez ceci par l'URL réelle de la route

                        Toastify({
                            text: "Félicitations, la facture a été enregistrée avec succès !",
                            duration: 5000,
                            close: true,
                            gravity: "top", // Position du toast
                            backgroundColor: "#4CAF50", // Fond vert
                            className: "your-custom-class", // Classe CSS personnalisée
                            stopOnFocus: true, // Arrêter le temps lorsque le toast est en focus
                            onClose: function() {
                                window.location.href = routeURL;
                            }

                        }).showToast();

                        var url = "{{ route('facture.index') }}"
                        setTimeout(function() {
                            window.location = url
                        }, 3000)




                    },

                });
            }
        }
    </script>

    {{-- verifier le stock --}}
    <script>
        var quantiteInput = document.getElementById("quantite");
        var produitSelect = document.getElementById("produit");
        var message = document.getElementById("message");
        var previousValue = quantiteInput.value;
        var previousSelectedIndex = produitSelect.selectedIndex;

        quantiteInput.addEventListener("input", function() {
            validateQuantite();
        });

        produitSelect.addEventListener("change", function() {
            validateQuantite();
        });

        function validateQuantite() {
            var selectedOption = produitSelect.options[produitSelect.selectedIndex];
            var stock = parseFloat(selectedOption.getAttribute("data-stock"));
            var quantite = parseFloat(quantiteInput.value);

            if (isNaN(quantite) || isNaN(stock) || quantite <= stock) {
                message.textContent = "";
                quantiteInput.style.borderColor = "";
            } else {
                message.textContent = "Stock insuffisant!";
                quantiteInput.style.borderColor = "red";

                // Efface le champ de quantité après 3 secondes
                setTimeout(function() {
                    quantiteInput.value = "";
                }, 3000);
            }

            // Vérifiez si l'utilisateur a changé de produit
            if (produitSelect.selectedIndex !== previousSelectedIndex) {
                quantiteInput.value = "";
                previousSelectedIndex = produitSelect.selectedIndex;
            }

            // Vérifiez si la quantité a été modifiée manuellement
            if (quantiteInput.value !== previousValue) {
                previousSelectedIndex = produitSelect.selectedIndex;
            }
        }


        // Vous pouvez appeler validateQuantite() au chargement de la page pour vérifier la quantité initiale
        validateQuantite();
    </script>

    {{-- Control sur la date --}}
    <script>
        // Récupérer la date d'aujourd'hui
        var dateActuelle = new Date();
        var annee = dateActuelle.getFullYear();
        var mois = ('0' + (dateActuelle.getMonth() + 1)).slice(-2);
        var jour = ('0' + dateActuelle.getDate()).slice(-2);

        // Formater la date pour l'attribut value de l'input
        var dateAujourdhui = annee + '-' + mois + '-' + jour;

        // Définir la valeur et la propriété min de l'input
        var inputDate = document.getElementById('date');
        inputDate.value = dateAujourdhui;
        inputDate.min = dateAujourdhui;
    </script>

    <!-- JavaScript pour la mise à jour dynamique (Produit type et produit) -->
    <script>
        // Fonction pour mettre à jour la liste des produits en fonction du Produit Type sélectionné
        function updateProduits() {
            var produitTypeSelect = document.getElementById('produitType');
            //alert(produitTypeSelect)
            var produitsSelect = document.getElementById('produit');

            // Obtient la valeur sélectionnée du Produit Type
            var selectedProduitType = produitTypeSelect.value;

            // Efface les options précédentes
            produitsSelect.innerHTML = '<option></option>';

            // Filtrage des produits en fonction du Produit Type sélectionné
            @foreach ($produits as $produit)
                if ("{{ $produit->produitType_id }}" == selectedProduitType) {
                    var option = document.createElement('option');
                    option.value = "{{ $produit->libelle }}";
                    option.setAttribute('data-prix', "{{ $produit->prix }}");
                    option.textContent = "{{ $produit->libelle }}";
                    produitsSelect.appendChild(option);
                }
            @endforeach
        }

        // Ajoute un écouteur d'événements pour détecter les changements dans le Produit Type
        document.getElementById('produitType').addEventListener('change', updateProduits);

        // Appelle la fonction updateProduits initialement pour configurer la liste des produits
        updateProduits();
    </script>
@endsection
