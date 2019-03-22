@extends('layout.layout')

<!-- start body -->
@section('content')
<div class="container justify-content-center h-100vh">
    <div class="row h-100vh align-items-center">
        <!-- WELCOME SECTION (DEFAULT) -->
        <div id="welcome" class="col text-center">
            <h1 class="display-3 d-none d-md-block">TimesTables</h1>
            <h1 class="display-5 d-md-none">TimesTables</h1>
            <h4>Think you know your times tables? Prove it!</h4>
            <button type="button" class="btn btn-primary mt-2">Take the Quiz!</button>
        </div>
        <!-- INSTRUCTIONS SECTION -->
        <div id="starting" class="col d-none text-center">
            <h3 class="display-4">Instructions</h3>
            <h5>Answer 20 multiplication questions correctly as quickly as you can.</h5>
            <button class="btn btn-primary mt-2">Begin</button>
        </div>
        <!-- TEST SECTION -->
        <div id="test" class="col d-none">
            <div class="row text-center">
                <div class="col">
                    <h4 class="display-5">Quiz</h4>
                </div>
                <div class="col">
                    <h4 id="time" class="display-5"></h4>
                </div>
            </div>
            <hr>
            <div class="row">
                <div class="col-1 offset-6 text-right">
                    <span id="val1" class="h3"></span>
                </div>
            </div>
            <div class="row">
                <div class="col-1 offset-5" style="border-bottom: 2px solid black;">
                    <span class="h3">x</span>
                </div>
                <div class="col-1 text-right" style="border-bottom: 2px solid black;">
                    <span id="val2" class="h3"></span>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-3 mx-auto">
                    <form name="answerForm" onsubmit="event.preventDefault(); return false;">
                        <input type="number" name="answer" id="answer" class="form-control" autocomplete="off">
                        <div class="invalid-feedback">
                            Take a guess!
                        </div>
                    </form>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col text-center">
                    <button type="submit" form="answerForm" class="btn btn-primary">Done</button>
                </div>
            </div>
        </div>
        <!-- FINISH SECTION -->
        <div id="finish" class="col d-none">
            <div class="row">
                <div class="col text-center">
                    <h3 class="display-4">Results</h3>
                    <div class="h5">
                        You answered
                        <span class="text-success">
                            <span id="correct">20</span> correctly
                        </span> in
                        <strong><span id="timeResult"></span></strong> with
                        <span class="text-danger">
                            <span id="incorrect" class="text-danger"></span> incorrect
                        </span> answers!
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-6 col-xl-4 offset-md-3 offset-xl-4">
                            <form name="finishForm" method="POST" action="/leaderboard">
                                @csrf
                                <div class="form-group">
                                    <label for="name">Enter your name for the leadboard</label>
                                    <input type="text" name="name" id="name" class="form-control" minlength="3" required>
                                    <div class="invalid-feedback">
                                        Please enter your name
                                    </div>
                                </div>
                                <input type="hidden" name="userToken" id="userToken" class="form-control">
                                <button type="submit" name="submit" id="submit" class="btn btn-primary mt-2" disabled>
                                    <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                    Loading...
                                </button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function() {
            $('#home-link').addClass('active');
        });
    </script>
@endsection
