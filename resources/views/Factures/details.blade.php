@extends('layouts.master2')

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="callout callout-info">
            <h5><i class="fas fa-info"></i> Note:</h5>
            This page has been enhanced for printing. Click the print button at the bottom of the invoice to test.
          </div>


          <!-- Main content -->
          <div class="invoice p-3 mb-3">
            <!-- title row -->
            <div class="row">
              <div class="col-12">
                <h4>
                  <i class="fas fa-globe"></i> AdminLTE, Inc.
                  <small class="float-right">Date: {{ date('d/m/Y', strtotime($date)) }}
                </small>
                </h4>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                @php
                $infosAffichees = false;
                @endphp

                @foreach ($factures as $facture)
                    @if ($facture->date === $date && $facture->code === $code)
                        @if (!$infosAffichees)

                <address>
                  <strong>{{$facture->client->nom}}   {{$facture->client->prenom}}</strong><br>

                Téléphone :  {{$facture->client->telephone}}<br>
                N° Ifu :  {{$facture->client->ifu}}<br>

                </address>

                @php
                $infosAffichees = true; // Marquer que les informations ont été affichées
                @endphp
            @endif
            @endif
            @endforeach
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">

              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">

              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
              <div class="col-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th>Quantité</th>
                    <th>Produits</th>
                    <th>Prix</th>
                    <th>Totals</th>

                  </tr>
                  </thead>
                  <tbody>
                    @foreach ($factures as $facture )
                        @if ($facture->date === $date && $facture->code === $code)



                  <tr>
                    <td>{{$facture->quantite}}</td>
                    <td>{{$facture->produit}}</td>
                    <td>{{$facture->prix}}</td>
                    <td>{{$facture->total}}</td>
                  </tr>

                  @endif
                  @endforeach

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
              <div class="col-6">

                <div class="table-responsive">
                  <table class="table">

                    @php
                    $infosAffichees = false;
                    @endphp

                    @foreach ($factures as $facture)
                        @if ($facture->date === $date && $facture->code === $code)
                            @if (!$infosAffichees)
                                <tr>
                                    <th style="width:50%">Total HT:</th>
                                    <td>{{ $facture->totalHT }}</td>
                                </tr>
                                <tr>
                                    <th>Total TVA</th>
                                    <td>{{ $facture->totalTVA }}</td>
                                </tr>
                                <tr>
                                    <th>Total TTC</th>
                                    <td>{{ $facture->totalTTC }}</td>
                                </tr>
                                <tr>
                                    <th>Montant dû </th>
                                    <td>{{ $facture->montantPaye }}</td>
                                </tr>
                                @php
                                $infosAffichees = true; // Marquer que les informations ont été affichées
                                @endphp
                            @endif
                        @endif
                    @endforeach

                  </table>
                </div>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
              <div class="col-12">
                <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-default"><i class="fas fa-print"></i> Print</a>
                {{-- <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i> Submit
                  Payment
                </button> --}}

                {{-- <a href="{{ route('facture.pdf',$factures['id']) }}" class="btn btn-success btn-sm">Telecharger <b>PDF</b></a> --}}
                @php
                    $infosAffichees = false;
                    @endphp

                    @foreach ($factures as $facture)
                        @if ($facture->date === $date && $facture->code === $code)
                            @if (!$infosAffichees)

                <a href="{{ route('facture.pdf', ['facture' => $facture->id, 'date' => $facture->date, 'code' => $facture->code]) }}" class="btn btn-danger float-right" style="margin-right: 5px;">
                    <i class="fas fa-download"></i> Generate PDF
                </a>

                @php
                                $infosAffichees = true; // Marquer que les informations ont été affichées
                                @endphp
                            @endif
                        @endif
                    @endforeach

              </div>
            </div>
          </div>
          <!-- /.invoice -->
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </section>



@endsection
