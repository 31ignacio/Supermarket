@extends('layouts.master2')

@section('content')


<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">

            {{-- <a href="{{ route ('stock.create')}}" class="btn  bg-gradient-primary">Entrés de stock</a><br><br> --}}


            @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
            @endif

          <div class="card">
            <div class="card-header">
              <h1 class="card-title">Stocks actuels</h1>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Produits</th>
                  <th>Quantité</th>

                </tr>
                </thead>
                <tbody>
                    @foreach ($produits as $produit)
                    <tr>
                        <td>{{ $produit->libelle }}</td>
                        <td>{{ $produit->stock_actuel }}</td>
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

