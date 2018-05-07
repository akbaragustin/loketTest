@extends('layouts.index')
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>My Event</h2>
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
                          <th>Username</th>
                          <th>Event</th>
                          <th>Ticket</th>
                          <th>Location</th>
                          <th>Start</th>
                          <th>End</th>
                          <th>Action</th>
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
        var urlAjaxTable = "{{ URL::to(route('myevent.indexAjax')) }}";
        var urlEdit = "{{url('/admin/myevent-edit')}}";
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
        { "data" : "username"},
        { "data": "name_event" },
        { "data": "name_ticket" },
        { "data": "name_location" },
        { "data": "date_start_ticket" },
        { "data": "date_end_ticket" },
        { "render": function (data, type, row, meta) {
                   var edit = $('<a><button><i>')
                               .attr('class', "btn btn-primary waves-effect edit-menu material-icons")
                               .attr('onclick',"editProcess('"+row.id_event+"')")
                               .text('POST')
                               .wrap('<div></div>')
                               .parent()
                               .html();

                   return edit;
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
                swal(retval.messages, "You clicked the button!", "success");
                listTable.ajax.reload();
            }else{
            swal("Fails!",retval.messages, "error")
            }
        }
    });
}

</script>
    @endsection

@stop