@extends('layouts.frontend')
@section('title','Files Similarity')

@section('content')
<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Upload File &raquo; Similarity &raquo; {{ $files->filename }}</h1>
    </div>

    {{-- alert-flash-succes --}}
    @if (session()->has('success'))
        <div class="alert alert-success" role="alert" id="success">
            {{ session('success') }}
        </div>
    @endif
    
    {{-- alert-errors --}}
    @if (session()->has('error'))
        <div class="alert alert-danger" role="alert" id="error">
            {{ session('error') }}
        </div>
    @endif

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
                    {{-- Back Data Normal --}}
                    <a href="{{route('path',$files->id)}}" class="btn btn-primary btn-icon-split m-2">
                        <span class="icon text-white-50">
                            <i class="far fa-share-square"></i>
                        </span>
                        <span class="text">Back Data Normal</span>
                    </a>
                </div>
                {{-- input untuk mengambil value, guna memberikan value ke javascript --}}
                <input type="text" id="json" value="{{$response}}" hidden>

                {{-- table spreadsheet dari jspreadsheet Ce --}}
                <div id="spreadsheet"></div>

                <div class="d-flex justify-content-right">
                    <form action="{{route('json_edit')}}" method="post">
                        @csrf
                        {{-- input untuk mengirim data json dan filename ke controller, controller ke redis --}}
                        <input type="text" value="{{$files->filename}}" id="filename" hidden>
                        <input type="text" id="json-input" name="data" hidden>
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
    var getcell = document.getElementById('myMessage')
    var json = JSON.parse(json);

    var selectionActive = function(instance, x1, y1, x2, y2, origin) 
    {
        // ketika cell dipilih input dengan id 'get-column' diubah dengan cell yang ditekan
        var cellName1 = jspreadsheet.helpers.getColumnNameFromCoords(x1,y1);
        var cellName2 = jspreadsheet.helpers.getColumnNameFromCoords(x2,y2);
        var result    = cellName1 + ':' + cellName2
        document.getElementById('get-column').innerHTML = ""
        document.getElementById('get-column').value = result

        // ketika cell dipilih, value dari cell di ubah ke 'myMessage' untuk dikirim ke flask-socketio
        var cellvalue = instance.getValueFromCoords([x1],[y1]);
        var column = instance.getColumn(x1)

        getcell.value = column.name + ' ; ' + cellvalue + ' ; ' + filename
    };

    // jspreadsheet
    jspreadsheet(document.getElementById('spreadsheet'), {
        worksheets: [{
            json: json,
            tableOverflow:true,
            tableHeight:'550px',
            columns: [
            {type:'text', width:950, title:'Input'},
            {type:'text', width:120, title:'Similarity'},
            ]
            }],
            license:'OWEwNjgyYTI4OTM0OGYyZDRkYTA2M2EyYzY1ZGI3MjE0ZGNlNjE3YTkxNjM1YjZhMGEwODhmYWYxMzM0MGIzZWU0NmFjMGU5MjRlYmI2MmM5N2JmODljYTc0NjliOGE1NjU4MzIwZmU3MDBlYmFlOTVlMGVlNzNiZTUxNzIxYmQsZXlKdVlXMWxJam9pYW05eVpHRnVJR2x6ZEdseGJHRnNJaXdpWkdGMFpTSTZNVFkwTlRFME1qUXdNQ3dpWkc5dFlXbHVJanBiSWpFeU55NHdMakF1TVNJc0lteHZZMkZzYUc5emRDSmRMQ0p3YkdGdUlqb3dMQ0p6WTI5d1pTSTZXeUoyTnlJc0luWTRJbDE5',
            onselection: selectionActive,
    });
    
</script>

<script>
    setTimeout(() => {
        $('#success').slideUp('fast');
    }, 1500);
    setTimeout(() => {
        $('#error').slideUp('fast');
    }, 4000);
</script>
@endsection