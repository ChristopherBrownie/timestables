@extends('layout.layout')

@section('content')
    <div class="container justify-content-center">
        <div class="row pt-5">
            <div class="col"></div>
        </div>
        @if(!is_null($player))
            <div class="row my-5">
                <div class="col table-responsive">
                    <h5>Your Recent Entry</h5>
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Rank</th>
                                <th scope="col">Name</th>
                                <th scope="col">Time</th>
                                {{-- <th scope="col">Created At</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th scope="row">{{ $player->rank }}</th>
                                <td>{{ $player->name }}</td>
                                <td>{{ $player->completionTime }}</td>
                                {{-- <td>{{ $user->created_at }}</td> --}}
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
        <div class="row my-5">
            <div class="col table-responsive">
                <h3>Worldwide Leaderboard</h3>
                <table class="table table-sm table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Time</th>
                            {{-- <th scope="col">Created At</th> --}}
                        </tr>
                    </thead>
                    @php
                        $starting = ($users->currentPage() - 1) * 20
                    @endphp
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $loop->iteration + $starting }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->completionTime }}</td>
                                {{-- <td>{{ $user->created_at }}</td> --}}
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col">
                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#leaderboard-link').addClass('active');
        });
    </script>
@endsection