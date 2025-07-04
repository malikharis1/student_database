@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.show') }} {{ trans('cruds.discipline.title') }}
        </div>

        <div class="card-body">
            <div class="mb-2">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>{{ trans('cruds.discipline.fields.id') }}</th>
                            <td>{{ $discipline->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ trans('cruds.discipline.fields.name') }}</th>
                            <td>{{ $discipline->name }}</td>
                        </tr>
                        <tr>
                            <th>Selected Subjects (Semester-wise)</th>
                            <td>
                                @php
                                    $selectedSubjects = json_decode($discipline->subjects, true) ?? [];

                                    $subjects = [
                                        'Semester 1' => ['English Language', 'Financial Accounting', 'Mathematics I', 'Computer Fundamentals', 'Business Economics', 'C Programming', 'History of India', 'Principles of Management', 'Environmental Science', 'Introduction to Psychology', 'Microeconomics', 'Digital Literacy', 'Political Science I', 'Business Mathematics', 'Sociology I', 'Communication Skills'],
                                        'Semester 2' => ['Advanced English', 'Corporate Accounting', 'Mathematics II', 'Data Structures', 'Macroeconomics', 'Object-Oriented Programming', 'Indian Constitution', 'Marketing Management', 'Environmental Studies II', 'Social Psychology', 'Statistics I', 'Web Design Fundamentals', 'Political Science II', 'Business Communication', 'Sociology II', 'E-Commerce'],
                                        'Semester 3' => ['English Literature', 'Cost Accounting', 'Discrete Mathematics', 'Operating Systems', 'Indian Economy', 'DBMS', 'Medieval Indian History', 'HR Management', 'Environmental Law', 'Cognitive Psychology', 'Statistics II', 'Computer Networks', 'Political Science III', 'Organizational Behavior', 'Sociology III', 'Accounting Software (Tally)'],
                                        'Semester 4' => ['Business Law', 'Taxation', 'Linear Algebra', 'Java Programming', 'Development Economics', 'Software Engineering', 'Modern Indian History', 'Financial Management', 'Cyber Laws', 'Abnormal Psychology', 'Operations Research', 'Mobile App Development', 'Political Science IV', 'Production & Operations Mgmt', 'Sociology IV', 'Business Research Methods'],
                                        'Semester 5' => ['Entrepreneurship', 'Auditing', 'Numerical Methods', 'Python Programming', 'International Economics', 'Cloud Computing', 'World History', 'Investment Analysis', 'Ethics in IT', 'Health Psychology', 'Machine Learning', 'Information Security', 'Political Science V', 'Financial Statement Analysis', 'Sociology V', 'MIS (Management Info Systems)'],
                                        'Semester 6' => ['Project Work', 'Strategic Management', 'Mathematical Modelling', 'Artificial Intelligence', 'Public Finance', 'Big Data Analytics', 'Contemporary World History', 'Portfolio Management', 'Cyber Security', 'Counseling Psychology', 'Data Visualization', 'E-Governance', 'Political Science VI', 'Tax Planning & Mgmt', 'Sociology VI', 'Professional Ethics'],
                                    ];
                                @endphp

                                @php
                                    $grouped = [];

                                    foreach ($subjects as $semester => $list) {
                                        $grouped[$semester] = array_filter($list, function ($subject) use ($selectedSubjects) {
                                            return in_array($subject, $selectedSubjects);
                                        });
                                    }
                                @endphp

                                @foreach($grouped as $semester => $subjectsInSem)
                                    @if(count($subjectsInSem))
                                        <div class="mb-2">
                                            <strong>{{ $semester }}</strong>
                                            <ul class="mb-0">
                                                @foreach($subjectsInSem as $subject)
                                                    <li>{{ $subject }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endif
                                @endforeach

                                @if(!array_filter($grouped))
                                    <em>No subjects selected.</em>
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>

                <a style="margin-top:20px;" class="btn btn-default" href="{{ url()->previous() }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>

@endsection