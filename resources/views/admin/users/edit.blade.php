@extends('front.layouts.app')

@section('main')
    <section class="section-5 bg-2">
        <div class="container py-5">
            <div class="row">
                <div class="col">
                    <nav aria-label="breadcrumb" class=" rounded-3 p-3 mb-4">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                            <li class="breadcrumb-item active">Users</li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    @include('admin.sidebar')
                </div>
                <div class="col-lg-9">
                    @include('front.message')
                    <div class="card border-0 shadow mb-4 p-4">

                        <form action="" method="POST" name="userForm" id="userForm">
                            @csrf
                            <div class="card-body  p-4">
                                <h3 class="fs-4 mb-1">User / Edit</h3>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Name*</label>
                                    <input type="text" value="{{ $user->name }}" name="name" id="name"
                                        placeholder="Enter Name" class="form-control" value="">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Email*</label>
                                    <input type="text" value="{{ $user->email }}" name="email" id="email"
                                        placeholder="Enter Email" class="form-control">
                                    <p></p>
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Designation*</label>
                                    <input type="text" value="{{ $user->designation }}" name="designation"
                                        id="designation" placeholder="Designation" class="form-control">
                                </div>
                                <div class="mb-4">
                                    <label for="" class="mb-2">Mobile*</label>
                                    <input type="text" value="{{ $user->mobile }}" name="mobile" id="mobile"
                                        placeholder="Mobile" class="form-control">
                                </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        </div>
        </div>
        </div>
    </section>
@endsection

@section('customJs')
    <script>
        $('#userForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.users.update', $user->id) }}",
                type: "PUT",
                data: $('#userForm').serializeArray(),
                dataType: 'json',
                success: function(res) {
                    if (res.status == true) {

                        $("#name")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html('');

                        $("#email")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html('');

                        window.location.href = "{{ route('admin.users.list') }}"

                    } else {

                        var errors = res.errors;

                        if (errors.name) {
                            $("#name")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.name);

                        } else {
                            $("#name")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html('');
                        }

                        if (errors.email) {
                            $("#email")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.email);
                        } else {
                            $("#email")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }

                    }
                }
            })
        })
    </script>
@endsection
