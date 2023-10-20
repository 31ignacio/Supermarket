@extends('layouts.master2')

@section('content')

@if (Session::get('success_message'))
        <div class="alert alert-success">{{ Session::get('success_message') }}</div>
    @endif

    <form class="settings-form" method="POST" action="{{ route('produit.update',$produit->id) }}">
        @csrf
        @method('PUT')



    <div class="row">
        <div class="col-md-2"></div>

        <div class="col-md-8">
            <!-- general form elements -->
            <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Editer un produit</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="societe">Référence</label>
                            <input type="text" class="form-control" id="ref" value="{{ $produit->ref }}" name="ref" value="{{ old('societe') }}" required style="border-radius:10px;">

                        {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                        @error('ref')
                        <div class="text-danger">{{ $message }}</div>
                        @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="ifu">Produit</label>
                            <input type="text" class="form-control" id="libelle" name="libelle" value="{{ $produit->libelle }}" value="{{ old('ifu') }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('libelle')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="nom">Quantité</label>
                            <input type="text" class="form-control" id="quantite" name="quantite" value="{{ $produit->quantite }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('quantite')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="prenom">Date</label>
                            <input type="date" class="form-control" id="date" name="date" value="{{ $produit->date }}" required style="border-radius:10px;">

                            {{-- Affiche les erreur sous le input (le @error prend le name du input) --}}
                            @error('date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>



                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                <button type="submit" class="btn btn-warning" style="border-radius:10px;">Editer</button>
                </div>
            </form>
            </div>
            <!-- /.card -->
        </div>
        <div class="col-md-2"></div>

    </div>
</form>
@endsection
