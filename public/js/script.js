$(document).ready(function () {
    //DateTime
    function dateTime() {
        $('#date_of_birth').datepicker({
            dateFormat: 'yy-mm-dd',
            changeYear: true,
            changeMonth: true,
        });
    }
    dateTime()
    //end DateTime


    $('.login').on('submit', function (e) {
        e.preventDefault()
        var form = $(this);
        
        $.ajax({
            url: 'http://car-shop.loc/api/auth/login',
            method: 'post',
            data: form.serialize(),
            success: function (data) {
                localStorage.setItem("token", "Bearer " + data.token);
                window.location.href = 'http://car-shop.loc/profile';
                
                // $.ajax({
                //     url: "http://car-shop.loc/api/get_user_details",
                //     method: "post",
                //     headers: {"authorization": localStorage.getItem("token")},
                //     success: function (response) {
            
                
                //     }
                // });
            },

        })
    })
})

