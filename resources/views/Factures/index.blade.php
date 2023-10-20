@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            <a href="{{ route ('facture.create')}}" class="btn  bg-gradient-primary">Ajouter client</a><br><br>


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Liste des factures</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Code de Facture</th>
                        <th>Client</th>
                        <th>Date</th>
                        <th>Total TTC</th>
                        <th>Mode de paiement</th>
                        <th>Actions</th>

                        <!-- Autres colonnes -->
                    </tr>
                </thead>
                <tbody>
                    @foreach ($codesFacturesUniques as $factureUnique)


                    <tr>
                        <td><b>{{ $factureUnique->code}}</b></td>

                        <td>{{ $factureUnique->client->nom }} {{ $factureUnique->client->prenom}}</td>
                        <td>{{ date('d/m/Y', strtotime($factureUnique->date)) }}</td>
                        <td>{{ $factureUnique->totalTTC }}</td>
                        <td>
                            @if ($factureUnique->mode)
                                @if ($factureUnique->mode->modePaiement === 'Espèce')
                                    <span class="badge badge-success">{{ $factureUnique->mode->modePaiement }}</span>
                                @else
                                    <span class="badge badge-danger">{{ $factureUnique->mode->modePaiement }}</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('facture.details', ['code' => $factureUnique->code, 'date' => $factureUnique->date]) }}" class="btn btn-primary">Détail</a>

                        </td>
                    </tr>
                @endforeach
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

  @endsection
