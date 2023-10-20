@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            <a href="{{ route ('client.create')}}" class="btn  bg-gradient-primary">Ajouter client</a><br><br>


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
                  <th>Société</th>
                  <th>IFU</th>
                  <th>Responsable</th>
                  <th>Civilité</th>
                  <th>Téléphone</th>
                  <th>Actions</th>

                </tr>
                </thead>
                <tbody>
                    @forelse ($clients as $client)

                <tr>
                  <td>{{ $client->societe }}</td>
                  <td>{{ $client->ifu }}</td>
                  <td>{{ $client->nom }} {{ $client->prenom }}</td>
                  <td> {{ $client->sexe }}</td>
                  <td>{{ $client->telephone }}</td>
                  <td>
                    <a href="{{ route('client.detail', ['client' => $client->id]) }}" class="btn-sm btn-primary">Détail</a>
                    <a class="btn-sm btn-warning" href="{{ route('client.edit', $client->id) }}">Editer</a>
                    <a class="btn-sm btn-danger" href="{{ route('client.delete', $client->id) }}">Supprimer</a>
                  </td>
                </tr>
                @empty

                <tr>
                    <td class="cell" colspan="2">Aucun client ajoutés</td>

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

  @endsection
