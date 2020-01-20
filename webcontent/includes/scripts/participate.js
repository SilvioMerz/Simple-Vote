function showAnswers(surveyId) {
    $(".answers"+ surveyId).removeClass("hide");
    $(".participate"+ surveyId).addClass("hide");
}

function back(surveyId) {
    $(".answers"+ surveyId).addClass("hide");
    $(".participate"+ surveyId).removeClass("hide");
}

function vote(surveyId, voteId) {
    const realSurveyId = surveyId - 1;
    const data = {
        'surveyId': surveyId,
        'voteId': voteId
    };

    $.post('includes/scripts/vote.php', data, function (response) {
        console.log("Response: " + response)
    });

    $(".answers"+ realSurveyId).addClass("hide");
    $(".participate"+ realSurveyId).removeClass("hide");
}