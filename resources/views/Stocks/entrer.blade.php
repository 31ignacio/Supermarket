@extends('layouts.master2')

@section('content')



<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            <a href="{{ route ('stock.create')}}" class="btn  bg-gradient-primary">Entrés de stock</a><br><br>


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Entrés de stocks</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Date</th>
                  <th>Produits</th>
                  <th>Quantité</th>


                </tr>
                </thead>
                <tbody>
                     @forelse ($stocks as $stock)

                <tr>
                  <td>{{ date('d/m/Y', strtotime($stock->date)) }}</td>
                  <td>{{$stock->libelle}}</td>
                  <td>{{$stock->quantite}}</td>

                </tr>
                 @empty

                <tr>
                    <td class="cell text-center" colspan="2">Aucun stock ajoutés</td>

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

