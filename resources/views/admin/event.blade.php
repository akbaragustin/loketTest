@extends('layouts.index')
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Event</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-16 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Event</h2>
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
                          <input type="text" id="name_event" name="name_event" required="required" class="name_event form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Location<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select name="id_location" id="id_location" class="id_location form-control col-md-7 col-xs-12">
                              <option value=""></option>
                            @foreach($location as $value)
                              <option value="{{$value['id_location']}}">{{$value['name_location']}}</option>
                          @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Description</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="description_event" name="description_event" class="description_event form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Start Date Event</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class='date_start_event input-group date' id='date_start_event'>
                                <input type='text' class="date_start_event form-control" id="date_start_event" name="date_start_event"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">End Date Event</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class='date_end_event input-group date' id='date_end_event'>
                                <input type='text' class="date_end_event form-control" id="date_end_event" name="date_end_event"/>
                                <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                    </div>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="id_event" value="" class="id_event">
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
                          <th>Location</th>
                          <th>Description</th>
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
var urlAjaxTable = "{{ URL::to(route('event.indexAjax')) }}";
var  urlEdit = "{{url('/admin/event-edit')}}";
var  urlDelete = "{{url('/admin/event-delete')}}";
var  urlSave = "{{url(route('event.save'))}}";

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
        { "data": "name_event" },
        { "data" : "name_location"},
        { "data": "description_event" },
        { "data": "date_start_event" },
        { "data": "date_end_event" },
        { "render": function (data, type, row, meta) {
                   var edit = $('<a><button><i>')
                               .attr('class', "btn btn-primary waves-effect edit-menu material-icons")
                               .attr('onclick',"editProcess('"+row.id_event+"')")
                               .text('Edit')
                               .wrap('<div></div>')
                               .parent()
                               .html();
               var del = $('<button><i>')
                   .attr('class', "btn btn-danger waves-effect delete-menu material-icons ")
                   .attr('onclick', "deletProcess('"+row.id_event+"')")
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
function deletProcess(id_event){
swal({
    title: "Are you sure ?",
    text: "you will delete the data.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete ",
    closeOnConfirm: true,
}, function () {
     window.location.href = urlDelete+'/'+id_event;
 });
}
   var start = $('.date_start_event').datetimepicker({
        format: 'DD-MM-YYYY hh:mm:ss'
    });
   var end =$('.date_end_event').datetimepicker({
        format: 'DD-MM-YYYY hh:mm:ss'
    });
function editProcess(id_event){
    $.ajax({
        type: "GET",
        url: urlEdit,
        dataType : 'json',
        data: {
          id_event :id_event
        },
        success:function(retval) {
            if (retval.status =true) {
                $(window).scrollTop(0);
                console.log(retval.data);
                $('.name_event').val(retval.data.name_event);
                $('.id_event').val(retval.data.id_event);
                $('.description_event').val(retval.data.description_event);
                $('.id_location').val(retval.data.id_location);
                $('.date_start_event').val(retval.data.date_start_event);
                $('.date_end_event').val(retval.data.date_end_event);
                start.datepicker('setDate', retval.data.date_start_event);
                end.datepicker('setDate', retval.data.date_end_event);
                $('.submit').val(retval.data.submit);
            }else{
            swal("Fails!",retval.messages, "error")
            }
        }
    });
}
    $('#signupForm').validate({
        rules:{
            name_event :{
                required :true
            },
            id_location :{
                required :true
            },
            date_start_event :{
                required :true
            },
            date_end_event :{
                required :true
            },
        },
        messages: {
            name_event :{
                required : "Please enter your name event"
            },
            id_location :{
                required : "Please enter your Location"
            },
            date_start_event :{
                required : "Please enter your Start"
            },
            date_end_event :{
                required : "Please enter your End"
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