@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">Radwin</div>

                <div class="card-body">
                  <a href="{{ route('admin.radwins.create') }}" class="btn btn-sm btn-primary">Add new</a>
                  <br /><br />
                <table class="table">
                <tr>
                  <th>Username</th>
                  <th>Password</th>
                  <th>Serial No.</th>
                  <th>Service Cat</th>
                  <th>Name</th>
                  <th>Location</th>
                  <th>VLAN</th>
                  <th>Enabled</th>
                  <th></th>
                </tr>
                @forelse($radwins as $radwin)
                   <tr>
                     <td>{{ $radwin->username }}</td>
                     <td>{{ $radwin->password }}</td>
                     <td>{{ $radwin->radwinserial }}</td>
                     <td>{{ $radwin->radwinservicecategory }}</td>
                     <td>{{ $radwin->radwinname }}</td>
                     <td>{{ $radwin->radwinlocation }}</td>
                     <td>{{ $radwin->radwinvlan }}</td>
                     <td>{{ $radwin->radwinregisteravailability }}</td>
                     <td><a href="{{ route('admin.radwins.edit', $radwin->id) }}" class="btn btn-sm btn-info">Edit</a></td>
                   </tr>
                  @empty
                    <tr>
                      <td colspan="2">No Records Found</td>
                    </tr>
                @endforelse
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
