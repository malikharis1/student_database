@extends('layouts.app')



@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    {{-- Course --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card mx-2 shadow">
                <div class="card-body p-4">
                    <h2 class="text-center mb-4">Student Registration</h2>
                    <a class="btn btn-link px-0" href="{{ url('/login') }}" style="text-align: center;display: block;">
                        Already have an account? Login now
                    </a>

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        {{-- Full Name --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="name" class="form-control" placeholder="Full Name"
                                value="{{ old('name') }}" required>
                        </div>

                        {{-- Father's Name --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="father_name" class="form-control" placeholder="Father's Name"
                                value="{{ old('father_name') }}" required>
                        </div>

                        {{-- Mother's Name --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-user"></i></span>
                            <input type="text" name="mother_name" class="form-control" placeholder="Mother's Name"
                                value="{{ old('mother_name') }}" required>
                        </div>

                        {{-- DOB --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                            <input type="date" name="dob" class="form-control" value="{{ old('dob') }}" required>
                        </div>

                        {{-- Course --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-book"></i></span>
                            <select name="course" class="form-select" required>
                                <option value="" disabled selected>Select Course</option>
                                @forelse($courses as $course)
                                    <option value="{{ $course }}" {{ old('course') == $course ? 'selected' : '' }}>
                                        {{ $course }}
                                    </option>
                                @empty
                                    <option disabled>No courses available</option>
                                @endforelse
                            </select>
                        </div>


                        {{-- Gender --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-venus-mars"></i></span>
                            <select name="gender" class="form-select" required>
                                <option value="" disabled selected>Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>

                        {{-- Religion --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-university"></i></span>
                            <input type="text" name="religion" class="form-control" placeholder="Religion"
                                value="{{ old('religion') }}" required>
                        </div>

                        {{-- Category --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-tags"></i></span>
                            <input type="text" name="category" class="form-control" placeholder="Category"
                                value="{{ old('category') }}" required>
                        </div>

                        {{-- Email --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                            <input type="email" name="email" class="form-control" placeholder="Email"
                                value="{{ old('email') }}" required>
                        </div>

                        {{-- Password --}}
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password" class="form-control" placeholder="Password" required>
                        </div>

                        {{-- Confirm Password --}}
                        <div class="input-group mb-4">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                            <input type="password" name="password_confirmation" class="form-control"
                                placeholder="Confirm Password" required>
                        </div>

                        <div class="text-center">
                            <button type="submit" class="btn btn-success px-4">Register</button>
                        </div>
                    </form>


                </div>
            </div>
        </div>
    </div>
@endsection