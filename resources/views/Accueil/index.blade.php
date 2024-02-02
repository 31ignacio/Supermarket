@extends('layouts.master2')

@section('content')

@foreach ($produits as $produit)
<tr>
    <td><span style="display:none;">{{ $produit->libelle }}</span></td>
    <td>
        <span style="display:none;">{{ $produit->stock_actuel }}</span>
        @if ($produit->stock_actuel <= 2)
        {{-- <script src="https://unpkg.com/toastify-js"></script> --}}
        <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>

            <script>
                setInterval(function() {
                    Toastify({
                        text: "Le stock de {{ $produit->libelle }} est faible.",
                        duration: 10000,
                        close: true,
                        gravity: "top", // Position du toast
                        backgroundColor: "#b30000",
                    }).showToast();
                }, 1800000); // 5000 millisecondes correspondent à 5 secondes

            </script>
        @endif
    </td>


    <td>
        <span style="display:none;">{{ $produit->dateExpiration }}</span>
        @php
            $troisMoisPlusTard = now()->addMonths(3);
        @endphp
        @if ($produit->dateExpiration < $troisMoisPlusTard)
            {{-- <script src="https://unpkg.com/toastify-js"></script> --}}
            <script src="../../../../AD/toastify-js-master/src/toastify.js"></script>
    
            <script>
                setInterval(function() {
                    Toastify({
                        text: "La date d'expiration du produit {{ $produit->libelle }} est dans moins de trois mois.",
                        duration: 15000,
                        close: true,
                        gravity: "right", // Afficher à gauche
                        backgroundColor: "#0000FF", // Changer la couleur ici
                    }).showToast();
                }, 3600000); // 5000 millisecondes correspondent à 5 secondes
            </script>
        @endif
    </td>
    
    
</tr>
@endforeach

    




    <section class="content">
        <div class="container-fluid">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $nombreClient }}</h3>
                            <p><i class="fas fa-users"></i> Mes clients</p>
                        </div>
                        
                        <a href="{{ route('client.index') }}" class="small-box-footer">Plus d'information <i
                                class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                 <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3 style="font-size: 190%;">Facture</h3>

                            <p>Ajouter un facture</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{route('facture.create')}}" class="small-box-footer">Plus d'information<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3 style="font-size: 190%;">Stocks</h3>

                            <p>Mon stock</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('stock.index')}}" class="small-box-footer">Plus d'information<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>
                <!-- ./col -->
                        
                <div class="col-lg-3 col-6">
                    <!-- small box -->
                    <div class="small-box bg-secondary">
                        <div class="inner">
                        @auth
                        @if(auth()->user()->role_id === 1)
               
                            <h3 style="font-size: 170%;">{{ $sommeTotalTTC }} FCFA</h3>

                            @else
                            <h3>---</h3>
                        @endif
                         @endauth

                            <p>Somme des ventes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{route('facture.index')}}" class="small-box-footer">Plus d'information<i class="fas fa-arrow-circle-right"></i></a>
                    </div>
                </div>

                <!-- ./col -->
            </div>



            <div id="carouselExample" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../../../../AD/dist/img/i1.jpg" class="d-block w-100" alt="Image 1">
                        <div class="carousel-caption d-none d-md-block">
                            <h3 class="display-4"><b>sourire compte :</b></h3>
                            <p class="lead">Vous êtes les artisans de la première impression de nos clients. Faites briller votre sourire et créez une expérience de paiement agréable pour chaque client qui franchit nos portes.</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <img src="../../../../AD/dist/img/i2.jpg" class="d-block w-100" alt="Image 2">
                        <div class="carousel-caption d-none d-md-block">
                            <h3 class="display-4"><b>écision et Rapidité :</b></h3>
                            <p class="lead"> Vous êtes le lien entre nos produits et nos clients. Chaque scan, chaque transaction compte. Travaillons ensemble pour assurer une facturation précise et une efficacité remarquable. Chaque seconde économisée est une satisfaction client gagnée</p>
                        </div>
                    </div>
                    
                    <div class="carousel-item">
                        <img src="../../../../AD/dist/img/i3.jpg" class="d-block w-100" alt="Image 3">
                        <div class="carousel-caption d-none d-md-block">
                            <h3 class="display-4"><b>Équipe Unie, Service Exceptionnel :</b></h3>
                            <p class="lead"> Nous formons une équipe solide et unie. Ensemble, nous visons l'excellence dans le service à la clientèle. Chaque interaction avec nos clients est une opportunité de laisser une impression positive. Soyez les champions de la satisfaction client !</p>
                        </div>
                    </div>
                    
                </div>
                <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Précédent</span>
                </a>
                <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Suivant</span>
                </a>
            </div>
        
        </div><!-- /.container-fluid -->


        <style>
            /* Ajoutez des styles personnalisés ici selon vos préférences */
            .carousel-caption {
                background: rgba(0, 0, 0, 0.7); /* Arrière-plan semi-transparent noir pour le texte */
                color: white; /* Couleur du texte */
                text-align: left; /* Aligner le texte à gauche */
                padding: 20px; /* Espace intérieur du texte */
                position: absolute;
                top: 50%; /* Position au centre du carousel */
                width: 50%;
                transform: translateY(-50%); /* Centrer verticalement */
            }
    
            .carousel-caption h3 {
                font-size: 1rem; /* Taille de la police pour le titre */
                margin-bottom: 10px;
            }
    
            .carousel-caption p {
                font-size: 1.2rem; /* Taille de la police pour le paragraphe */
                margin-bottom: 0;
            }
        </style>
    </section>
@endsection
