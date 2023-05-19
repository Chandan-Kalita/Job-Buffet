@extends('layouts.master')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card mb-4">
            <div class="card-header"><strong>Create a Job</strong></div>
            <form id="job-create-form">
            <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label" for="job_name">Job Name</label>
                        <input class="form-control" id="job_name" name="job_name" type="text" placeholder="Job Name">
                    </div>
                    <div class="mb-3">
                        <label class="form-label" for="job_address">Job Address</label>
                        <textarea class="form-control" id="job_address" name="job_address" rows="3"></textarea>
                    </div>
                    <div class="row g-3">
                        <div class="col">
                            <label class="form-label" for="start_time">Job Start Time</label>
                            <input class="form-control" id="start_time" name="start_time" type="datetime-local" placeholder="Start Time">
                        </div>
                        <div class="col">
                            <label class="form-label" for="end_time">Job End Time</label>
                            <input class="form-control" id="end_time" name="end_time" type="datetime-local" placeholder="End Time">
                        </div>
                    </div>
                    <div class="mb-2 d-none">
                        <label class="form-label" for="latitude">Latitude</label>
                        <input class="form-control" id="latitude" name="latitude" type="text" required>
                    </div>
                    <div class="mb-2 d-none">
                        <label class="form-label" for="latitude">Longitude</label>
                        <input class="form-control" id="longitude" name="longitude" type="text" required>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row">
                        <div class="col-lg-3">
                            <button class="btn btn-success create-job-btn">
                                Submit
                            </button>
                            
                        </div>
                        <div id="result" class="col-lg-9">

                        </div>
                    </div>
                </div>
                @csrf
            </form>
        </div>
    </div>

</div>
<script>
    document.querySelector('.create-job-btn').addEventListener('click',(e)=>{
        e.preventDefault();
        form = document.getElementById('job-create-form');
        formData = new FormData(form)
        var req = new Request('{{url("/job/insert")}}', {
            method: 'post',
            body: formData
        });
        fetch(req)
            .then((response)=>{
                return response.json();
            })
            .then((data) => { 
                if(data.error){
                    document.getElementById('result').innerHTML = data.error;
                }else{
                    document.getElementById('result').innerHTML = data.success;
                    document.getElementById('job-create-form').reset();
                }
             })
            .catch((error) => {
                console.log('Request failed', error);
            })
    })
    function successFunction(position) {
        var lat = position.coords.latitude;
        var long = position.coords.longitude;
        document.getElementById('latitude').value = lat;
        document.getElementById('longitude').value = long;
    }
    function errorFunction(){
        alert('It seems like Geolocation, which is required for this page, is not enabled in your browser. Please manually enter your cordinates.');
        document.getElementById('latitude').parentElement.classList.remove('d-none');
        document.getElementById('longitude').parentElement.classList.remove('d-none');
    }
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(successFunction, errorFunction);
    } else {
        errorFunction();
    }
</script>
@endsection