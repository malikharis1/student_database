@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('global.create') }} {{ trans('cruds.discipline.title_singular') }}
        </div>

        <div class="card-body">
            <form action="{{ route("admin.disciplines.store") }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="name">{{ trans('cruds.discipline.fields.name') }}*</label>
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>

                @php
                    $subjects = [
                        'Semester 1' => [
                            'English Language',
                            'Financial Accounting',
                            'Mathematics I',
                            'Computer Fundamentals',
                            'Business Economics',
                            'C Programming',
                            'History of India',
                            'Principles of Management',
                            'Environmental Science',
                            'Introduction to Psychology',
                            'Microeconomics',
                            'Digital Literacy',
                            'Political Science I',
                            'Business Mathematics',
                            'Sociology I',
                            'Communication Skills',
                        ],
                        'Semester 2' => [
                            'Advanced English',
                            'Corporate Accounting',
                            'Mathematics II',
                            'Data Structures',
                            'Macroeconomics',
                            'Object-Oriented Programming',
                            'Indian Constitution',
                            'Marketing Management',
                            'Environmental Studies II',
                            'Social Psychology',
                            'Statistics I',
                            'Web Design Fundamentals',
                            'Political Science II',
                            'Business Communication',
                            'Sociology II',
                            'E-Commerce',
                        ],
                        'Semester 3' => [
                            'English Literature',
                            'Cost Accounting',
                            'Discrete Mathematics',
                            'Operating Systems',
                            'Indian Economy',
                            'DBMS',
                            'Medieval Indian History',
                            'HR Management',
                            'Environmental Law',
                            'Cognitive Psychology',
                            'Statistics II',
                            'Computer Networks',
                            'Political Science III',
                            'Organizational Behavior',
                            'Sociology III',
                            'Accounting Software (Tally)',
                        ],
                        'Semester 4' => [
                            'Business Law',
                            'Taxation',
                            'Linear Algebra',
                            'Java Programming',
                            'Development Economics',
                            'Software Engineering',
                            'Modern Indian History',
                            'Financial Management',
                            'Cyber Laws',
                            'Abnormal Psychology',
                            'Operations Research',
                            'Mobile App Development',
                            'Political Science IV',
                            'Production & Operations Mgmt',
                            'Sociology IV',
                            'Business Research Methods',
                        ],
                        'Semester 5' => [
                            'Entrepreneurship',
                            'Auditing',
                            'Numerical Methods',
                            'Python Programming',
                            'International Economics',
                            'Cloud Computing',
                            'World History',
                            'Investment Analysis',
                            'Ethics in IT',
                            'Health Psychology',
                            'Machine Learning',
                            'Information Security',
                            'Political Science V',
                            'Financial Statement Analysis',
                            'Sociology V',
                            'MIS (Management Info Systems)',
                        ],
                        'Semester 6' => [
                            'Project Work',
                            'Strategic Management',
                            'Mathematical Modelling',
                            'Artificial Intelligence',
                            'Public Finance',
                            'Big Data Analytics',
                            'Contemporary World History',
                            'Portfolio Management',
                            'Cyber Security',
                            'Counseling Psychology',
                            'Data Visualization',
                            'E-Governance',
                            'Political Science VI',
                            'Tax Planning & Mgmt',
                            'Sociology VI',
                            'Professional Ethics',
                        ],
                    ];
                @endphp

                @foreach($subjects as $semester => $subs)
                    <div class="form-group mt-4">
                        <label><strong>{{ $semester }} (Select up to 4)</strong></label>
                        <div class="row" id="checkbox-{{ Str::slug($semester) }}">
                            @foreach($subs as $subject)
                                <div class="col-md-6 col-lg-4">
                                    <div class="form-check">
                                        <input type="checkbox" name="subjects[{{ $semester }}][]" value="{{ $subject }}"
                                            class="form-check-input {{ Str::slug($semester) }}-checkbox"
                                            id="{{ Str::slug($semester) . '-' . Str::slug($subject) }}">
                                        <label class="form-check-label"
                                            for="{{ Str::slug($semester) . '-' . Str::slug($subject) }}">
                                            {{ $subject }}
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                <div>
                    <button class="btn btn-danger" type="submit">{{ trans('global.save') }}</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const limits = 4;

            @foreach($subjects as $semester => $subs)
                let checkboxes_{{ Str::slug($semester) }} = document.querySelectorAll('.{{ Str::slug($semester) }}-checkbox');

                checkboxes_{{ Str::slug($semester) }}.forEach(function (box) {
                    box.addEventListener('change', function () {
                        let checkedCount = Array.from(checkboxes_{{ Str::slug($semester) }}).filter(b => b.checked).length;
                        if (checkedCount > limits) {
                            alert('You can only select up to 4 subjects in {{ $semester }}');
                            this.checked = false;
                        }
                    });
                });
            @endforeach
        });
    </script>
@endsection