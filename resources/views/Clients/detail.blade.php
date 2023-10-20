@extends('layouts.master2')

@section('content')
<style>
    #achats {
       border-radius: 10px;
        background-color: #4CAF50; /* Couleur de fond vert plus pur */
        color: white; /* Couleur du texte en blanc */
    }

    #dettes{
         border-radius: 10px;
        background-color: red; /* Couleur de fond vert plus pur */
        color: white; /* Couleur du texte en blanc */
    }
</style>
    {{-- <span id="client-id" style="display: none;">{{$client}}</span> --}}

    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">

                    <br><br>
                    <div id="msg200"></div>

                    @if (Session::get('success_message'))
                        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                    @endif

                    <div class="row">
                        <div class="col-md-3">
                            <label>Achats</label>
                                <input type="text" id="achats" class="form-control" style="border-radius:10px;" readonly />

                        </div>

                        <div class="col-md-3">
                            <label>Dettes</label>
                            <input type="text" id="dettes" class="form-control" style="border-radius:10px;"/>

                        </div>

                    </div><br><br>

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Facture client</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>N°Factuure</th>
                                        <th>Montant</th>
                                        <th>Montant dû</th>
                                        <th>Mode paiement</th>
                                        <th>Actions</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @forelse ($codesFacturesUniques as $client)
                                        <tr>
                                            <td>{{ date('d/m/Y', strtotime($client->date)) }}</td>
                                            <td>{{ $client->code }}</td>
                                            <td class="montant">{{ $client->totalTTC }}</td>
                                            <td class="montant2">{{$client->montantDu }}</td>

                                            <td>
                                                @if ($client->mode->modePaiement === 'Espèce')
                                                <span class="badge badge-success">{{ $client->mode->modePaiement }}</span>
                                            @else
                                                @if($client->montantDu === 0)
                                                <span class="badge badge-danger">{{ $client->mode->modePaiement }}</span>
                                                <span class="badge badge-success">Soldé</span>
                                                @else
                                                <span class="badge badge-danger">{{ $client->mode->modePaiement }}</span>
                                                @endif
                                            @endif

                                            </td>
                                            <td>
                                                <button type="button" data-key="{{ $client->id }}" onclick="detailRembourssement(event)" class="btn-sm btn-primary voir">Détails rembourssement</button> 
                                                @if ($client->montantDu != 0)
                                                    <a href="" type="button" class="btn-sm btn-warning"
                                                        data-toggle="modal" data-target="#modal-sm"
                                                        onclick="sendClientIdToModal()" data-client-id="{{ $client->id }}">
                                                        Remboursement
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty

                                        <tr>
                                            <td class="cell text-center" colspan="6">Aucune opération éffectuée</td>

                                        </tr>
                                    @endforelse


                                    </tfoot>
                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>

        {{-- REMBOURSSEMENT --}}
    <div class="modal fade" id="modal-sm">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Montant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <input type="text" class="form-control" id="rembourssement" autocomplete="off" name="rembourssement">


                    <p id="client-info" name="factureId"></p>
                    @error('rembourssement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" class="btn btn-warning"  onclick="remboursse()">Valider</button>
                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-md">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h3><i>Détails remboursement</i></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id='annonceModal'>


                   
                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Voir les details de rembourssement d'un client --}}
    <script>

        
        
        function detailRembourssement(event) {
            
            $('#annonceModal').html('')
            //alert("Ouverture du formulaire d'inscription")

            var id2 = event.target.getAttribute('data-key');
                //alert(id2)
            var url=" {{ route ("detailRembourssement")}} ";
            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            var data = {
                _token: csrfToken,
                id2
            };
            
            
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                success: function (response)
                { 
                    
                    $('#annonceModal').html(response)
                                $('#modal-md').modal('show')
                }
            
            });
            
        };

    </script>
    {{-- Envoyer l'id du client sur le modal rembourssement --}}
    <script>
        function sendClientIdToModal() {
            // Récupérer l'ID du client depuis la page
            // var clientId = document.getElementById('client-id').innerText;
            var clientId = event.target.getAttribute(
            'data-client-id'); // Récupère l'ID du client depuis l'attribut personnalisé
            var factureId = parseInt(document.getElementById('client-info').innerText);
            document.getElementById('client-info').value = document.getElementById('client-info').innerText;


            // Placez l'ID du client dans votre modal
            var modalContent = document.getElementById('client-info');

            modalContent.innerHTML = clientId;


        }
    </script>

    {{-- Le rembourssement pour un client --}}
    <script>
        function remboursse() {
            // $("#remboursementBtn").click(function() {
                // Récupérer l'ID du client depuis la page
                var factureId = $("#client-info").text();
                var rembourssement = $("#rembourssement").val();
                // Récupérer le jeton CSRF depuis la balise meta
                var csrfToken = $('meta[name="csrf-token"]').attr('content');

                // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
                $.ajax({
                    type: 'POST',
                    url: "{{ route('client.rembourssement') }}", // Remplacez "/votre-route" par la route pertinente de votre application
                    data: {
                        _token: csrfToken,

                        factureId,
                        rembourssement
                    },
                    success: function(response) {
                        $('#modal-sm').modal('hide'); // Ferme le modal avec l'ID 'modal-sm'
                        // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                        if (parseInt(response) == 200 || parseInt(response) == 500) {

                            parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                            <strong>Une erreur s'est produite</strong> veuillez réessayez.

                            </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                            <strong> Rembourssement  </strong>

                            </div>`));
                        }

                        var url = "{{ route('client.index') }}"
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

    {{-- Pour faire la somme des achats --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalAchats = 0;
            let montants = document.querySelectorAll('#example1 tbody tr .montant');

            montants.forEach(function(montant) {
                totalAchats += parseFloat(montant.textContent.replace(/\s/g, '').replace(/,/g, '.'));
            });

            const formattedTotal = totalAchats.toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
            });

            document.getElementById('achats').value = formattedTotal;
        });
    </script>
        
        {{-- Pour faire la somme des dettes --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let totalAchats = 0;
            let montants = document.querySelectorAll('#example1 tbody tr .montant2');

            montants.forEach(function(montant) {
                totalAchats += parseFloat(montant.textContent.replace(/\s/g, '').replace(/,/g, '.'));
            });

            const formattedTotal = totalAchats.toLocaleString('fr-FR', {
                style: 'currency',
                currency: 'XOF'
            });

            document.getElementById('dettes').value = formattedTotal;
        });
    </script>




@endsection
