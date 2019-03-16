
$(function() {
    $('button', '#welcome').on('click', function() {
        $('#welcome').addClass('d-none');
        $('#starting').removeClass('d-none');
    });

    $('button', '#starting').on('click', function() {
        $('#starting').addClass('d-none');
        $('#test').removeClass('d-none');
        startQuiz();
    });

    $('button', '#test').on('click', function() {
        validateAnswer();
    });
    $('form[name=answerForm]').on('submit', function() {
        validateAnswer();
    });
});

var equations = [];
var equationHolder;
var correctAnswers, wrongAnswers, pos, seconds, minutes, hours, days, timer, truth;
//Generate Array Equations
for (i=1; i<=12; i++) {
    for (j=1; j<=12; j++){
        answer = i * j;
        equationHolder = new Equation(i, j, answer);
        equations.push(equationHolder);
    }
}

function Equation(value1, value2, answer) {
    this.value1 = value1;
    this.value2 = value2;
    this.answer = answer;
}

function startQuiz() {
    var timeBox = $('#time');
    timeBox.text('0:00');
    correctAnswers = 0, wrongAnswers = 0, pos = 0;
    //shuffle array
    equations = shuffle(equations);
    //display first equation
    updateEquation();
    //start a timer
    seconds = 0, minutes = 0, hours = 0;
    timer = setInterval(updateTime, 1000);
}

function updateEquation() {
    var currentEquation = equations[pos];
    $('#val1').html(currentEquation.value1);
    $('#val2').html(currentEquation.value2);
    $('#answer').val('').focus();
}

function updateTime() {
    var displaySec, displayMin, dataSec, dataMin, dataHour;
    seconds += 1;
    if(seconds === 60){
        minutes += 1;
        seconds = 0;
    }
    if(minutes === 60){
        hours += 1;
        minutes = 0;
    }
    if(hours === 24){
        clearInterval(timer);
    }
    displaySec = (seconds < 10) ? ("0" + seconds) : (seconds);
    displayMin = (hours > 0 && minutes < 10) ? ("0" + minutes) : (minutes);
    if(hours === 0){
        $('#time').text(displayMin + ":" + displaySec);
        truth = displayMin + ":" + displaySec;
    } else {
        $('#time').text(hours + ":" + displayMin + ":" + displaySec);
        truth = hours + ":" + displayMin + ":" + displaySec;
    }
    dataHour = (hours < 10) ? ("0" + hours) : (hours);
    dataMin = (minutes < 10) ? ("0" + minutes) : (minutes);
    dataSec = displaySec;
    truth = dataHour + ":" + dataMin + ":" + dataSec;
}

function nextEquation() {
    pos += 1;
    if(pos >= 144){
        pos = 0;
    }
    updateEquation();
}

function validateAnswer() {
    var answerInput = $('#answer');
    answerInput.removeClass('is-invalid');
    var input = answerInput.val();
    if(input == ""){
        answerInput.addClass('is-invalid').focus();
        return false;
    }
    checkAnswer(input);
}

function checkAnswer(input) {
    var currentEquation = equations[pos];
    if(input == currentEquation.answer){
        correctAnswers += 1;
    }
    else{
        wrongAnswers += 1;
    }
    if (correctAnswers >= 2){
        clearInterval(timer);
        completeQuiz();
    }
    else{
        nextEquation();
    }
}

function completeQuiz() {
    $('#correct', '#finish').text(correctAnswers);
    $('#incorrect', '#finish').text(wrongAnswers);
    var time = $('#time').text();
    $('#timeResult', '#finish').text(time);
    commitScore();
    $('#test').addClass('d-none');
    $('#finish').removeClass('d-none');
}

function commitScore() {
    $.ajax({
        type: "POST",
        url: "/leaderboard/store",
        data: {
            truth: truth,
            _token: $('meta[name="csrf-token"]').attr('content')
        },
        success: function(result) {
            console.log(result);
            $('#userToken').val(result);
            $('#submit').removeAttr('disabled').html('Submit');
        },
        error: function(xhr) {
            alert("There was an error with the request.")
        }
    });
}

function shuffle(array) {
  var currentIndex = array.length, temporaryValue, randomIndex;

  // While there remain elements to shuffle...
  while (0 !== currentIndex) {

    // Pick a remaining element...
    randomIndex = Math.floor(Math.random() * currentIndex);
    currentIndex -= 1;

    // And swap it with the current element.
    temporaryValue = array[currentIndex];
    array[currentIndex] = array[randomIndex];
    array[randomIndex] = temporaryValue;
  }

  return array;
}