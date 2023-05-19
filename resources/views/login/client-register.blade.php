@extends('login.login_layout')
@section('form')
<div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-3 mb-0">
                <div class="card-body">
                  <h1>Sign Up</h1>
                  <form action="{{url('/register_submit/client')}}" method="post">
                        <div class="mb-2">
                            <label class="form-label" for="name">Your Name</label>
                            <input class="form-control" name="name" id="name" type="text" placeholder="Your Name" required>
                        </div>
                        <div class="mb-2 mt-4">
                            <label class="form-label" for="phone">Your Phone No</label>
                            <input class="form-control" name="phone" id="phone" type="tel" pattern="[5-9]{1}[0-9]{9}" required placeholder="Eg. 9100000000">
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="email">Your Email address</label>
                            <input class="form-control" name="email" id="email" type="email" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="address">Your Address</label>
                            <textarea class="form-control" name="address" id="address" required></textarea>
                        </div>
                        <div class="mb-2">
                            <label class="form-label" for="password">Password</label>
                            <input class="form-control" id="password" name="password" type="password" placeholder="**********" required>
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
                      <button class="btn btn-primary px-4" type="submit">Sign Up</button>
                    </div>
                    <div class="col-6 text-end">
                        Already have an account ? 
                        <a href="{{url('/client-login')}}">Sign In</a>
                    </div>
                  </div>
                  @csrf
                  </form>
                </div>
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
@endsection