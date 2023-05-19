@extends('login.login_layout')
@section('form')
<div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Sign In to your client account</p>
                  <form action="{{url('/login_submit/client')}}" method="post">
                  <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="{{asset('app-assets/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                      </svg></span>
                    <input class="form-control" name="email" type="text" placeholder="Email" required>
                  </div>
                  <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="{{asset('app-assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                      </svg></span>
                    <input class="form-control" name="password" type="password" placeholder="Password" required>
                  </div>
                  <div class="mb-2 d-none">
                      <label class="form-label" for="latitude">Latitude</label>
                      <input class="form-control" id="latitude" name="latitude" type="text" required>
                  </div>
                  <div class="mb-2 d-none">
                      <label class="form-label" for="latitude">Longitude</label>
                      <input class="form-control" id="longitude" name="longitude" type="text" required>
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-primary px-4" type="submit">Login</button>
                    </div>
                    <div class="col-6 text-end">
                        Don't have an account ? 
                        <a href="{{url('/client-register')}}">Sign Up</a>
                    </div>
                  </div>
                  @csrf
                  </form>
                </div>
              </div>
              <script>
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
            </div>
@endsection