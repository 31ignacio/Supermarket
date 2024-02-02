@extends('layouts.master2')

@section('content')


<section class="content">

    <div class="row">
            <div class="col-md-1"></div>

        <div class="col-md-3">
            <div class="form-group">
                <label>Ajouter une catégorie</label>
                <input type="text" class="form-control" placeholder="Enter ..." style="border-radius: 10px;" id="categorie" name="categorie" required>
            </div>
        </div>
        <div class="col-md-1 mb-5 mt-4">
            <button type="submit" class="btn btn-sm btn-primary" style="margin-top:8px;" onclick="categorie()"><i class="fas fa-plus-circle"></i>Ajouter</button>   

        </div>

        <div class="col-md-1"></div>

        <div class="col-md-6">
          <div id="msg200"></div>
          @if (Session::get('success_message'))
                <div class="alert alert-success">{{ Session::get('success_message') }}</div>
                <script>
                  setTimeout(() => {
                      document.getElementById('success-message').remove();
                  }, 3000);
              </script>
            @endif


             <!-- /.card-header -->
             <div class="card-body">
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <th>Catégorie</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($categories as $categorie)
                      
                    <tr>
                      <td>{{$categorie->categorie}}</td>
                     
                      <td> 
                        <a class="btn-sm btn-warning" href="{{ route('categorie.edit', $categorie->id) }}"><i class="fas fa-edit"></i></a>
                        <a class="btn-sm btn-danger" href="{{ route('categorie.delete', $categorie->id) }}"><i class="fas fa-trash-alt"></i></a>
                     </td>
                       
                     </tr>
                     @endforeach

                  </tbody>
                </table>


                <br>
                 {{-- LA PAGINATION --}}
                 <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        @if ($categories->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">&laquo; Précédent</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->previousPageUrl() }}" rel="prev" aria-label="Précédent">&laquo; Précédent</a>
                            </li>
                        @endif
                
                        @if ($categories->hasMorePages())
                            <li class="page-item">
                                <a class="page-link" href="{{ $categories->nextPageUrl() }}" rel="next" aria-label="Suivant">Suivant &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link" aria-hidden="true">Suivant &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
              </div>
              <!-- /.card-body -->
             
        </div>


    </div>
    


</section>



<script>
  function categorie() {
      // $("#remboursementBtn").click(function() {
          // Récupérer l'ID du client depuis la page
          var categorie = $("#categorie").val();
              //alert(ref)
          // Récupérer le jeton CSRF depuis la balise meta
          var csrfToken = $('meta[name="csrf-token"]').attr('content');

          // Envoyer l'ID du client au contrôleur Laravel via une requête AJAX
          $.ajax({
              type: 'POST',
              url: "{{ route('categorie.store') }}", // Remplacez "/votre-route" par la route pertinente de votre application
              data: {
                  _token: csrfToken,categorie
              },
              success: function(response) {
                  // Gérer la réponse du serveur ici (par exemple, afficher un message de confirmation)
                  if (parseInt(response) == 200 || parseInt(response) == 500) {

                      parseInt(response) == 500 ? ($("#msg200").html(`<div class='alert alert-danger text-center' role='alert'>
                      <strong>Une erreur s'est produite</strong> veuillez réessayez.

                      </div>`)) : ($('#msg200').html(`<div class='alert alert-success text-center' role='alert'>
                      <strong> Catégorie  ajoutée avec succès  </strong>

                      </div>`));
                  }

                  var url = "{{ route('categorie.index') }}"
                  if (response == 200) {
                      setTimeout(function() {
                          window.location = url
                      }, 1000)
                  } else {
                      $("#msg200").html(response);

                  }
              },

          });
      // });
  };
</script>


@endsection
