@extends('layouts.master')

    @section('title')
    <title>Gestion de stock | Tableau de bord</title>
    @endsection

    @section('style')
    @include('partials.style')
    @endsection

    @section('content')
    <main>
        <header class="page-header page-header-compact page-header-light border-bottom bg-white mb-4">
            <div class="container-xl px-4">
                <div class="page-header-content">
                    <div class="row align-items-center justify-content-between pt-3">
                        <div class="col-auto mb-3">
                            <h1 class="page-header-title">
                                <div class="page-header-icon"><i data-feather="user"></i></div>
                                Profil - Informations de votre profil Facebook
                            </h1>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main page content-->
        <div class="container-xl px-4 mt-4">
            <!-- Account page navigation-->
            <nav class="nav nav-borders">
                <a class="nav-link active ms-0" href="account-profile.html">Profil</a>
                {{-- <a class="nav-link" href="account-billing.html">Billing</a>
                <a class="nav-link" href="account-security.html">Security</a>
                <a class="nav-link" href="account-notifications.html">Notifications</a> --}}
            </nav>
            <hr class="mt-0 mb-4" />
            <div class="row">
                <div class="col-xl-4">
                    <!-- Profile picture card-->
                    <div class="card mb-4 mb-xl-0">
                        <div class="card-header">{{Auth::user()->name ?? ''}}</div>
                        <div class="card-body text-center">
                            <!-- Profile picture image-->
                            <img class="img-account-profile rounded-circle mb-2" src="{{asset('asset/assets/img/illustrations/profiles/profile-2.png')}}" alt="" />
                            <!-- Profile picture help block-->
                            <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                            <!-- Profile picture upload button-->
                            <button class="btn btn-primary" type="button">Upload new image</button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <!-- Account details card-->
                    <div class="card mb-4">
                        <div class="card-header">Account Details</div>
                        <div class="card-body">
                            <form action="{{route('informations.store')}}" class="formsubmit" method="POST" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <!-- Form Group (username)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputUsername">{{Auth::user()->name ?? ''}} - {{Auth::user()->email ?? ''}}</label>
                                </div>
                                <!-- Form Row-->
                                <div class="row gx-3 mb-3">
                                    <!-- Form Group (first name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputFirstName">Nom d'utilisateur</label>
                                        <input class="form-control" name="name" id="inputFirstName" type="text" placeholder="Entrer votre nom d'utilisateur" value="{{Auth::user()->name ?? ''}}" />
                                    </div>
                                </div>

                                <!-- Form Group (email address)-->
                                <div class="mb-3">
                                    <label class="small mb-1" for="inputEmailAddress">Email address</label>
                                    <input class="form-control" name="email" id="inputEmailAddress" type="email" placeholder="Entrer votre adresse mail" value="{{Auth::user()->email ?? ''}}" />
                                </div>
                                 <!-- Form Row        -->
                                 <div class="row gx-3 mb-3">
                                    <!-- Form Group (organization name)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputOrgName">Token Facebook</label>
                                        <input class="form-control" id="facebookToken" type="text" value="{{Auth::user()->token ?? ''}}" readonly/>
                                        <a class="btn btn-primary" href="{{route('handleFacebook')}}" type="button">recuperer</a>
                                    </div>
                                    <!-- Form Group (location)-->
                                    <div class="col-md-6">
                                        <label class="small mb-1" for="inputLocation">Facebook page ID</label>
                                        <input class="form-control facebook_page_id" name="facebook_page_id" type="text" value="{{Auth::user()->facebook_page_id ?? ''}}"/>
                                        <a class="btn btn-primary facebook_page_token" href="javascript:void(0)">mettre à jour<samp class="submitspinnerpage"></samp></a>
                                    </div>
                                </div>
                                
                                <!-- Save changes button-->
                                <button class="btn btn-primary" type="submit">Modifier <span class="submitspinner"></span> </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    @endsection
    @section('script')
        <script>
            $( document ).ready(function() {
                $('body').on('submit', '.formsubmit', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url:$(this).attr('action'),
                        data:new FormData(this),
                        type:'POST',
                        contentType:false,
                        cache:false,
                        processData:false,
                        beforeSend: function() {
                            $('.submitspinner').html('<i class="fa fa-spinner fa-spin"></i>')
                        },
                        success : function(data) {
                            $('.submitspinner').html('');
                            if (data.status==200) {
                                $.confirm({
                                    title: 'Success',
                                    content: data.msg,
                                    autoclose: 'OK|3000',
                                    buttons: {
                                        cancelAction: function(e) {
                                        }
                                    }
                                });
                            }
                            if (data.status==400) {
                                $.alert({
                                    title: 'Success!',
                                    content: data.msg,
                                });
                            }
                        },
                    });
                });
            });
            $('body').on('click', '.facebook_page_token', function(e) {
                var data = $('.facebook_page_id').val();
                $.ajax({
                    url:'{{route("handleFacebookPageId")}}',
                    data:{facebook_page_id:data},
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    beforeSend: function() {
                        $('.submitspinnerpage').html('<i class="fa fa-spinner fa-spin"></i>')
                    },
                    success : function (data) {
                        $('.submitspinnerpage').html('');
                        if (data.status==200) {
                            $.confirm({
                                title: 'Success',
                                content: data.msg,
                                autoclose: 'OK|3000',
                                buttons: {
                                    cancelAction: function(e) {
                                    }
                                }
                            });
                        }
                        if (data.status==400) {
                            $.alert({
                                title: 'Success!',
                                content: data.msg,
                            });
                        }
                    },
                });
            });
        </script>
    @endsection