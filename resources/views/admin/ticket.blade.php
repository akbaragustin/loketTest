@extends('layouts.index')
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Ticket</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-16 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Ticket</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />
                    <form id="signupForm" data-parsley-validate class="signupForm form-horizontal form-label-left">

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="name_ticket" name="name_ticket" required="required" class="name_ticket form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Capacity<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="number" id="capacity_ticket" name="capacity_ticket" required="required" class="capacity_ticket form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Event<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="id_event" id="id_event" class="id_event form-control col-md-7 col-xs-12">
                              <option value=""></option>
                            @foreach($event as $value)
                              <option value="{{$value['id_event']}}">{{$value['name_event']}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Start Date Ticket</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class='date_start_ticket input-group date' id='date_start_ticket'>
                                <input type='text' class="date_start_ticket form-control" id="date_start_ticket" name="date_start_ticket"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">End Date Ticket</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class='date_end_ticket input-group date' id='date_end_ticket'>
                                <input type='text' class="date_end_ticket form-control" id="date_end_ticket" name="date_end_ticket"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="id_ticket" value="" class="id_ticket">
                      <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input class="submit btn btn-info" type="submit" value="submit"/>   
                         <button class="reset btn btn-primary" type="reset" id="reset">Reset</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Table Location</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <table class="listTable table" id="listTable">
                      <thead>
                        <tr>
                          <th>No</th>
                          <th>Name</th>
                          <th>Capacity</th>
                          <th>Event</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>action</th>
                        </tr>
                      </thead>
                    </table>

                  </div>
                </div>
              </div>
          </div>
        </div>

        <!-- /page content -->

        @section('js')
    <script>
var urlAjaxTable = "{{ URL::to(route('ticket.indexAjax')) }}";
var  urlEdit = "{{url('/admin/ticket-edit')}}";
var  urlDelete = "{{url('/admin/ticket-delete')}}";
var  urlSave = "{{url(route('ticket.save'))}}";

var listTable  = $('.listTable').DataTable({
    "processing": true,
    "bFilter": true,
    "bInfo": false,
    "bLengthChange": false,
    "serverSide": true,
    "ajax": {
         "url": urlAjaxTable,
         "type": "GET"
     },
     "columns": [
        { "data" : "no"},
        { "data": "name_ticket" },
        {"data" : "capacity_ticket"},
        { "data" : "name_event"},
        { "data": "date_start_ticket" },
        { "data": "date_end_ticket" },
        { "render": function (data, type, row, meta) {
                   var edit = $('<a><button><i>')
                               .attr('class', "btn btn-primary waves-effect edit-menu material-icons")
                               .attr('onclick',"editProcess('"+row.id_ticket+"')")
                               .text('Edit')
                               .wrap('<div></div>')
                               .parent()
                               .html();
               var del = $('<button><i>')
                   .attr('class', "btn btn-danger waves-effect delete-menu material-icons ")
                   .attr('onclick', "deletProcess('"+row.id_ticket+"')")
                   .text('Delete')
                   .wrap('<div></div>')
                   .parent()
                   .html();

                   return edit+" | "+del;
                               }
       },
    ],
    "buttons": [
       {
           extend: 'collection',
           text: 'Export',
           buttons: [
               'copy',
               'excel',
               'csv',
               'pdf',

           ]
       }
   ]
});


//function delete
function deletProcess(id_ticket){
swal({
    title: "Are you sure ?",
    text: "you will delete the data.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete ",
    closeOnConfirm: true,
}, function () {
     window.location.href = urlDelete+'/'+id_ticket;
 });
}
   var start = $('.date_start_ticket').datetimepicker({
        format: 'DD-MM-YYYY hh:mm:ss'
    });
   var end =$('.date_end_ticket').datetimepicker({
        format: 'DD-MM-YYYY hh:mm:ss'
    });
function editProcess(id_ticket){
    $.ajax({
        type: "GET",
        url: urlEdit,
        dataType : 'json',
        data: {
          id_ticket :id_ticket
        },
        success:function(retval) {
            if (retval.status =true) {
                $(window).scrollTop(0);
                console.log(retval.data);
                $('.name_ticket').val(retval.data.name_ticket);
                $('.id_ticket').val(retval.data.id_ticket);
                $('.capacity_ticket').val(retval.data.capacity_ticket);
                $('.id_event').val(retval.data.id_event);
                $('.date_start_ticket').val(retval.data.date_start_ticket);
                $('.date_end_ticket').val(retval.data.date_end_ticket);
                start.datepicker('setDate', retval.data.date_start_ticket);
                end.datepicker('setDate', retval.data.date_end_ticket);
                $('.submit').val(retval.data.submit);
            }else{
            swal("Fails!",retval.messages, "error")
            }
        }
    });
}
    $('#signupForm').validate({
        rules:{
            name_ticket :{
                required :true
            },
            id_event :{
                required :true
            },
            date_start_ticket :{
                required :true
            },
            date_end_ticket :{
                required :true
            },
            capacity_ticket :{
                required :true
            }
        },
        messages: {
            name_ticket :{
                required : "Please enter your name ticket"
            },
            id_event :{
                required : "Please enter your Location"
            },
            date_start_ticket :{
                required : "Please enter your Start"
            },
            date_end_ticket :{
                required : "Please enter your End"
            },
            capacity_ticket :{
                required : "Please enter your Capacity"
            }
        },
    submitHandler: function(form) {
        $.ajax({
            type: "POST",
            url: urlSave,
            dataType : 'json',
            data: $('#signupForm').serialize(),
            success: function(retval) {
                    if (retval.status == true){

                         swal(retval.messages, "You clicked the button!", "success");
                         listTable.ajax.reload();
                         $('.reset').trigger('click');

                    }else if(retval.status == false){
                        swal("Save fails!",retval.messages, "error")
                    }
            }
        });
    }
});

</script>
    @endsection

@stop