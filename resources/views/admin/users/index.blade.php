@extends('layouts.backend.index')
@section('content')
<div class="page-header">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Users Management</li>
  </ol>
  <h1 class="page-title">Users Management</h1>
</div>

<div class="page-content">

<div class="panel">
        <div class="panel-heading">
            <div class="panel-title">
              <a href="{{ route('admin.getForm') }}" class="btn btn-success btn-sm"><i class="icon wb-plus" aria-hidden="true"></i> Add User</a>
              <a href="{{ url('admin/users/export?search=').$search }}" class="btn btn-info btn-sm"><i class="fas fa-file-export"></i> Export</a>
            </div>
          
          <div class="panel-actions">
          <form method="GET" action="{{ route('admin.users') }}">
              <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search..." value="{{ Request::input('search') }}">
                <span class="input-group-btn">
                  <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-original-title="Search"><i class="icon wb-search" aria-hidden="true"></i></button>
                  <a href="{{ route('admin.users') }}" class="btn btn-danger" data-toggle="tooltip" data-original-title="Clear Search"><i class="icon wb-close" aria-hidden="true"></i></a>
                </span>
              </div>
          </form>
          </div>
        </div>
        
        <div class="panel-body">
          <table class="table table-hover table-striped w-full">
            <thead>
              <tr>
                <th>Sl.no</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email ID</th>
                <th>Receive Offer</th>
                <th>Roles</th>
                <th>Status</th>
                <th>Email Verified</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php $array = array(0 => 'No', 1 => 'Yes');?>
              @foreach($users as $user)
              <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->first_name }}</td>
                <td>{{ $user->last_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $array[$user->offer] }}</td>
                <td>
                  @foreach($user->roles as $role)
                    @if($role->name == 'student')
                        <span class="badge badge-primary">{{ ucfirst($role->name) }}</span>
                    @elseif($role->name == 'instructor')
                        <span class="badge badge-warning">{{ ucfirst($role->name) }}</span>
                    @elseif($role->name == 'admin')
                        <span class="badge badge-success">{{ ucfirst($role->name) }}</span>
                    @endif
                    @if(!$loop->last)
                    <br>
                    @endif
                  @endforeach
                </td>
                <td>
                  @if($user->is_active == '1')
                  <span class="badge badge-success">Active</span>
                  @elseif($user->is_active == '0')
                  <span class="badge badge-warning">Pending</span>
                  @elseif($user->is_active == '2')
                  <span class="badge badge-danger">Inactive</span>
                  @elseif($user->is_active == '3')
                  <span class="badge badge-danger">Denied</span>
                  @endif
                </td>
                <td>
                  @if($user->email_verified_at == '')
                  <span class="badge badge-danger">No</span>
                  @else
                  <span class="badge badge-success">Yes</span>
                  @endif
                </td>
                <td>
                  <a href="{{ url('admin/user-form/'.$user->id) }}" class="btn btn-xs btn-icon btn-inverse btn-round" data-toggle="tooltip" data-original-title="Edit">
                    <i class="icon wb-pencil" aria-hidden="true"></i>
                  </a>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          
          <div class="float-right">
            {{ $users->appends(['search' => Request::input('search')])->links() }}
          </div>
          
          
        </div>
      </div>
      <!-- End Panel Basic -->
</div>

@endsection

@section('javascript')
<script type="text/javascript">
    $(document).ready(function()
    { 
        
    });
</script>
@endsection