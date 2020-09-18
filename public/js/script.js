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
            // headers: {"token": localStorage.setItem('token', 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAwMFwvYXBpXC9hdXRoXC9sb2dpbiIsImlhdCI6MTYwMDM0MjI1MCwiZXhwIjoxNjAwMzQ1ODUwLCJuYmYiOjE2MDAzNDIyNTAsImp0aSI6Ik53enM3Z3lIU016aXg3dm4iLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.EjyAeXeUyz-eYzd-PS6qv0B134n5MR8_V7dYsEftj5U')},
            success: function (data) {
                localStorage.setItem("token", 'Bearer ' + data.result);
                console.log(data.user);
                // location.reload()
       
            },

        })
    })
})