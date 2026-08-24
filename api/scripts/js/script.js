$(document).on("click", ".leadsquareSubmit", function () {
    $('#leadsquareForm').validate({
        submitHandler: function (form) {
            $(".leadsquareSubmit").attr("disabled", true);
            var dataString = new FormData(form);
            dataString.append('method', 'leadsquare_api');
            dataString.append('url', window.location.href);
            var urlParams = new URLSearchParams(window.location.search);
            dataString.append('utms', urlParams.get('utm_source'));
            var lastSegment = new URL(window.location.href).pathname.split('/').filter(Boolean).pop();
            dataString.append('source', lastSegment);
            dataString.append('mx_gclids', urlParams.get('gclid'));
            dataString.append('mx_fbclids', urlParams.get('fbclid'));
            dataString.append('mx_Ad_Name', urlParams.get('utm_content'));
            dataString.append('mx_Ad_Set', urlParams.get('utm_terms'));
            dataString.append('mx_Campaign_Name', urlParams.get('utm_campaign'));
            $.ajax({
                dataType: 'html',
                type: "POST",
                url: "/scripts/ajax/index.php",
                data: dataString,
                cache: false,
                contentType: false,
                processData: false,
                success: function (responseData) {
                    $(".leadsquareSubmit").attr("disabled", false);
                    if (responseData == 0) {
                        $('#popup').modal('show');
                        $('.messageDiv').show();
                        $('#leadsquareForm')[0].reset();
                    }
                },
                error: function (responseData) {
                    console.log('Ajax request not recieved!');
                }
            });
            return false;
        }
    });
});
