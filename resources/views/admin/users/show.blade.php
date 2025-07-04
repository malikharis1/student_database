@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.user.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>Registration Number</th>
                            <td>{{ $user->registration_number }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.user.fields.id') }}</th>
                            <td>{{ $user->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.user.fields.name') }}</th>
                            <td>{{ $user->name }}</td>
                        </tr>
                        <tr>
                            <th>Father's Name</th>
                            <td>{{ $user->father_name }}</td>
                        </tr>
                        <tr>
                            <th>Mother's Name</th>
                            <td>{{ $user->mother_name }}</td>
                        </tr>
                        <tr>
                            <th>Date of Birth</th>
                            <td>{{ \Carbon\Carbon::parse($user->dob)->format('d-M-Y') }}</td>
                        </tr>
                        <tr>
                            <th>Course</th>
                            <td>{{ $user->course }}</td>
                        </tr>
                        <tr>
                            <th>Gender</th>
                            <td>{{ $user->gender }}</td>
                        </tr>
                        <tr>
                            <th>Religion</th>
                            <td>{{ $user->religion }}</td>
                        </tr>
                        <tr>
                            <th>Category</th>
                            <td>{{ $user->category }}</td>
                        </tr>
                        <form method="POST" action="{{ route('admin.users.updateEmail', $user->id) }}">
                            @csrf
                            @method('PUT')

                            <tr>
                                <th>{{ trans('cruds.user.fields.email') }}</th>
                                <td>
                                    <input type="email" name="email" value="{{ old('email', $user->email) }}" required
                                        class="form-control">
                                    <button type="submit" class="btn btn-sm btn-primary mt-2">Update Email</button>
                                </td>
                            </tr>
                        </form>

                    </tbody>
                </table>

                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>

            {{-- Semester-wise Subjects --}}
            @php
                $allSubjects = [
                    'Semester 1' => ['English Language', 'Financial Accounting', 'Mathematics I', 'Computer Fundamentals', 'Business Economics', 'C Programming', 'History of India', 'Principles of Management', 'Environmental Science', 'Introduction to Psychology', 'Microeconomics', 'Digital Literacy', 'Political Science I', 'Business Mathematics', 'Sociology I', 'Communication Skills'],
                    'Semester 2' => ['Advanced English', 'Corporate Accounting', 'Mathematics II', 'Data Structures', 'Macroeconomics', 'Object-Oriented Programming', 'Indian Constitution', 'Marketing Management', 'Environmental Studies II', 'Social Psychology', 'Statistics I', 'Web Design Fundamentals', 'Political Science II', 'Business Communication', 'Sociology II', 'E-Commerce'],
                    'Semester 3' => ['English Literature', 'Cost Accounting', 'Discrete Mathematics', 'Operating Systems', 'Indian Economy', 'DBMS', 'Medieval Indian History', 'HR Management', 'Environmental Law', 'Cognitive Psychology', 'Statistics II', 'Computer Networks', 'Political Science III', 'Organizational Behavior', 'Sociology III', 'Accounting Software (Tally)'],
                    'Semester 4' => ['Business Law', 'Taxation', 'Linear Algebra', 'Java Programming', 'Development Economics', 'Software Engineering', 'Modern Indian History', 'Financial Management', 'Cyber Laws', 'Abnormal Psychology', 'Operations Research', 'Mobile App Development', 'Political Science IV', 'Production & Operations Mgmt', 'Sociology IV', 'Business Research Methods'],
                    'Semester 5' => ['Entrepreneurship', 'Auditing', 'Numerical Methods', 'Python Programming', 'International Economics', 'Cloud Computing', 'World History', 'Investment Analysis', 'Ethics in IT', 'Health Psychology', 'Machine Learning', 'Information Security', 'Political Science V', 'Financial Statement Analysis', 'Sociology V', 'MIS (Management Info Systems)'],
                    'Semester 6' => ['Project Work', 'Strategic Management', 'Mathematical Modelling', 'Artificial Intelligence', 'Public Finance', 'Big Data Analytics', 'Contemporary World History', 'Portfolio Management', 'Cyber Security', 'Counseling Psychology', 'Data Visualization', 'E-Governance', 'Political Science VI', 'Tax Planning & Mgmt', 'Sociology VI', 'Professional Ethics'],
                ];
            @endphp

            @if (!empty($selectedSubjects))
                <h4 class="mt-4">Subjects (Semester-wise)</h4>
                @foreach($allSubjects as $semester => $subjects)
                    @php
                        $userSubjects = array_intersect($subjects, $selectedSubjects);
                    @endphp

                    @if (count($userSubjects))
                        <div class="mb-2">
                            <h5>{{ $semester }}</h5>
                            <ul>
                                @foreach($userSubjects as $sub)
                                    <li>{{ $sub }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            @endforeach @endif
        </div>
    </div>
@endsection