@extends('layouts.master')

    @section('title')
    <title>Laravel Facebook API Application | Editer une publication</title>
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
                                Editer une publication
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container-xl px-4 mt-n10" style="margin-bottom: 10rem;">
            <div class="card mb-4">
                <div class="card-header">Editer une publication</div>
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
                    <form action="{{route('publication.update',$publication->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1">Titre</label>
                                <input class="form-control" name="titre" type="text" placeholder="Titre de la publication" value="{{ $publication->titre }}" required/>
                            </div>
                            <div class="col-md-6">
                                <label class="small mb-1">Selectionner un fichier</label>
                                <input class="form-control" name="media" type="file" />
                                <img src="/media/{{ $publication->media }}" width="300px">
                            </div>
                        </div>
                        <div class="row gx-3 mb-3">
                            <div class="col-md-12">
                                </textarea>
                                <div class="mb-0"><label for="">Contenu de la publication</label>
                                    <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3">{{ $publication->message }}</textarea>
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-primary" type="submit">Modifier</button>
                    </form>
                </div>
            </div>
        </div>
    </main>
    @endsection
