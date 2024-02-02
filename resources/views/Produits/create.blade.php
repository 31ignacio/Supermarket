@extends('layouts.master2')

@section('content')
<div class="row">
    <div class="col-md-2"></div>
    <div class="col-md-8">
        @if (Session::get('success_message'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('success_message') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true" style="font-size: 30px;">&times;</span>
                </button>
            </div>
        @endif
    </div>
    <div class="col-md-2"></div>
</div>

    <div id="msg200"></div>

    <div class="row">
        <div class="col-md-3"></div>

        <div class="col-md-7">
        <div class="back">
            <div class="card-body">
                <div class="container-form">
                    <form id="signUpForm" method="POST" action="{{route('produit.store')}}" class="form">
                        @csrf
                        <input id="signature" type="hidden" name="person_signature" value="" />
                        <!-- start step indicators -->
                        <div class="form-header d-flex mb-4">
                            <span class="stepIndicator">Enregistrer</span>
                            <span class="stepIndicator">un produit</span>
                        </div>
                        <!-- end step indicators -->
                        <br><br>
                        <div id="msg200"></div>
                        <!-- step one -->
                        <div class="step">
                            <p class="text-center mb-4">Informations sur le produit</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="libelle" class="form-label">Produit</label>
                                    <input type="text" required="true" style="border-radius: 10px;"
                                        id="libelle" name="libelle" aria-describedby="libelle" required>
                                </div>
    
                                <div class="col-md-3">
                                    <label for="quantite" class="form-label">Quantité</label>
                                    <input type="text" required="true" style="border-radius: 10px;"
                                        id="quantite" name="quantite" value="{{ old('quantite') }}" required>
                                </div>

                                <div class="col-md-3">
                                    <label for="prix" class="form-label">Prix</label>
                                    <input type="number" required="true" style="border-radius: 10px;"
                                        id="prix" name="prix" value="{{ old('prix') }}" required>
                                </div>
                            </div>
                        
                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="ifu" class="form-label">Produit type</label>
                                    <select name="produitType" id="produitType" class="form-control" style="border-radius: 10px;">
                                        <option></option>

                                            @foreach ($produitTypes as $produitType )
                                                <option value="{{$produitType->id}}">{{$produitType->produitType}}</option>

                                            @endforeach
                                    </select>                            
                                </div>
    
    
                                <div class="mb-3 col-md-6">
                                    <label for="ifu" class="form-label">Fournisseurs</label>
                                    <select name="fournisseur" id="fournisseur" class="form-control" style="border-radius: 10px;">
                                            <option></option>
                                            @foreach ($fournisseurs as $fournisseur )
                                                <option value="{{$fournisseur->id}}">{{$fournisseur->nom}}</option>

                                            @endforeach
                                    </select>                            
                                </div>

                            </div>
    
                        
                        </div>
    
                        {{-- Deuxieme --}}
                        <!-- step two -->
                        <div class="step">
                            <p class="text-center mb-4">Informations sur le produit</p>


                            <div class="row">

                                <div class="mb-3 col-md-6">
                                    <label for="ifu" class="form-label">Catégories</label>
                                    <select name="categorie" id="categorie" class="form-control" style="border-radius: 10px;">
                                        <option></option>

                                            @foreach ($categories as $categorie )
                                                <option value="{{$categorie->id}}">{{$categorie->categorie}}</option>

                                            @endforeach
                                    </select>                            
                                </div>

                                <div class="mb-3 col-md-6">
                                    <label for="emplacement" class="form-label">Emplacement</label>
                                    <select name="emplacement" id="emplacement" class="form-control" style="border-radius: 10px;">
                                        <option></option>

                                            @foreach ($emplacements as $emplacement )
                                                <option value="{{$emplacement->id}}">{{$emplacement->nom}}</option>
                                            @endforeach
                                    </select>
                                </div>
    
    
                            </div>
    
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="dateReception" class="form-label">Date reception</label>
                                    <input type="date" class="form-control" required="true" id="dateReception" name="dateReception" value="{{old('dateReception')}}"
                                        style="border-radius: 10px;" required>
                                </div>
    
                                <div class="mb-3 col-md-6">
                                    <label for="dateExpiration" class="form-label">Date expiration</label>
                                    <input type="date" class="form-control" required="true" id="dateExpiration" name="dateExpiration" value="{{old('dateExpiration')}}"
                                        style="border-radius: 10px;" required>
                                </div>
    
                            </div>
    
    
                            <div class="row" hidden>
    
    
                            </div>
                        </div>
    
                        <!-- start previous / next buttons --><br>
                        <div class="form-footer d-flex">
                            <button style="font-size: 13px;"  type="button" id="prevBtn" onclick="nextPrev(-1)">Précédent</button>
                            <button style="font-size: 13px;"  type="button" id="nextBtn" onclick="nextPrev(1)">Suivant</button>
                        </div>
                        <!-- end previous / next buttons -->
                    </form>
                </div>
            </div>
        </div>

        </div>
    
        
        <!-- /.card -->
    </div>
    <div class="col-md-2"></div>

    </div>

 
    <style>
        #signUpForm {
            max-width: 650px;
            background-color: #ffffff;
            margin: 40px auto;
            padding: 40px;
            box-shadow: 0px 6px 18px rgb(0 0 0 / 9%);
            border-radius: 12px;
        }

        #signUpForm .form-header {
            gap: 5px;
            text-align: center;
            font-size: 12px;
        }

        #signUpForm .form-header .stepIndicator {
            position: relative;
            flex: 1;
            padding-bottom: 30px;
        }

        #signUpForm .form-header .stepIndicator.active {
            font-weight: 600;
        }

        #signUpForm .form-header .stepIndicator.finish {
            font-weight: 600;
            color: #144194;
        }

        #signUpForm .form-header .stepIndicator::before {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            z-index: 9;
            width: 20px;
            height: 20px;
            background-color: #d5efed;
            border-radius: 50%;
            border: 3px solid #ecf5f4;
        }

        #signUpForm .form-header .stepIndicator.active::before {
            background-color: #0d6efd;
            border: 3px solid #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::before {
            background-color: #0c5ae9;
            border: 3px solid #0d6efd;
        }

        #signUpForm .form-header .stepIndicator::after {
            content: "";
            position: absolute;
            left: 50%;
            bottom: 8px;
            width: 100%;
            height: 3px;
            background-color: #f3f3f3;
        }

        #signUpForm .form-header .stepIndicator.active::after {
            background-color: #89cfff;
        }

        #signUpForm .form-header .stepIndicator.finish::after {
            background-color: #0c5ae9;
        }

        #signUpForm .form-header .stepIndicator:last-child:after {
            display: none;
        }

        #signUpForm input {
            padding: 10px 15px;
            width: 100%;
            font-size: 1em;
            border: 1px solid #e3e3e3;
            border-radius: 5px;
        }

        #signUpForm input:focus {
            border: 1px solid #0d6efd;
            outline: 0;
        }

        #signUpForm input.invalid {
            border: 1px solid #dc3545;
        }

        #signUpForm .step {
            display: none;
        }

        #signUpForm .form-footer {
            overflow: auto;
            gap: 20px;
        }

        #signUpForm .form-footer button {
            background-color: #0dfd21;
            border: 1px solid #0dfd21 !important;
            color: #ffffff;
            border: none;
            padding: 13px 30px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            flex: 1;
            margin-top: 5px;
        }

        #signUpForm .form-footer button:hover {
            opacity: 0.8;
        }

        #signUpForm .form-footer #prevBtn {
            background-color: #fff;
            color: #0d6efd;
        }
    </style>

    <script>
        var currentTab = 0; // Current tab is set to be the first tab (0)
        showTab(currentTab); // Display the current tab
        const submit = document.getElementById("nextBtn");

        function showTab(n) {
            // This function will display the specified tab of the form...
            var x = document.getElementsByClassName("step");
            x[n].style.display = "block";
            //... and fix the Previous/Next buttons:
            if (n == 0) {
                document.getElementById("prevBtn").style.display = "none";
            } else {
                document.getElementById("prevBtn").style.display = "inline";
            }
            if (n == (x.length - 1)) {
                //
                document.getElementById("nextBtn").innerHTML = "Enregistrer";
                console.log("Last level");

            } else {
                document.getElementById("nextBtn").innerHTML = "Suivant";
            }
            if (n == x.length) {
                document.getElementById("nextBtn").type = "submit";
            }
            //... and run a function that will display the correct step indicator:
            fixStepIndicator(n)
        }

        function nextPrev(n) {
            // This function will figure out which tab to display
            var x = document.getElementsByClassName("step");
            // Exit the function if any field in the current tab is invalid:
            if (n == 1 && !validateForm()) return false;
            // Hide the current tab:
            x[currentTab].style.display = "none";
            // Increase or decrease the current tab by 1:
            currentTab = currentTab + n;
            // if you have reached the end of the form...
            if (currentTab >= x.length) {
                // ... the form gets submitted:
                document.getElementById("signUpForm").submit();
                return false;
            }
            // Otherwise, display the correct tab:
            showTab(currentTab);
        }

        function validateForm() {
            // This function deals with validation of the form fields
            var x, y, i, valid = true;
            x = document.getElementsByClassName("step");
            y = x[currentTab].getElementsByTagName("input");
            // A loop that checks every input field in the current tab:
            for (i = 0; i < y.length; i++) {
                // If a field is empty...
                if (y[i].value == "") {
                    // add an "invalid" class to the field:
                    y[i].className += " invalid";
                    // and set the current valid status to false
                    valid = false;
                }
            }
            // If the valid status is true, mark the step as finished and valid:
            if (valid) {
                document.getElementsByClassName("stepIndicator")[currentTab].className += " finish";
            }
            return valid; // return the valid status
        }

        function fixStepIndicator(n) {
            // This function removes the "active" class of all steps...
            var i, x = document.getElementsByClassName("stepIndicator");
            for (i = 0; i < x.length; i++) {
                x[i].className = x[i].className.replace(" active", "");
            }
            //... and adds the "active" class on the current step:
            x[n].className += " active";
        }
        $(() => {
            if (submit.innerHTML == "Enregistrer") {
                submit.type = "submit";
            }
        });
    </script>

    


    <script>
        function remboursse() {
            // $("#remboursementBtn").click(function() {
            // Récupérer l'ID du client depuis la page
            // var ref = $("#ref").val();
            var libelle = $("#libelle").val();
            var quantite = $("#quantite").val();
            var prix = $("#prix").val();

            var dateExpiration = $("#dateExpiration").val();
            var dateReception = $("#dateReception").val();
            var produitType = $("#produitType").val();
            var emplacement = $("#emplacement").val();
            var categorie = $("#categorie").val();
            var fournisseur = $("#fournisseur").val();

            //alert(ref)
            // Récupérer le jeton CSRF depuis la balise meta
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
            $.ajax({
                type: 'POST',
                url: "{{ route('produit.store') }}", // Remplacez "/votre-route" par la route pertinente de votre application
                data: {
                    _token: csrfToken,

                    categorie,emplacement,fournisseur,produitType,dateExpiration,dateReception,
                    libelle,prix,
                    quantite
                },
                success: function(response) {
                    // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                    if (parseInt(response) == 200 || parseInt(response) == 500) {

                        parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> Produit ajouté avec succès  </strong>

                            </div>`));
                    }

                    var url = "{{ route('produit.index') }}"
                    if (response == 200) {
                        setTimeout(function() {
                            window.location = url
                        }, 1000)
                    } else {
                        $("#msg200").html(response);

                    }
                },

            });
            // });
        };
    </script>

    <script>
        // Recherche de l'élément de message de succès
        var successMessage = document.getElementById('success-message');

        // Masquer le message de succès après 3 secondes (3000 millisecondes)
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.display = 'none';
            }, 3000);
        }
    </script>
@endsection
