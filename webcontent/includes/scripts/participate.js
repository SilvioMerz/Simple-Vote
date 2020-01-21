function showAnswers(surveyId) {
    $(".answers" + surveyId).removeClass("hide");
    $(".participate" + surveyId).addClass("hide");
    $(".result" + surveyId).addClass("hide");
}

function closeParticipate(surveyId) {
    $(".answers" + surveyId).addClass("hide");
    $(".participate" + surveyId).removeClass("hide");
    $(".result" + surveyId).removeClass("hide");
}

function vote(surveyId, voteId, surveyName) {
    const surveyIndex = surveyId - 1;
    const data = {
        'surveyId': surveyId,
        'voteId': voteId
    };
    const x = document.getElementById("toastr");
    x.textContent = "You successfully voted for the question \"" + surveyName + "\"";
    x.className = "show";

    $.post('includes/scripts/insertVote.php', data, function (response) {
        console.log("Response: " + response)
    });

    setTimeout(function () {
        x.className = x.className.replace("show", "");
    }, 3000);

    $(".answers" + surveyIndex).addClass("hide");
    $(".participate" + surveyIndex).removeClass("hide");
    $(".result" + surveyIndex).removeClass("hide");
}

function showResult(surveyIndex, surveyId) {
    const openedResults = $('div.poll1').length;
    if (openedResults > 0) {
        const x = document.getElementById("toastr");
        x.textContent = "Please close other results first.";
        x.className = "show";
        setTimeout(function () {
            x.className = x.className.replace("show", "");
        }, 3000);
    } else {
        xmlHttpRequest();
        xmlhttp.onreadystatechange = function () {
            if (this.readyState === 4 && this.status === 200) {
                document.getElementById("survey" + surveyIndex).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "includes/scripts/getResult.php?survey=" + surveyId, true);
        xmlhttp.send();
    }
}

function closeResult(surveyIndex, surveyId) {
    xmlHttpRequest();
    xmlhttp.onreadystatechange = function () {
        if (this.readyState === 4 && this.status === 200) {
            document.getElementById("survey" + surveyIndex).innerHTML = this.responseText;
        }
    };
    xmlhttp.open("GET", "includes/scripts/getQuestion.php?survey=" + surveyId, true);
    xmlhttp.send();
}

function xmlHttpRequest() {
    if (window.XMLHttpRequest) {
        xmlhttp = new XMLHttpRequest();
    } else {
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
}
