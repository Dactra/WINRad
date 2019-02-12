@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit HSU</div>

                <div class="card-body">
                  <form method="POST" action="{{ route('admin.radwins.update', $radwin->id) }}">
                    {{ method_field('PATCH') }}
                    <div class="form-group">
                      @csrf
                      <label for="address">Username:</label>
                      <input type="text" class="form-control" value="{{ $radwin->username }}" name="username"/>
                    </div>
                    <div class="form-group">
                      <label for="Name">Password:</label>
                      <input type="text" class="form-control" value="{{ $radwin->password }}" name="password"/>
                    </div>
                    <div class="form-group">
                      <label for="Type">Serial No:</label>
                      <input type="text" class="form-control" value="{{ $radwin->radwinserial }}" name="radwinserial"/>
                    </div>
                    <div class="form-group">
                      <label for="Ports">Service Category:</label>
                      <select class="form-control" name="radwinservicecategory"/>
                      <option value="1" selected="selected">1</option>
                      <option value="2">2</option>
                      <option value="3">3</option>
                      <option value="4">4</option>
                      <option value="4">4</option>
                      <option value="5">5</option>
                      <option value="6">6</option>
                      <option value="7">7</option>
                      <option value="8">8</option>

                    </select>
                    </div>
                    <div class="form-group">
                      <label for="Secret">Name:</label>
                      <input type="text" class="form-control" value="{{ $radwin->radwinname }}" name="radwinname"/>
                    </div>
                    <div class="form-group">
                      <label for="Server">Location:</label>
                      <input type="text" class="form-control" value="{{ $radwin->radwinlocation }}" name="radwinlocation"/>
                    </div>
                    <div class="form-group">
                      <label for="Community">VLAN:</label>
                      <input type="text" class="form-control" value="{{ $radwin->radwinvlan }}" name="radwinvlan" />
                    </div>
                    <div class="form-group">
                      <label for="Description">Enabled:</label>
                      <select class="form-control" name="radwinregisteravailability"/>
                      <option value="1" selected="selected">Enabled</option>
                      <option value="0">Disabled</option>


                    </select>
                    </div>


                    <button type="submit" class="btn btn-primary">Add</button>
                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
