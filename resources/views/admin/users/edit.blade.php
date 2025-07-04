@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.edit') }} {{ trans('cruds.user.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.users.update", [$user->id]) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Full Name --}}
                <div class="form-group">
                    <label for="name">Full Name*</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="form-control"
                        required>
                </div>

                {{-- Email --}}
                <div class="form-group">
                    <label for="email">Email*</label>
                    <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}"
                        class="form-control" required>
                </div>

                {{-- Password --}}
                <div class="form-group">
                    <label for="password">New Password (leave blank to keep current)</label>
                    <input type="password" name="password" id="password" class="form-control">
                </div>

                {{-- Father's Name --}}
                <div class="form-group">
                    <label for="father_name">Father's Name</label>
                    <input type="text" name="father_name" id="father_name"
                        value="{{ old('father_name', $user->father_name) }}" class="form-control">
                </div>

                {{-- Mother's Name --}}
                <div class="form-group">
                    <label for="mother_name">Mother's Name</label>
                    <input type="text" name="mother_name" id="mother_name"
                        value="{{ old('mother_name', $user->mother_name) }}" class="form-control">
                </div>

                {{-- Date of Birth --}}
                <div class="form-group">
                    <label for="dob">Date of Birth</label>
                    <input type="date" name="dob" id="dob" value="{{ old('dob', $user->dob) }}" class="form-control">
                </div>

                {{-- Course --}}
                <div class="form-group">
                    <label for="course">Course</label>
                    <select name="course" id="course" class="form-control">
                        <option value="" disabled>Select Course</option>
                        <option value="Computer Application" {{ $user->course == 'Computer Application' ? 'selected' : '' }}>
                            Computer Application</option>
                        <option value="BA" {{ $user->course == 'BA' ? 'selected' : '' }}>BA</option>
                        <option value="BCom" {{ $user->course == 'BCom' ? 'selected' : '' }}>BCom</option>
                        <option value="BSc Nursing" {{ $user->course == 'BSc Nursing' ? 'selected' : '' }}>BSc Nursing
                        </option>
                    </select>
                </div>

                {{-- Gender --}}
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <select name="gender" id="gender" class="form-control">
                        <option value="" disabled>Select Gender</option>
                        <option value="Male" {{ $user->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $user->gender == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ $user->gender == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                </div>

                {{-- Religion --}}
                <div class="form-group">
                    <label for="religion">Religion</label>
                    <input type="text" name="religion" id="religion" value="{{ old('religion', $user->religion) }}"
                        class="form-control">
                </div>

                {{-- Category --}}
                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" name="category" id="category" value="{{ old('category', $user->category) }}"
                        class="form-control">
                </div>

                {{-- Registration Number (readonly) --}}
                <div class="form-group">
                    <label for="registration_number">Registration Number</label>
                    <input type="text" name="registration_number" id="registration_number"
                        value="{{ old('registration_number', $user->registration_number) }}" class="form-control" readonly>
                </div>

                {{-- Roles --}}
                {{-- <div class="form-group">
                    <label for="roles">Roles*
                        <span class="btn btn-info btn-xs select-all">{{ trans('global.select_all') }}</span>
                        <span class="btn btn-info btn-xs deselect-all">{{ trans('global.deselect_all') }}</span>
                    </label>
                    <select name="roles[]" id="roles" class="form-control select2" multiple required>
                        @foreach($roles as $id => $role)
                        <option value="{{ $id }}" {{ (in_array($id, old('roles', [])) || $user->roles->contains($id)) ?
                            'selected' : '' }}>{{ $role }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Institution (visible only if "Institution" role is selected) --}}
                {{-- <div class="form-group" id="institutionGroup"
                    style="{{ (in_array(2, old('roles', [])) || $user->roles->contains(2)) ? '' : 'display:none' }}">
                    <label for="institution">Institution</label>
                    <select name="institution_id" id="institution" class="form-control select2">
                        @foreach($institutions as $id => $institution)
                        <option value="{{ $id }}" {{ ($user->institution_id == $id) ? 'selected' : '' }}>{{ $institution }}
                        </option>
                        @endforeach
                    </select>
                </div> --}}

                <div>
                    <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection