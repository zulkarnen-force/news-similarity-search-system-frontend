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
                <input type="text" id="name" value="{{ $files->filename}}" hidden>

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
var name = document.getElementById("name").value;
var url = window.location.origin + '/storage/excel-data/' + name;
// var endcol = 'H187'; //masih static -> gmn cara untuk mengetahui jumlah row yang berada pada file telah diupload 
jspreadsheet(document.getElementById('spreadsheet'), {
    worksheets: [{
        csv: url,
        search: true,
        csvHeaders: true,
        tableOverflow:true,
        tableHeight:'450px',
        columns: [
            { width:300 },
            { width:80 },
            { width:100 },
        ],
        // footers:[
        //     [
        //         'Total Positif',
        //         '=COUNTIFS(H2:'+endcol+',"positive")',
        //     ],
        //     [
        //         'Total Negatif',
        //         '=COUNTIFS(H2:'+endcol+',"negative")',
        //     ]
        // ],
    }]
});
</script>
@endsection