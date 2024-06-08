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
                            <li class="breadcrumb-item active">Jobs</li>
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

                        <div class="card-body card-form">
                            <div class="d-flex justify-content-between">


                                <form action="" method="POST" name="editJobForm" id="editJobForm">
                                    @csrf
                                    <div>
                                        <h3 class="fs-4 mb-1">Jobs / Edit</h3>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="" class="mb-2">Title<span class="req">*</span></label>
                                            <input value="{{ $job->title }}" type="text" placeholder="Job Title"
                                                id="title" name="title" class="form-control">
                                            <p></p>
                                        </div>
                                        <div class="col-md-6  mb-4">
                                            <label for="" class="mb-2">Category<span
                                                    class="req">*</span></label>
                                            <select name="category" id="category" class="form-control">
                                                <option value="">Select a Category</option>
                                                @if ($categories->isNotEmpty())
                                                    @foreach ($categories as $category)
                                                        <option {{ $job->category_id == $category->id ? 'selected' : '' }}
                                                            value="{{ $category->id }}">{{ $category->name }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-4">
                                            <label for="" class="mb-2">Job Type<span
                                                    class="req">*</span></label>
                                            <select name="jobType" id="jobType" class="form-select">
                                                <option value="">Select Job Type</option>
                                                $ @if ($jobType->isNotEmpty())
                                                    @foreach ($jobType as $type)
                                                        <option {{ $job->job_type_id == $type->id ? 'selected' : '' }}
                                                            value="{{ $type->id }}">{{ $type->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <p></p>
                                        </div>
                                        <div class="col-md-6  mb-4">
                                            <label for="" class="mb-2">Vacancy<span
                                                    class="req">*</span></label>
                                            <input value="{{ $job->vacancy }}" type="number" min="1"
                                                placeholder="Vacancy" id="vacancy" name="vacancy" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Salary</label>
                                            <input value="{{ $job->salary }}" type="text" placeholder="Salary"
                                                id="salary" name="salary" class="form-control">
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Location<span
                                                    class="req">*</span></label>
                                            <input value="{{ $job->location }}" type="text" placeholder="location"
                                                id="location" name="location" class="form-control">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="row">

                                        <div class="mb-4 col-md-6">
                                            <div class="form-check">
                                                <input {{ $job->isFeatured == 1 ? 'checked' : '' }}
                                                    class="form-check-input" type="checkbox" value="1" id="isFeatured"
                                                    name="isFeatured">
                                                <label class="form-check-label" for="isFeatured">
                                                    Featured
                                                </label>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <div class="form-check-inline">
                                                <input {{ $job->status == 1 ? 'checked' : '' }} class="form-check-input"
                                                    type="radio" value="1" id="status-active" name="status">
                                                <label class="form-check-label" for="status">
                                                    Active
                                                </label>
                                            </div>
                                            <div class="form-check-inline">
                                                <input {{ $job->status == 0 ? 'checked' : '' }} class="form-check-input"
                                                    type="radio" value="0" id="status-block" name="status">
                                                <label class="form-check-label" for="status">
                                                    Block
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="" class="mb-2">Description<span
                                                class="req">*</span></label>
                                        <textarea class="form-control textarea" name="description" id="description" cols="5" rows="5"
                                            placeholder="Description">{{ $job->description }}</textarea>
                                        <p></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Benefits</label>
                                        <textarea class="form-control textarea" name="benefits" id="benefits" cols="5" rows="5"
                                            placeholder="Benefits">{{ $job->benefits }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Responsibility</label>
                                        <textarea class="form-control textarea" name="responsibility" id="responsibility" cols="5" rows="5"
                                            placeholder="Responsibility">{{ $job->responsibility }}</textarea>
                                        <p></p>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Qualifications</label>
                                        <textarea class="form-control textarea" name="qualifications" id="qualifications" cols="5" rows="5"
                                            placeholder="Qualifications">{{ $job->qualifications }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="" class="mb-2">Experience</label>
                                        <select name="experience" id="experience" class="form-select">
                                            <option value="">Select Experience</option>
                                            <option value="1" {{ $job->experience == 1 ? 'selected' : '' }}>1
                                                year
                                            </option>
                                            <option value="2" {{ $job->experience == 2 ? 'selected' : '' }}>2
                                                years
                                            </option>
                                            <option value="3" {{ $job->experience == 3 ? 'selected' : '' }}>3
                                                years
                                            </option>
                                            <option value="4" {{ $job->experience == 4 ? 'selected' : '' }}>4
                                                years
                                            </option>
                                            <option value="5" {{ $job->experience == 5 ? 'selected' : '' }}>5
                                                years
                                            </option>
                                            <option value="6" {{ $job->experience == 6 ? 'selected' : '' }}>6
                                                years
                                            </option>
                                            <option value="7" {{ $job->experience == 7 ? 'selected' : '' }}>7
                                                years
                                            </option>
                                            <option value="8" {{ $job->experience == 8 ? 'selected' : '' }}>8
                                                years
                                            </option>
                                            <option value="9" {{ $job->experience == 9 ? 'selected' : '' }}>9
                                                years
                                            </option>
                                            <option value="10">10 years</option>
                                            <option value="10_plus">+10 years</option>
                                        </select>
                                        <p></p>
                                    </div>



                                    <div class="mb-4">
                                        <label for="" class="mb-2">Keywords<span
                                                class="req">*</span></label>
                                        <input value="{{ $job->keywords }}" type="text" placeholder="keywords"
                                            id="keywords" name="keywords" class="form-control">
                                    </div>

                                    <h3 class="fs-4 mb-1 mt-5 border-top pt-5">Company Details</h3>

                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Name<span
                                                    class="req">*</span></label>
                                            <input value="{{ $job->company_name }}" type="text"
                                                placeholder="Company Name" id="company_name" name="company_name"
                                                class="form-control">
                                            <p></p>
                                        </div>

                                        <div class="mb-4 col-md-6">
                                            <label for="" class="mb-2">Location</label>
                                            <input value="{{ $job->company_location }}" type="text"
                                                placeholder="Location" id="location" name="company_location"
                                                class="form-control">
                                        </div>

                                    </div>



                                    <div class="mb-4">
                                        <label for="" class="mb-2">Website</label>
                                        <input value="{{ $job->company_website }}" type="text" placeholder="Website"
                                            id="company_website" name="company_website" class="form-control">
                                    </div>
                            </div>
                            <div class="card-footer  p-4">
                                <button type="submit" class="btn btn-primary">Update Job</button>
                            </div>
                            </form>
                        </div>

                    </div>
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
        $('#editJobForm').submit(function(e) {
            e.preventDefault();

            $.ajax({
                url: "{{ route('admin.jobs.Update', $job->id) }}",
                type: "PUT",
                data: $('#editJobForm')
                    .serializeArray(), //This is a jQuery method that serializes the form's elements (input fields, textareas, etc.) into an array of objects
                dataType: 'json',
                success: function(res) {
                    if (res.status == true) {

                        $("#title")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html('');

                        $("#vacancy")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#location")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#responsibility")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#company_name")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#description")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#category")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#jobType")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");

                        $("#experience")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");


                        window.location.href = "{{ route('admin.jobs.list') }}"

                    } else {

                        var errors = res.errors;

                        if (errors.title) {
                            $("#title")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.title);

                        } else {
                            $("#title")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html('');
                        }

                        if (errors.vacancy) {
                            $("#vacancy")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.vacancy);
                        } else {
                            $("#vacancy")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }

                        if (errors.location) {
                            $("#location")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.location);
                        } else {
                            $("#location")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }

                        if (errors.responsibility) {
                            $("#responsibility")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.responsibility);
                        } else {
                            $("#responsibility")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }

                        if (errors.company_name) {
                            $("#company_name")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.company_name);
                        } else {
                            $("#company_name")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }
                        if (errors.description) {
                            $("#description")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.description);
                        } else {
                            $("#description")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }
                        if (errors.category) {
                            $("#category")
                                .addClass("is-invalid")
                                .siblings("p")
                                .addClass("invalid-feedback")
                                .html(errors.category);
                        } else {
                            $("#category")
                                .removeClass("is-invalid")
                                .siblings("p")
                                .removeClass("invalid-feedback")
                                .html("");
                        }
                    }
                    if (errors.jobType) {
                        $("#jobType")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.jobType);
                    } else {
                        $("#jobType")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");
                    }
                    if (errors.experience) {
                        $("#experience")
                            .addClass("is-invalid")
                            .siblings("p")
                            .addClass("invalid-feedback")
                            .html(errors.experience);
                    } else {
                        $("#experience")
                            .removeClass("is-invalid")
                            .siblings("p")
                            .removeClass("invalid-feedback")
                            .html("");
                    }


                }
            })
        })
    </script>
@endsection
