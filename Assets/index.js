$(document).ready(function () {


    $('button').on("click", function () {


        console.log($(this).attr('name'));
        console.log($(this).val())


        if ($(this).attr('name') === 'topic') {
            $("#topic").val($(this).val())
        } else {
            $("#state").val($(this).val())
        }


        $("#submitBtn").removeClass("hide");




    })


    $("#submitBtn").on("click", function () {
        $("#appear").removeClass("hide");

    })






})