function showAnswers(surveyId) {
    $(".answers"+ surveyId).removeClass("hide");
    $(".participate"+ surveyId).addClass("hide");
}

function back(surveyId) {
    $(".answers"+ surveyId).addClass("hide");
    $(".participate"+ surveyId).removeClass("hide");
}

function vote(surveyId, voteId, surveyName) {
    const realSurveyId = surveyId - 1;
    const data = {
        'surveyId': surveyId,
        'voteId': voteId
    };
    const x = document.getElementById("toastr");
    x.textContent = "You successfully voted for the question \"" + surveyName + "\"";
    x.className = "show";

    $.post('includes/scripts/vote.php', data, function (response) {
        console.log("Response: " + response)
    });

    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);

    $(".answers"+ realSurveyId).addClass("hide");
    $(".participate"+ realSurveyId).removeClass("hide");
}