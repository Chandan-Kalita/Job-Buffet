@extends('login.login_layout')
@section('form')
<div class="card-group d-block d-md-flex row">
              <div class="card col-md-7 p-4 mb-0">
                <div class="card-body">
                  <h1>Login</h1>
                  <p class="text-medium-emphasis">Sign In to your agency account</p>
                  <form action="{{url('/login_submit/agency')}}" method="post">
                  <div class="input-group mb-3"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="{{asset('app-assets/vendors/@coreui/icons/svg/free.svg#cil-user')}}"></use>
                      </svg></span>
                    <input class="form-control" name="email" type="text" placeholder="Email">
                  </div>
                  <div class="input-group mb-4"><span class="input-group-text">
                      <svg class="icon">
                        <use xlink:href="{{asset('app-assets/vendors/@coreui/icons/svg/free.svg#cil-lock-locked')}}"></use>
                      </svg></span>
                    <input class="form-control" name="password" type="password" placeholder="Password">
                  </div>
                  <div class="row">
                    <div class="col-6">
                      <button class="btn btn-primary px-4" type="submit">Login</button>
                    </div>
                    <div class="col-6 text-end">
                        Don't have an account ? 
                        <a href="{{url('/agency-register')}}">Sign Up</a>
                    </div>
                  </div>
                  @csrf
                  </form>
                </div>
              </div>
             
            </div>
@endsection