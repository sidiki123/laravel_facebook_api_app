@extends('layouts.master')

    @section('title')
    <title>Laravel Facebook API Application | Publications</title>
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
                                Liste des publications
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main page content-->
        <div class="container-xl px-4 mt-n10" style="margin-bottom: 10rem;">
            <!-- Account details card-->
            <div class="card mb-4">
                <div class="card-header">Ajouter une publication</div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div><br />
                    @endif
                    
                    @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif
                    <form action="{{route('publication.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Titre</label>
                                <input class="form-control" name="titre" id="inputFirstName" type="text" placeholder="Titre de la publication" value="{{ Request::old('titre') }}" required/>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">Selectionner un fichier</label>
                                <input class="form-control" name="media" type="file" required/>
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-12">
                                </textarea>
                                <div class="mb-0"><label for="">Contenu de la publication</label>
                                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Enregistrer</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="container-xl px-4 mt-n10">
            <div class="card mb-4">
                <div class="card-header">Liste des publications</div>
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
