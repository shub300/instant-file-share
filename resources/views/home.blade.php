<!DOCTYPE html>
<html>
<!-- begin::Head -->

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.4.1/css/mdb.min.css" />
    <link rel="stylesheet" href="{{ asset('public/plugins/snackbar/snackbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/css/home.css') }}">
    <style>

    </style>
</head>
<!-- end::Head -->
<!-- end::Body -->

<body>

    <div class="container">
        <div class="row mt-10 ml-10 mr-10 ">
            <div class="col-md-12 col-sm-12 col-xs-12 item_row">
                <h2 class="text-center">Live File Sharing</h2>
                <input type="hidden" id="fileiconpath" value="{{ asset('public/assets/images/file_icon2.png') }}" />
                <div id="dropzone">
                    <form action="{{ url('UpdateFile') }}" method="post" class="dropzone" id="uploadWidget">
                        <div id="upload_container" class="dz-message needsclick">
                            <span class="text">
                                <img style="width: 30px;" src="{{ asset('public/assets/images/file_icon.png') }}"
                                    alt="file icon" />
                                Drop files here or click to upload.
                            </span>
                        </div>
                        <div id="preview_container">
                            <div id="dropzoneerror" class="dz-preview dz-file-preview">
                                <div class="dz-image"><img data-dz-thumbnail /></div>
                                <div class="dz-details">
                                    <div class="dz-size"><span data-dz-size></span></div>
                                    <div class="dz-filename"><span data-dz-name></span></div>
                                </div>
                                {{-- <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div> --}}
                                <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                <div data-dz-remove class="dz-error-mark">
                                    <i class="fa fa-5x fa-times-circle-o remove-file"
                                        style="font-size: 40px;position: absolute;left: 8px;top: 7px;color: #fff;opacity: 0.9;"></i>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-md-12">
                <button type="button" class="btn upload-btn pull-right" id="update-btn" style=""><i
                        class="fa fa-upload"></i> Upload </button>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <main>
                    <!--MDB Tables-->
                    <div class="container mt-4">
                        <div class="card mb-4">
                            <div class="card-body">
                                <!--Table-->
                                <table class="table table-hover">
                                    <!--Table head-->
                                    <thead class="mdb-color darken-3">
                                        {{-- <tr class="text-white"><th colspan="3">File List</th></tr> --}}
                                        <tr class="text-white">
                                            <th></th>
                                            <th>File Name</th>
                                            {{-- <th></th> --}}
                                        </tr>
                                    </thead>
                                    <!--Table head-->
                                    <!--Table body-->
                                    <tbody class="file-list">
                                        {{-- <tr>
										<th scope="row"></th>
										<td></td>
									</tr> --}}
                                    </tbody>
                                    <!--Table body-->
                                </table>
                                <!--Table-->
                            </div>
                        </div>

                    </div>
                    <!--MDB Tables-->
                </main>
            </div>
        </div>
    </div>
</body>

</html>


<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- Latest compiled JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.2/dropzone.min.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.blockUI/2.70/jquery.blockUI.min.js" crossorigin="anonymous">
</script>
<script src="{{ asset('public/plugins/snackbar/snackbar.min.js') }}"></script>
<script src="{{ asset('public/js/app.js') }}"></script>
<script>
    var filecount = 0;
    if (filecount == '0') {
        new_row = '<tr><td><td><a class="alink"  href="javascript:void(0);">No files sent or received</a></td></tr>';
        $('.file-list').prepend(new_row);
    }

    var previewNode = document.querySelector("#dropzoneerror");
    previewNode.id = "";
    var mid = ''; // Message id to detect if same person has sent the msg to avoid reprinting
    var previewTemplate = previewNode.parentNode.innerHTML;
    previewNode.parentNode.removeChild(previewNode);
    Dropzone.options.uploadWidget = {
        // paramName: 'file',
        url: "{{ url('UpdateFile') }}",
        maxFilesize: 100, // MB
        // maxFiles: 10,
        uploadMultiple: true,
        previewTemplate: previewTemplate,
        autoQueue: false, // Make sure the files aren't queued until manually added
        previewsContainer: "#preview_container", // Define the container to display the previews
        dictDefaultMessage: 'Drag an image here to upload, or click to select one',

        init: function() {

            var myDropzone = this;
            /* 'submit-dropzone-btn' is the ID of the form submit button */
            document.getElementById('update-btn').addEventListener("click", function(e) {
                e.preventDefault();

                myDropzone.emit("sendingmultiple");
            });
            this.on('success', function(file, resp) {
                console.log(file);

            });

            this.on('addedfile', function(file, resp) {

            });
            this.on("sendingmultiple", function(file, xhr, formData) {
                if (myDropzone.files.length == 0) {
                    Snackbar.show({
                        text: 'Please select a file',
                        showAction: true,
                        pos: 'bottom-center',
                        actionTextColor: '#fff'
                    });
                    return false;
                }


                formData = new FormData();
                for (i = 0; i < myDropzone.files.length; i++) {
                    file = myDropzone.files[i];
                    formData.append("files[]", file);
                }

                formData.append('_token', "{{ csrf_token() }}");



                $.ajax({
                    url: "{{ url('UpdateFile') }}",
                    data: formData,
                    dataType: "json",
                    async: true,
                    beforeSend: function(xhr) {
                        $('#dropzone').block({
                            message: '<h4><i class="fa fa-upload"></i> Uploading..</h4>',
                            css: {}
                        });
                    },
                    type: "post",
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        $('#dropzone').unblock();
                        profile_ret = response;
                        if (profile_ret.status_code == "1") {
                            myDropzone.removeAllFiles(true);
                            Snackbar.show({
                                text: profile_ret.status_text,
                                showAction: true,
                                pos: 'bottom-center',
                                actionTextColor: '#fff'
                            });
                            mid = profile_ret.mid;
                            renderResponse(profile_ret.data);
                        } else {
                            Snackbar.show({
                                text: profile_ret.status_text,
                                showAction: true,
                                pos: 'bottom-center',
                                actionTextColor: '#fff'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        $('#dropzone').unblock();
                        if (jqXHR.status == 500) {
                            errMsg = 'Internal error: ' + jqXHR.responseText;
                        } else {
                            errMsg = "Unexpected error Please try again.";
                        }
                        Snackbar.show({
                            text: errMsg,
                            showAction: true,
                            pos: 'bottom-center',
                            actionTextColor: '#fff'
                        });
                    }
                });
            })
            this.on("error", function(file, message) {
                console.log(message);
                this.removeFile(file);
            });
            this.on("complete", function(file) {
                this.removeAllFiles(true);
            })
        }
    };

    function inArray(needle, haystack) {
        var length = haystack.length;
        for (var i = 0; i < length; i++) {
            if (haystack[i] == needle) return true;
        }
        return false;
    }

    function renderResponse(arrdata, newmsg = 0) {
        $('.dot').remove();
        $('tr').removeClass('new-file');

        if (filecount == '0') {
            $('.file-list').html('');
        }
        for (j in arrdata) {
            filecount++;
            var res = arrdata[j];
            if (inArray(res.ext, ['png', 'jpeg', 'jpg', 'gif'])) {
                file_path = res.path;
            } else {
                file_path = $('#fileiconpath').val();
            }
            dot = '';
            new_file_class = '';
            if (newmsg) {
                dot = " <i class='dot'></i>&nbsp";
                new_file_class = 'new-file';
            }
            new_row = '<tr class="' + new_file_class + '"><td>' + '<img class="img-circle img-icon" src="' + file_path +
                '"/></td>' + '<td><a class="alink" target="_blank" href="' + res.path + '">' + dot + res.name +
                '</a></td></tr>';
            $('.file-list').prepend(new_row);
        }
        $('#filecount').val(filecount);
        if (newmsg) {
            Snackbar.show({
                text: 'New file received',
                showAction: true,
                pos: 'bottom-center',
                actionTextColor: '#fff'
            });
        }
    }

    Echo.channel('new-file').listen('fileSendMessage', (e) => {
        window.setTimeout(() => {
            newmsg = e.messageArr;
            if (newmsg.status_code == 1 && mid != newmsg
                .mid) { // If msg is not sent by the same browser
                renderResponse(newmsg.data, 1);
            }
        }, 100);

    })

</script>
