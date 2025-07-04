<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BlockStudentAdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('student_as_admin')) {
            return $next($request); // not a student, allow
        }

        $restrictedPatterns = [
            'admin/users',
            'admin/users/create',
            'admin/users/*/edit',
            'admin/disciplines',
            'admin/disciplines/*',
            'admin/disciplines/*/edit',
        ];

        foreach ($restrictedPatterns as $pattern) {
            if ($request->is($pattern)) {
                $studentId = session('student_as_admin');
                return redirect()->route('admin.users.show', $studentId);
            }
        }

        return $next($request);
    }
}
