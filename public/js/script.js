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
            headers: {"token": localStorage.getItem('Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC9jYXJzaG9wLmxvY1wvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwMDMzMTQyMywiZXhwIjoxNjAwMzM1MDIzLCJuYmYiOjE2MDAzMzE0MjMsImp0aSI6IkRibGNHdlBMM0RNbU1zTk0iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.DBQj_OnZ0_KFt6UaJM0alZpVWsjcJ-igzlFktUTOfsg')},
            success: function () {

            
            },

        })
    })
})