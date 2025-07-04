<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Student;

class StudentStatusChanged extends Mailable
{
    use Queueable, SerializesModels;

    public $student;
    public $statusText;

    public function __construct(Student $student, $statusText)
    {
        $this->student = $student;
        $this->statusText = $statusText;
    }

    public function build()
    {
        return $this->subject('Account ' . $this->statusText)
            ->view('emails.student_status');
    }
}
