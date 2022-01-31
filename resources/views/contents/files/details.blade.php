@extends('layouts.frontend')
@section('title','Files Details')

@section('content')
{{-- send to web socket with js --}}
<script type="text/javascript">
    $(document).ready(function () {

        var socket = io.connect('http://127.0.0.1:5000');

        socket.on('connect', function () {
            // console.log('User has connected!');
        });

        socket.on('message', function (msg) {
            console.log(msg);
        });

        $('#sendbutton').on('click', function () {
            socket.send($('#cell').val());
            $('#myMessage').val('');
        });

    });
</script>
<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Upload File &raquo; Detail &raquo; {{ $files->filename}}</h1>
    </div>
    <!-- Start Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Table Files</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <div class="d-sm-flex align-items-center justify-content-between mb-1">
                    {{-- Column --}}
                    <input type="text" class="get-column" id="get-column" value="Column" disabled>
                    <!-- send to socketio -->
                    <form action="{{route('file-details', $files->id)}}" method="POST">
                        @csrf
                        <div class="input-group mb-1 justify-content-end">
                            {{-- input yang akan dikirim ke flask-socketio --}}
                            <input type="text" id="cell" hidden>

                            {{-- input search for similiar sentence "hanya display" yang tidak ada hubungan dengan web socket--}}
                            <input type="text" id="myMessage" placeholder="Look For Similar...">
                            <button class="btn btn-outline-primary" id="sendbutton" name="file-details" value="details">
                                <i class="far fa-paper-plane"></i>
                            </button>
                        </div>  
                    </form>
                    </div>
                {{-- input untuk mengambil value, guna memberikan value ke javascript --}}
                <input type="text" id="json" value="{{$response}}" hidden>

                {{-- table spreadsheet dari jspreadsheet Ce --}}
                <div id="spreadsheet"></div>

                <ul>
                    <li class="small">The Download Button Will Download In .XLS Format</li>
                    <li class="small">If You Want To Format CSV Press Table Then Press CTRL + S</li>
                </ul>

                <div class="d-flex justify-content-right">
                    <form action="{{route('json_edit')}}" method="post">
                            @csrf
                            {{-- input untuk mengirim data json dan filename ke controller, controller ke redis --}}
                            <input type="text" value="{{$files->filename}}" name="filename" id="filename" hidden>
                            <input type="text" id="json-input" name="data" hidden>

                            {{-- Update --}}
                            <button type="submit" class="btn btn-success btn-icon-split m-2" onclick="document.getElementById('json-input').value = JSON.stringify(json)">
                                <span class="icon text-white-50">
                                    <i class="far fa-edit"></i>
                                </span>
                                <span class="text">Update</span>
                            </button>

                            {{-- Save/Export/Download --}}
                            <a type="button" class="btn btn-secondary btn-icon-split m-2" href="{{route('path',$files->id)}}" name="message" value="back-data">
                                <span class="icon text-white-50">
                                    <i class="fas fa-sync-alt"></i>
                                </span>
                                <span class="text">Set Original Data</span>
                            </a>

                            {{-- Save/Export/Download --}}
                            <button type="button" class="btn btn-primary btn-icon-split m-2" id="save">
                                <span class="icon text-white-50">
                                    <i class="fas fa-file-download"></i>
                                </span>
                                <span class="text">Download</span>
                            </button>
                        </form>
                </div>  
            </div> 
        </div>
    </div>
    {{-- end table --}}
</div>
<script>
    var filename = document.getElementById("filename").value;
    var json = document.getElementById("json").value;
    var getcell = document.getElementById('cell')
    var showcell = document.getElementById('myMessage')
    var json = JSON.parse(json);

    // lisensi JSpreadSheet
    jspreadsheet.setLicense('OWEwNjgyYTI4OTM0OGYyZDRkYTA2M2EyYzY1ZGI3MjE0ZGNlNjE3YTkxNjM1YjZhMGEwODhmYWYxMzM0MGIzZWU0NmFjMGU5MjRlYmI2MmM5N2JmODljYTc0NjliOGE1NjU4MzIwZmU3MDBlYmFlOTVlMGVlNzNiZTUxNzIxYmQsZXlKdVlXMWxJam9pYW05eVpHRnVJR2x6ZEdseGJHRnNJaXdpWkdGMFpTSTZNVFkwTlRFME1qUXdNQ3dpWkc5dFlXbHVJanBiSWpFeU55NHdMakF1TVNJc0lteHZZMkZzYUc5emRDSmRMQ0p3YkdGdUlqb3dMQ0p6WTI5d1pTSTZXeUoyTnlJc0luWTRJbDE5');

    var selectionActive = function(instance, x1, y1, x2, y2, origin) 
    {
        // ketika cell dipilih input dengan id 'get-column' diubah dengan cell yang ditekan
        var cellName1 = jspreadsheet.helpers.getColumnNameFromCoords(x1,y1);
        var cellName2 = jspreadsheet.helpers.getColumnNameFromCoords(x2,y2);
        var result    = cellName1 + ':' + cellName2
        document.getElementById('get-column').innerHTML = ""
        document.getElementById('get-column').value = result

        // ketika cell dipilih, value dari cell di ubah ke 'cell' untuk dikirim ke flask-socketio
        var cellvalue = instance.getValueFromCoords([x1],[y1]);
        var column = instance.getColumn(x1)

        showcell.value = cellvalue
        getcell.value = column.name + ' ; ' + showcell.value + ' ; ' + filename
    };

    // jspreadsheet
    jspreadsheet(document.getElementById('spreadsheet'), {
        worksheets: [{
            json: json,
            tableOverflow:true,
            tableHeight:'550px',
            search : true,
            csvHeaders:true,
            csvFileName: "Bino",
            columns: [
                {type:'text', width:100, title:'report_id'},
                {type:'text', width:100, title:'published_date'},
                {type:'text', width:100, title:'newstrend'},
                {type:'text', width:100, title:'title'},
                {type:'text', width:100, title:'summary'},
                {type:'text', width:100, title:'content'},
                {type:'text', width:100, title:'service_type'},
                {type:'text', width:100, title:'sentiment'},
                {type:'text', width:100, title:'url_news_page'},
                {type:'text', width:100, title:'category'},
                {type:'text', width:100, title:'media_name'},
                {type:'text', width:100, title:'media_type'},
                {type:'text', width:100, title:'reporter_name'},
                {type:'text', width:100, title:'pr_value'},
                {type:'text', width:100, title:'company_name'},
                {type:'text', width:100, title:'ad_value'},
                {type:'text', width:100, title:'flag_color'},
                {type:'text', width:100, title:'size_print'},
                {type:'text', width:100, title:'article_type' },
                {type:'text', width:100, title:'location_name' },
                {type:'text', width:100, title:'flag_headline' },
                {type:'text', width:100, title:'Similarity' }
            ]
            }],
            onselection: selectionActive,
    });

    $('#save').click(function(){
        xsl(document.getElementById('spreadsheet'), {
            filename: 'Bino',
            author: 'Binocular',
        });
    })
</script>
@endsection
