@extends('layouts.master2')

@section('content')

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

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Liste des clients</h3>
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
                                            <td>{{ $client->totalTTC }}</td>
                                            <td>{{ $client->montantPaye }}</td>

                                            <td>
                                                @if ($client->mode)
                                                    @if ($client->mode->modePaiement === 'Espèce')
                                                        <span
                                                            class="badge-sm badge-success">{{ $client->mode->modePaiement }}</span>
                                                    @else
                                                        <span
                                                            class="badge-sm badge-danger">{{ $client->mode->modePaiement }}</span>
                                                    @endif
                                                @else
                                                    <span class="badge-sm badge-warning">Remboursement</span>
                                                @endif


                                            </td>
                                            <td>
                                                <a href="" type="button" class="btn-sm btn-info" data-toggle="modal"
                                                    data-target="#modal-md" onclick="sendClientIdToModal()"
                                                    data-client-id="{{ $client->id }}">
                                                    Détail rembourssement
                                                </a>
                                                <a href="" type="button" class="btn-sm btn-warning"
                                                    data-toggle="modal" data-target="#modal-sm"
                                                    onclick="sendClientIdToModal()" data-client-id="{{ $client->id }}">
                                                    Remboursement
                                                </a>

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


                    <input type="text" class="form-control" id="rembourssement" name="rembourssement">


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
                    <h3><i>Détails rembourssement</i></h3>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">


                    <div class="card">
                        <div class="card-header">


                            @php
                            $clientInfoAffiche = false;
                        @endphp

                        @foreach($codesFacturesUniques as $client)
                            @if(!$clientInfoAffiche)
                                <b>Client : {{ $client->client->nom }} {{$client->client->prenom}}</b>
                                @php
                                    $clientInfoAffiche = true;
                                @endphp
                            @endif
                        @endforeach


                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>N°Factuure</th>
                                        <th>Montant</th>
                                        <th>Mode paiement</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $sommeMontants = 0;
                                    @endphp
                                   @forelse ($rembourssements as $remboursement)
                                   <p id="client-info2" name="factureId" hidden>{{ $remboursement->facture_id }}</p>

                                   @foreach ($codesFacturesUniques as $facture)
                                   <p id="client-info2" name="factureId" hidden>{{ $facture->id }}</p>

                                       @if ($remboursement->facture->code === $facture->code)
                                           <tr>
                                               <td>{{ date('d/m/Y', strtotime($remboursement->date)) }}</td>
                                               <td>{{ $remboursement->facture->code }}</td>
                                               <td>{{ $remboursement->montant }}</td>
                                               <td class="badge badge-warning">{{ $remboursement->mode }}</td>
                                           </tr>
                                           @php
                                               $sommeMontants += $remboursement->montant;
                                           @endphp
                                       @endif
                                   @endforeach
                               @empty
                                   <tr>
                                       <td class="cell text-center" colspan="6">Aucune opération effectuée</td>
                                   </tr>
                               @endforelse

                                    @php
                                    $infosAffichees = false;
                                @endphp

                                @foreach($codesFacturesUniques as $client)
                                    @if(!$infosAffichees)
                                        <tr>
                                            <td colspan="2" class="cell text-center" style="font-weight: bold;">Montant Dû :</td>
                                            <td colspan="2" class="cell text-center " style="font-weight: bold;">{{$client->montantPaye}}</td>
                                            <td></td>
                                        </tr>

                                    <tr>
                                        <td colspan="2" class="cell text-center" style="font-weight: bold;">Somme des rembourssement :</td>
                                        <td colspan="2" class="cell text-center " style="font-weight: bold;">{{ $sommeMontants }}</td>
                                        <td></td>
                                    </tr>

                                    <tr>
                                        <td colspan="2" class="cell text-center" style="font-weight: bold;">Reste à payer:</td>

                                        <td colspan="2" class="cell text-center " style="font-weight: bold;">{{$client->montantPaye  - $sommeMontants}} FCFA</td>
                                        <td></td>
                                    </tr>

                                    @php
                                    $infosAffichees = true; // Marquer que les informations ont été affichées
                                @endphp
                            @endif
                        @endforeach


                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                    @error('rembourssement')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror

                </div>


            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <script>
        function sendClientIdToModal() {
            // Récupérer l'ID du client depuis la page
            // var clientId = document.getElementById('client-id').innerText;
            var clientId = event.target.getAttribute(
            'data-client-id'); // Récupère l'ID du client depuis l'attribut personnalisé
            var factureId = parseInt(document.getElementById('client-info2').innerText);
            document.getElementById('client-info2').value = document.getElementById('client-info2').innerText;


            // Placez l'ID du client dans votre modal
            var modalContent = document.getElementById('client-info');
            var modalContent2 = document.getElementById('client-info2');

            modalContent.innerHTML = clientId;
            modalContent2.innerHTML = clientId;


        }
    </script>



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
                    url: '{{ route('client.rembourssement') }}', // Remplacez "/votre-route" par la route pertinente de votre application
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



@endsection
