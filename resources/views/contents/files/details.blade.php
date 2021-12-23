@extends('layouts.frontend')
@section('title','Files Details')

@section('content')

<!-- Begin Page Content -->
<div class="container-fluid">
    
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Excel Reported</h1>
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
                <div id="spreadsheet"></div>
            </div> 
        </div>
    </div>
    {{-- end table --}}
</div>

<script>
var filename = 'Bino_1640233119.csv';
jspreadsheet(document.getElementById('spreadsheet'), {
    worksheets: [{
        csv: 'http://127.0.0.1:8000/storage/excel-data/'+filename,
        // csv: 'http://127.0.0.1:8000/storage/excel-data/Bino_1640140875.csv',
        // csv: 'http://127.0.0.1:8000/storage/excel-data/demo.csv',
        csvHeaders: true,
        tableOverflow:true,
        tableHeight:'450px',
        columns: [
            { width:300 },
            { width:80 },
            { width:100 }
        ]
    }]
});
</script>
@endsection