@extends('layouts.master2')

@section('content')


 <!-- Main content -->
 <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h1 class="card-title text-center">Etats des ventes </h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <form class="settings-form" method="GET" action="{{ route('etat.index') }}">
                    @csrf
                    @method('GET')
                
                    <div class="row">
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="dateDebut" style="border-radius:10px;" placeholder="Date Début">
                        </div>
                        <div class="col-md-3">
                            <input type="date" class="form-control" name="dateFin" style="border-radius:10px;" placeholder="Date Fin">
                        </div>
                        <div class="col-md-3">
                            <input type="text" class="form-control" id="nom" style="border-radius:10px;" placeholder="Nom du client">
                        </div>
                        
                        <button type="submit" class="btn btn-lg btn-default">
                            <i class="fa fa-search"></i>
                        </button>
                        
                    </div>
                </form>
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Nom</th>
                  <th>Prénom</th>
                  <th>Téléphone</th>
                  <th>Total TTC</th>

                </tr>
                </thead>

                <tbody>
                    @foreach ($results as $result)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($result->date)) }}</td>
                        <td>{{ $result->client->nom }}</td>
                        <td>{{ $result->client->prenom }}</td>
                        <td>{{ $result->client->telephone }}</td>
                        <td>{{ $result->totalTTC }}</td>
                    </tr>
                    @endforeach
                </tbody>
                
                
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->

         
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->
@endsection
