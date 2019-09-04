@extends('layouts.main')

@section('content-header')
    @breadcrumb(
        [
            'title' => 'Create Post',
            'items' => [
                'Dashboard' => route('index'),
                'Select Project' => route('customer_portal.selectProjectPost'),
                'Create Post' => "",
            ]
        ]
    )
    @endbreadcrumb
@endsection

@section('content')
<div class="row">
  <div class="col-md-2 m-b-10">
    <a href="compose.html" class="btn btn-primary btn-block">CREATE NEW POST</a>
  </div>
  
  <div class="col-md-12">
    <div class="box box-primary">
      <div class="box-header with-border">
        <h3 class="box-title">Inbox</h3>

        <div class="box-tools pull-right">
          <div class="has-feedback">
            <input type="text" class="form-control input-sm" placeholder="Search Post">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
          </div>
        </div>
        <!-- /.box-tools -->
      </div>
      <div class="box-body no-padding">
        <div class="table-responsive mailbox-messages">
          <table class="table table-hover table-striped">
            <tbody>
              <tr>
                <td class="mailbox-name"><a href="#">Alexander Pierce</a></td>
                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                </td>
                <td class="mailbox-attachment"></td>
                <td class="mailbox-date">5 mins ago</td>
                <td class="mailbox-date">
                  <button class="btn btn-primary btn-xs">VIEW</button>
                </td>
              </tr>
              <tr>
                <td class="mailbox-name"><a href="#">Alexander Pierce</a></td>
                <td class="mailbox-subject"><b>AdminLTE 2.0 Issue</b> - Trying to find a solution to this problem...
                </td>
                <td class="mailbox-attachment"><i class="fa fa-paperclip"></i></td>
                <td class="mailbox-date">28 mins ago</td>
                <td class="mailbox-date">
                  <button class="btn btn-primary btn-xs">VIEW</button>
                </td>
              </tr>
            </tbody>
          </table>
          <!-- /.table -->
        </div>
        <!-- /.mail-box-messages -->
      </div>
      <!-- /.box-body -->
      <div class="box-footer no-padding">

      </div>
    </div>
    <!-- /. box -->
  </div>
  <!-- /.col -->
</div>
@endsection

@push('script')
<script>
  $('div.overlay').hide();    
</script>
@endpush