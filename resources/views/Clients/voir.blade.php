 <div class="card">
                        <div class="card-header">
                            


                           @php
    $clientInfoDisplayed = false; // Variable de drapeau pour vérifier si les informations du client ont déjà été affichées
@endphp

@foreach($remboursementss as $remboursements)
    <!-- Le reste de votre code pour chaque remboursement -->

    @if (!$clientInfoDisplayed)
        <!-- Affichez le nom et le prénom du client une seule fois -->
        <b>Client : {{ $remboursements->facture->client->nom }} {{ $remboursements->facture->client->prenom }}</b>

        
        <a href="{{ route('rembourssement.pdf', ['rembourssement' => $remboursements->facture->id, 'code' => $remboursements->facture->code]) }}" class="btn btn-danger float-right" style="margin-right: 5px;">
            <i class="fas fa-download"></i> Generate PDF
        </a>

        @php
            $clientInfoDisplayed = true; // Marquer que les informations du client ont été affichées
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
                                $totalRemboursement = 0;
                            @endphp

                               @foreach($remboursementss as $remboursements)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($remboursements->date)) }}</td>
                                        <td>{{ $remboursements->facture->code }}</td>
                                        <td>{{ $remboursements->montant }}</td>
                                        <td class="badge badge-warning">{{ $remboursements->mode }}</td>
                                    </tr>

                                    @php
                                        $totalRemboursement += $remboursements->montant;
                                    @endphp
                                @endforeach

                                

<div class="row mt-5">
    <div class="col-12">
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="font-weight-bold text-center">Montant Dû :</div>
            </div>
            <div class="col-4">
                <div class="font-weight-bold text-center">{{$remboursements->facture->montantDu}}</div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="font-weight-bold text-center">Somme des remboursements :</div>
            </div>
            <div class="col-4">
                <div class="font-weight-bold text-center">{{$totalRemboursement }}</div>
            </div>
        </div>
        <hr>
        {{-- <div class="row">
            <div class="col-4">
                <div class="font-weight-bold text-center">Reste à payer:</div>
            </div>
            <div class="col-4">
                <div class="font-weight-bold text-center">{{$remboursements->facture->montantDu - $totalRemboursement}} FCFA</div>
            </div>
        </div> --}}
        <hr>
    </div>
</div>


                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>

                   