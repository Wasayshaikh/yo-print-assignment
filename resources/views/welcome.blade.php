<!DOCTYPE html>
<html lang="en">
  <head>
    <title>horizon Drag and Drop Files</title>
    <meta charset="UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width" />
    <link rel="stylesheet" href="styles.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <style>
        html, body {
  height: 100%;
}

body {
  /* background-image: linear-gradient( 102.7deg, rgba(253,218,255,1) 8.2%, rgba(223,173,252,1) 19.6%, rgba(173,205,252,1) 36.8%, rgba(173,252,244,1) 73.2%, rgba(202,248,208,1) 90.9% ); */
  color: #333333;
  font-family: sans-serif;
}

.content-container{
  height: 100%;
    padding: 0;
    margin: 0;
    display: flex;
    /* align-items: center; */
    justify-content: center;
    padding-top:25px;
    flex-wrap:wrap;
}

.file-drop-area {
  position: relative;
  display: flex;
  align-items: center;
  width: 50%;
  max-width: 100%;
  padding: 25px;
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 10px 20px rgba(0,0,0,.1);
  transition: .3s;
  height:80px;
  justify-content:space-between;
}
.file-drop-area.is-active {
  background-color: #1a1a1a;
}

.fake-btn {
  flex-shrink: 0;
  background-color: #9699b3;
  border-radius: 3px;
  padding: 8px 15px;
  margin-right: 10px;
  font-size: 12px;
  text-transform: uppercase;
}

.file-msg {
  color: #9699b3;
  font-size: 16px;
  font-weight: 300;
  line-height: 1.4;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.item-delete {
  display: none;
  position: absolute;
  right: 10px;
  width: 18px;
  height: 18px;
  cursor: pointer;
}

.item-delete:before {
  content: "";
  position: absolute;
  left: 0;
  transition: .3s;
  top: 0;
  z-index: 1;
  width: 100%;
  height: 100%;
  background-size: cover;
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%23bac1cb' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
}

.item-delete:after {
  content: "";
  position: absolute;
  opacity: 0;
  left: 50%;
  top: 50%;
  width: 100%;
  height: 100%;
  transform: translate(-50%, -50%) scale(0);
  background-color: #f3dbff;
  border-radius: 50%;
  transition: .3s;
}

.item-delete:hover:after {
  transform: translate(-50%, -50%) scale(2.2);
  opacity: 1;
}

.item-delete:hover:before {
  background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg fill='%234f555f' xmlns='http://www.w3.org/2000/svg' viewBox='0 0 438.5 438.5'%3e%3cpath d='M417.7 75.7A8.9 8.9 0 00411 73H323l-20-47.7c-2.8-7-8-13-15.4-18S272.5 0 264.9 0h-91.3C166 0 158.5 2.5 151 7.4c-7.4 5-12.5 11-15.4 18l-20 47.7H27.4a9 9 0 00-6.6 2.6 9 9 0 00-2.5 6.5v18.3c0 2.7.8 4.8 2.5 6.6a8.9 8.9 0 006.6 2.5h27.4v271.8c0 15.8 4.5 29.3 13.4 40.4a40.2 40.2 0 0032.3 16.7H338c12.6 0 23.4-5.7 32.3-17.2a64.8 64.8 0 0013.4-41V109.6h27.4c2.7 0 4.9-.8 6.6-2.5a8.9 8.9 0 002.6-6.6V82.2a9 9 0 00-2.6-6.5zm-248.4-36a8 8 0 014.9-3.2h90.5a8 8 0 014.8 3.2L283.2 73H155.3l14-33.4zm177.9 340.6a32.4 32.4 0 01-6.2 19.3c-1.4 1.6-2.4 2.4-3 2.4H100.5c-.6 0-1.6-.8-3-2.4a32.5 32.5 0 01-6.1-19.3V109.6h255.8v270.7z'/%3e%3cpath d='M137 347.2h18.3c2.7 0 4.9-.9 6.6-2.6a9 9 0 002.5-6.6V173.6a9 9 0 00-2.5-6.6 8.9 8.9 0 00-6.6-2.6H137c-2.6 0-4.8.9-6.5 2.6a8.9 8.9 0 00-2.6 6.6V338c0 2.7.9 4.9 2.6 6.6a8.9 8.9 0 006.5 2.6zM210.1 347.2h18.3a8.9 8.9 0 009.1-9.1V173.5c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a8.9 8.9 0 00-9.1 9.1V338a8.9 8.9 0 009.1 9.1zM283.2 347.2h18.3c2.7 0 4.8-.9 6.6-2.6a8.9 8.9 0 002.5-6.6V173.6c0-2.7-.8-4.9-2.5-6.6a8.9 8.9 0 00-6.6-2.6h-18.3a9 9 0 00-6.6 2.6 8.9 8.9 0 00-2.5 6.6V338a9 9 0 002.5 6.6 9 9 0 006.6 2.6z'/%3e%3c/svg%3e");
}

.file-input {
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  width: 100%;
  cursor: pointer;
  opacity: 0;
}
.file-input:focus {
  outline: none;
}
.table-container{
    width: 60%;
}
    </style>
  </head>
  <body>
    <div class="content-container">
    <div class="file-drop-area">
    <span class="file-msg">or drop files here</span>
    <span class="fake-btn">Choose files</span>
    <input class="file-input" type="file" multiple>
    <div class="item-delete"></div>
  </div>
  <div class="table-container">
  <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">File Name</th>
      <th scope="col">Status</th>
      <th scope="col">Uploaded At</th>
    </tr>
  </thead>
  <tbody>
    @foreach($files as $file)
    <tr>
      <th scope="row">{{$file->id}}</th>
      <td>{{$file->name}}</td>
      <td>{{$file->status}}</td>
      <td>{{date('Y-m-d/H:i:s',strtotime($file->created_at))}}</td>
    </tr>
    <tr>
    @endforeach
</table>
  </div>
</div>
<script src="//{{ Request::getHost() }}:6001/socket.io/socket.io.js"></script>
  <script src="{{ URL::asset('js/laravel-echo-setup.js')}}" type="text/javascript"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
  <script src="script.js"></script>
  <script>
    const $fileInput = $('.file-input');
const $droparea = $('.file-drop-area');
const $delete = $('.item-delete');

$fileInput.on('dragenter focus click', function () {
  $droparea.addClass('is-active');
});

$fileInput.on('dragleave blur drop', function () {
  $droparea.removeClass('is-active');
});

$fileInput.on('change', function () {
  let filesCount = $(this)[0].files.length;
  let $textContainer = $(this).prev();

  if (filesCount === 1) {
    let fileName = $(this).val().split('\\').pop();
    $textContainer.text(fileName);
    $('.item-delete').css('display', 'inline-block');
  } else if (filesCount === 0) {
    $textContainer.text('or drop files here');
    $('.item-delete').css('display', 'none');
  } else {
    $textContainer.text(filesCount + ' files selected');
    $('.item-delete').css('display', 'inline-block');
  }
  uploadFileAsync($(this)[0].files[0]);
});

$delete.on('click', function () {
  $('.file-input').val(null);
  $('.file-input').files(null);
  $('.file-msg').text('or drop files here');
  $('.item-delete').css('display', 'none');
});


function uploadFileAsync(file) {
  const formData = new FormData();
  formData.append('file', file);

  $.ajax({
    url: '/uploads', // Replace with the URL where you handle the file upload on the server
    headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
    type: 'POST',
    data: formData,
    processData: false,
    contentType: false,
    success: function (response) {
      // Handle the response from the server (e.g., display a success message)
      console.log('File uploaded successfully:', response);
      $('.file-input').val(null);
  $('.file-input')[0].files = null;
    },
    error: function (error) {
      // Handle any errors that occur during the upload
      console.error('Error uploading file:', error.responseText);
    },
  });
}
  </script>
  <script>
    window.laravel_echo_port = '{{env("LARAVEL_ECHO_PORT")}}'
  </script>
 
  
  <script type="text/javascript">

    Echo.channel('upload').listen('FileUploadEvent', (e) => {
      console.log(e.message);
    if (e.message === 'uploading') {
        console.log('File upload started...');
    } else if (e.message === 'processing') {
        console.log('File upload finished!');
    }
    else {
        console.log('File upload finished!');
    }
});
  </script>
  </body>
</html>