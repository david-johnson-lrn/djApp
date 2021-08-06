$(document).ready(function () {

    let stateFlag = false;
    let topicFlag = false;


    $(".intro").on("click", function () {
        if ($(this).attr('id') === 'yes') {

            $("#intro").addClass('hide')
            $("#content").removeClass('hide')
        }

    })


    $('.choice').on("click", function () {

        //controlling form to serve a topic and a state from user input
        if ($(this).attr('name') === 'topic') {
            $("#topic").val($(this).val())
        } else {
            $("#state").val($(this).val())
        }

        //only one option can be selected at once
        $(this).toggleClass("active");
        $(this).siblings().removeClass("active");


        //control flags to ensure one option is picked from both categories
        if ($(this).val() === 'Geography' || $(this).val() === 'Politics' || $(this).val() === 'History') {
            topicFlag = true;
            console.log(topicFlag);
        }
        if ($(this).val() === 'NY' || $(this).val() === 'NJ' || $(this).val() === 'PA' || $(this).val() === 'CT' || $(this).val() === 'MA') {
            stateFlag = true;
            console.log(topicFlag);
        }

        //shows submit button only if one option from both categories are selected

        if (stateFlag && topicFlag === true) {
            $("#submitBtn").removeClass("hide");
        }


    })








})