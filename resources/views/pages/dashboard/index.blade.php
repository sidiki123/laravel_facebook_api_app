@extends('layouts.master')

    @section('title')
    <title>Laravel Facebook API Application | Accueil</title>
    @endsection

    @section('style')
    @include('partials.style')
    @endsection

    @section('content')
        <main>
            <header class="page-header page-header-dark bg-gradient-primary-to-secondary pb-10">
                <div class="container-xl px-4">
                    <div class="page-header-content pt-4">
                        <div class="row align-items-center justify-content-between">
                            <div class="col-auto mt-4">
                                <h1 class="page-header-title">
                                    <div class="page-header-icon"><i data-feather="activity"></i></div>
                                    Laravel Facebook API Application
                                </h1>
                            </div>
                            <div class="col-12 col-xl-auto mt-4">
                                <div class="input-group input-group-joined border-0" style="width: 16.5rem">
                                    <span class="input-group-text"><i class="text-primary" data-feather="calendar"></i></span>
                                    <div  class="form-control ps-0 pointer" >
                                        {{Carbon\Carbon::now()->format('d-m-Y')}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="container-xl px-4 mt-n10">
                <div class="row">
                    <div class="col-xxl-4 col-xl-12 mb-4">
                        <div class="card h-100">
                            <div class="card-body h-100 p-5">
                                <div class="row align-items-center">
                                    <div class="col-xl-8 col-xxl-12">
                                        <div class="text-center text-xl-start text-xxl-center mb-4 mb-xl-0 mb-xxl-4">
                                            <h1 style="font-size:25px" class="text-primary">Bienvenue 
                                            {{ Auth::user()->name ?? '' }}
                                            !</h1>
                                            <br>
                                            @if (Auth::user()->token == null ?? '')
                                            <h1 style="font-size: 20px">
                                                L'utilisation à certaines fonctionnalités de cette application demande l'accès à votre compte Facebook... <br>
                                                Ainsi rendez-vous sur la page <a href="{{route('informations.index')}}">Profil</a> pour récupérer votre token Facebook et surtout n'oublié pas de mettre à jour l'identifiant de la page facebook ciblée
                                            </h1>
                                            @endif
                                            
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-xxl-12 text-center"><img class="img-fluid" src="asset/assets/img/illustrations/at-work.svg" style="max-width: 26rem" /></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    @if (Auth::user()->token == null ?? '')
                        <div class="col-lg-6 col-xl-3 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Profil</div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{route('informations.index')}}">Détails</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-6 col-xl-3 mb-4">
                            <div class="card bg-primary text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Publications</div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{route('publication.index')}}">Détails</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 col-xl-3 mb-4">
                            <div class="card bg-success text-white h-100">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="me-3">
                                            <div class="text-white-75 small">Profil</div>
                                            <div class="text-lg fw-bold"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer d-flex align-items-center justify-content-between small">
                                    <a class="text-white stretched-link" href="{{route('informations.index')}}">Détails</a>
                                    <div class="text-white"><i class="fas fa-angle-right"></i></div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                <div class="row">
                    <div class="container-xl">
                        <div class="card mb-4">
                            <div class="card-header">Liste des articles publiés sur Facebook</div>
                            <div class="card-body">
                                <table id="datatablesSimple">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>Titre</th>
                                            <th>Contenu</th>
                                            <th>Média</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>id</th>
                                            <th>Titre</th>
                                            <th>Contenu</th>
                                            <th>Média</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        @forelse($publications as $publication)
                                        <tr>
                                            <td>{{$publication->id}}</td>
                                            <td>{{$publication->titre}}</td>
                                            <td>{{$publication->message}}</td>
                                            <td><img src="{{asset('media/'.$publication->media)}}" width="150" alt=""></td>
                                            <td>{{$publication->status}}</td>
                                            <td class="d-inline">
                                                <a title="Publié ce post" id="bksv" data-value="{{$publication->id}}" href="javascript:void(0)" class="btn btn-datatable btn-icon btn-success publishedPost"><i data-feather="mail"></i> <samp class="submitspinnerpage"></samp></a>
                                                </form>
                                                <a title="Editer cette publication" href="{{route('publication.edit',$publication)}}" class="btn btn-datatable btn-icon btn-warning"><i data-feather="edit"></i></a>
                                                <form action="{{route('publication.destroy',$publication)}}" class="d-inline" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button title="Supprimer cette publication" style="margin-left: 1rem;" class="btn btn-datatable btn-icon btn-danger" type="submit"><i data-feather="trash-2"></i></button>                                    
                                            </td>
                                        </tr>
                                        @empty
                                            <h1 class="text-center">Aucune publication enregistrée</h1>
                                        @endforelse
                                        
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    @endsection
    @section('script')
    <script>
        $( document ).ready(function(e) {
            $('body').on('click', '.publishedPost', function(e) {
                e.preventDefault();
                // var id = "{{$publication->id}}";
                const id = $(this).attr("data-value")
                // console.log(id)
                $.ajax({
                    url:"{{url('/publishedPost')}}",
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    data:{id:id},
                    beforeSend: function() {
                        $('.submitspinnerpage').html('<i class="fa fa-spinner fa-spin"></i>')
                    },
                    success : function(data) {
                        $('.submitspinnerpage').html('');
                        if (data.status==200) {
                            $.confirm({
                                title: 'Success',
                                content: data.msg,
                                autoclose: 'CancelAction|5000',
                                buttons: {
                                    cancelAction: function(e) {
                                    }
                                }
                            });
                        }
                        if (data.status==400) {
                            $.alert({
                                title: 'Alert!',
                                content: data.msg,
                            });
                        }
                    },
                });
            });
        });
    </script>
    @endsection