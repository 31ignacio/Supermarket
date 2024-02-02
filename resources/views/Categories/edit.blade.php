@extends('layouts.master2')

@section('content')


<section class="content">

    <div class="row">
            <div class="col-md-3"></div>

        <form class="settings-form" method="POST" action="{{ route('categorie.update',$categorie->id) }}">
            @csrf
            @method('PUT')
    
            <div class="col-md-12">
                <div class="form-group">
                    <label>Editer une catégorie</label>
                    <input type="text" class="form-control" style="border-radius: 10px;" id="categorie" name="categorie" value="{{$categorie->categorie}}" required>
                </div>
            </div>
            <div class="col-md-12 mb-5 mt-4">
                <button type="submit" class="btn btn-sm btn-warning" style="margin-top:8px;"><i class="fas fa-plus-circle"></i>Editer</button>   

            </div>

            <div class="col-md-3"></div>
        </form>

    </div>
    


</section>

@endsection
