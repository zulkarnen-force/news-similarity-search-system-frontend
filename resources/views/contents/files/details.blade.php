@extends('layouts.frontend')
@section('title','Files Details')

@section('content')

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
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                </div>
                {{-- input untuk mengambil value, guna memberikan value ke javascript --}}
                <input type="text" id="json" value="{{$response}}" hidden>

                {{-- table spreadsheet dari jspreadsheet Ce --}}
                <div id="spreadsheet"></div>

                <div class="d-flex justify-content-right">
                    <form action="">
                        <button type="submit" class="btn btn-success btn-icon-split m-2">
                            <span class="icon text-white-50">
                                <i class="fas fa-chart-line"></i>
                            </span>
                            <span class="text">Generate</span>
                        </button>
                    </form>
                </div>  
            </div> 
        </div>
    </div>
    <div id="container"></div>
    {{-- end table --}}
</div>

<script>
    var json = document.getElementById("json").value;
    var json = JSON.parse(json);

    jspreadsheet(document.getElementById('spreadsheet'), {
        worksheets: [{
            data: json,
            search: true,
            csvHeaders: true,
            tableOverflow:true,
            tableHeight:'450px',
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
                {type:'text', width:100, title:'row' }
            ],
            allowComments: true,
            license:'MTM4MmQ0YWYwMDM5Mjg5ODk3MzBmZTI3Y2MwMjZiMTU4ZmRmNjAwMjdlMjMwMjcwYjkwYmQxZTMwZTI0NGUwMDcwNjI2Zjg4MjQzYjRjMmI0YzM4ZWJlZGI4ZmQzYjljZTI4NjhlYjRjMWIxZTFlMWUzMzljNGE4ODlmMjM4Y2EsZXlKdVlXMWxJam9pU205eVpHRnVJRWx6ZEdseGJHRnNJaXdpWkdGMFpTSTZNVFkwTkRVek56WXdNQ3dpWkc5dFlXbHVJanBiSWpFeU55NHdMakF1TVRvNE1EQXdJaXdpYkc5allXeG9iM04wSWwwc0luQnNZVzRpT2pBc0luTmpiM0JsSWpwYkluWTNJaXdpZGpnaVhYMD0='
        }]
    });
</script>
@endsection