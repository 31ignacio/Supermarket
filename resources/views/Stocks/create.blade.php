@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
    @endif




    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Entrés de stocks</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="settings-form" method="POST" action="{{ route('stock.store') }}">
                @csrf
                @method('POST')
                            <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="produit">Produit</label>
                            <select name="produit" id="produit" class="form-control" value="{{ old('produit') }}" required style="border-radius:10px;">
                                <option value=""></option>
                                @foreach ($produits as $produit )
                                <option value="{{$produit->libelle}}">{{$produit->libelle}}</option>

                                @endforeach
                            </select>

                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('produit')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="quantite">Quantité</label>
                            <input type="text" class="form-control" id="quantite" name="quantite" value="{{ old('quantite') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-primary" style="border-radius:10px;">Envoyer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-2"></div>

    </div>

@endsection
