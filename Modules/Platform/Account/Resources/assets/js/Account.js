var BAP_Account = {

    init: function () {

        this.uploadProfilePicture();

        this.sendTestEmail();
    },

    sendTestEmail: function(){

        $(document).on('click','#send_test_email_btn', function(e){

            $.ajax({
                type: "POST",
                url: '/account/send-test-email',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {

                },
                dataType: 'json',
                success: function (result) {
                    if(result.status){
                        BAP_Common.showNotification('bg-green', result.message);
                    }else{
                        BAP_Common.showNotification('bg-red', result.message);
                    }
                }
            });
        });

    },

    uploadProfilePicture: function(){

        $('#profile_picture').fileinput({
            dropZoneEnabled: false,
            uploadAsync: false,
            showUpload: false,
            showRemove: false,
            showCaption: true,
            maxFileCount: 1,
            showBrowse: true,
            browseOnZoneClick: true,
        });

    },


}

BAP_Account.init();
