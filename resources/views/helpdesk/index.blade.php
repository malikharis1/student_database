@extends('layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header">Help Desk</div>

        <div class="card-body">
            @if(!session()->has('admin')) {{-- Show form only if not admin --}}
                <form method="POST" action="{{ route('admin.help-desks.store') }}">
                    @csrf
                    <div class="form-group">
                        <label for="message">Your Complaint/Request</label>
                        <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                    </div>
                    <button class="btn btn-primary mt-2">Submit</button>
                </form>
            @endif

            <hr>

            <h5 class="mt-4">
                {{ session()->has('admin') ? 'All Complaints' : 'Your Submitted Tickets' }}
            </h5>

            <table class="table table-bordered mt-2">
                <thead>
                    <tr>
                        <th>#</th>
                        @if(session()->has('admin'))
                            <th>Registration No</th>
                        @endif
                        <th>Message</th>
                        <th>Status</th>
                        <th>Submitted At</th>
                        @if(session()->has('admin'))
                            <th>Change Status</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($complaints as $ticket)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    @if(session()->has('admin'))
                                        <td>{{ $ticket->student->registration_number ?? 'N/A' }}</td>
                                    @endif
                                    <td>{{ $ticket->message }}</td>
                                    <td>
                                        <span class="badge badge-{{ 
                                                                                    $ticket->status == 'pending' ? 'warning' :
                        ($ticket->status == 'completed' ? 'success' : 'danger') 
                                                                                }}">
                                            {{ ucfirst($ticket->status) }}
                                        </span>
                                    </td>
                                    <td>{{ $ticket->created_at->diffForHumans() }}</td>
                                    @if(session()->has('admin'))
                                        <td>
                                            <form method="POST" action="{{ route('admin.help-desks.updateStatus', $ticket->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="pending" {{ $ticket->status == 'pending' ? 'selected' : '' }}>Pending
                                                    </option>
                                                    <option value="completed" {{ $ticket->status == 'completed' ? 'selected' : '' }}>Completed
                                                    </option>
                                                    <option value="cancelled" {{ $ticket->status == 'cancelled' ? 'selected' : '' }}>Cancelled
                                                    </option>
                                                </select>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                    @empty
                        <tr>
                            <td colspan="{{ session()->has('admin') ? '6' : '4' }}">No complaints submitted.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection