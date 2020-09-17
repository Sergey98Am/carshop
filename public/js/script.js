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
            url: 'http://carshop.loc/api/auth/login',
            method: 'post',
            data: form.serialize(),
            headers: {"token": localStorage.getItem('2GT9Kzm6dBNtJGB9Y3Z7tXo4Epa8aNqIOLLL89e9ZM5IExLDEGHTiS4v0cS0ryAx')},
            success: function () {

            
            },

        })
    })
})