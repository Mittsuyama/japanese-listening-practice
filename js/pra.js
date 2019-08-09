function strHeadJudge(cor, user) {
    var user_len = user.length;
    var cor_len = cor.length;
    if(user_len > cor_len) return false;
    for(var i = 0; i < user_len; i++) {
        if(cor[i] != user[i]) return false;
    }
    return true;
}

function strAllJudge(cor, user) {
    var user_len = user.length;
    var cor_len = cor.length;
    if(user_len != cor_len) return false;
    for(var i = 0; i < user_len; i++) {
        if(cor[i] != user[i]) return false;
    }
    return true;
}

function audioPlayAgain() {
    var audio = document.getElementById("bgaudio");
    audio.currentTime = 0;
    audio.play(); 
}

function getQueryVariable(variable)
{
    var query = window.location.search.substring(1);
    var vars = query.split("&");
    for (var i = 0;i < vars.length; i++) {
        var pair = vars[i].split("=");
        if(pair[0] == variable) return pair[1];
    }
    return(false);
}

$(function() {
    window.onload = audioPlayAgain();
    var inputs = $(".blank");
    
    $(".blank").each(function() {
        var len = $(this).attr("title").length;
        len *= 35;
        $(this).css("width", len + "px");
    });
    $(".blank")[0].focus();

    $(document).keyup(function(e) {
        key_code = e.keyCode;
        if(key_code == 48) {
            audioPlayAgain();
        }
    });

    $(".blank").keydown(function(e) {
        key_code = e.keyCode;
        var userInput = $(this).val();
        var corInput = $(this).attr("title");
        var idx = inputs.index(this);
        console.log(key_code);
        if(key_code == 13 && strAllJudge(corInput, userInput) && idx == inputs.length - 1) {
            var q_id = parseInt(getQueryVariable("id"));
            var q_page = parseInt(getQueryVariable("page"));
            window.location.href = "pra.php?id=" + q_id + "&" + "page=" + (q_page + 1);
        }
        if(key_code == 32 && strAllJudge(corInput, userInput)) {
            if(idx < inputs.length - 1) inputs[idx + 1].focus();
            if(e.preventDefault) {
                e.preventDefault();
            }
            else {
                e.returnValue = false;
            }
            return;
        }
    }).on('input propertychange', function() {
        var userInput = $(this).val();
        var corInput = $(this).attr("title");
        if(userInput) {
            if(!strHeadJudge(corInput, userInput)) {
                $(this).css("color", "#f22613");
            }
            else {
                if(strAllJudge(corInput, userInput)) {
                    $(this).css("color", "#2ecc71");
                }
                else $(this).css("color", "black");
            }
        }
    });
});