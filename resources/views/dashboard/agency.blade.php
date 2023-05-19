@extends('layouts.master')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header"><strong>All Jobs</strong></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Job Name</th>
                            <th>Job Address</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody class="all-job-list">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header"><strong>Accepted Jobs</strong></div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Job Name</th>
                            <th>Client Name</th>
                            <th>Job Address</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                        </tr>
                    </thead>
                    <tbody class="accepted-job-list">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function ConvertDateTime(dateTime_str){
        date = new Date(dateTime_str);
        options = {
        year: "numeric",
        month: "long",
        day: "numeric"
        };
        formattedDate = date.toLocaleDateString("en-US", options);
        formattedTime = date.toLocaleTimeString("en-US", { hour: "numeric", minute: "2-digit" });

        output = `${formattedDate}, ${formattedTime}`;
        return output;

    }
    function loadAllJobs(){
        var req = new Request('{{url("/job/list-all")}}', {
            method: 'get',
        });
        fetch(req)
            .then((response)=>{
                return response.json();
            })
            .then((data) => { 
                table_body = document.querySelector('.all-job-list');
                table_body.innerHTML = '';
                data.forEach(job => {
                    let html = `
                        <tr>
                            <td>${job.job_name}</td>
                            <td>${job.address}</td>
                            <td>${ConvertDateTime(job.start_time)}</td>
                            <td>${ConvertDateTime(job.end_time)}</td>
                        </tr>
                    `
                    table_body.innerHTML += html;
                    // console.log(job);
                });
             })
            .catch((error) => {
                console.log('Request failed', error);
            })
    }
    function loadAcceptedJobs(){
        var req = new Request('{{url("/job/list-accepted")}}', {
            method: 'get',
        });
        fetch(req)
            .then((response)=>{
                return response.json();
            })
            .then((data) => { 
                table_body = document.querySelector('.accepted-job-list');
                table_body.innerHTML = '';
                data.forEach(job => {
                    let html = `
                        <tr>
                            <td>${job.job_name}</td>
                            <td>${job.client}</td>
                            <td>${job.address}</td>
                            <td>${ConvertDateTime(job.start_time)}</td>
                            <td>${ConvertDateTime(job.end_time)}</td>
                        </tr>
                    `
                    table_body.innerHTML += html;
                });
             })
            .catch((error) => {
                console.log('Request failed', error);
            })
    }
    (function(){
        loadAllJobs(); 
        loadAcceptedJobs();       
    })();
    
</script>
@endsection