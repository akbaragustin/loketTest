@extends('layouts.index')
@section('content')
        <!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Location</h3>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-16 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Form Location</h2>
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
                          <input type="text" id="name_location" name="name_location" required="required" class="name_location form-control col-md-7 col-xs-12">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">Address</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="address_location" name="address_location" class="address_location form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">City</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="city_location" name="city_location" class="city_location form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">State</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="state_location" name="state_location" class="state_location form-control col-md-7 col-xs-12">
                        </div>
                      </div>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}">
                      <input type="hidden" name="id_location" value="" class="id_location">
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
                          <th>Address</th>
                          <th>City</th>
                          <th>State</th>
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
var urlAjaxTable = "{{ URL::to(route('location.indexAjax')) }}";
var  urlEdit = "{{url('/admin/location-edit')}}";
var  urlDelete = "{{url('/admin/location-delete')}}";
var  urlSave = "{{url(route('location.save'))}}";

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
        {"data" : "no"},
        { "data": "name_location" },
        { "data": "address_location" },
        { "data": "city_location" },
        { "data": "state_location" },
        { "render": function (data, type, row, meta) {
                   var edit = $('<a><button><i>')
                               .attr('class', "btn btn-primary waves-effect edit-menu material-icons")
                               .attr('onclick',"editProcess('"+row.id_location+"')")
                               .text('Edit')
                               .wrap('<div></div>')
                               .parent()
                               .html();
               var del = $('<button><i>')
                   .attr('class', "btn btn-danger waves-effect delete-menu material-icons ")
                   .attr('onclick', "deletProcess('"+row.id_location+"')")
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
function deletProcess(id_location){
swal({
    title: "Are you sure ?",
    text: "you will delete the data.",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete ",
    closeOnConfirm: true,
}, function () {
     window.location.href = urlDelete+'/'+id_location;
 });
}

function editProcess(id_location){
    $.ajax({
        type: "GET",
        url: urlEdit,
        dataType : 'json',
        data: {
          id_location :id_location
        },
        success:function(retval) {
            if (retval.status =true) {
                $(window).scrollTop(0);
                console.log(retval.data);
                $('.name_location').val(retval.data.name_location);
                $('.id_location').val(retval.data.id_location);
                $('.address_location').val(retval.data.address_location);
                $('.city_location').val(retval.data.city_location);
                $('.state_location').val(retval.data.state_location);
                $('.submit').val(retval.data.submit);
            }else{
            swal("Fails!",retval.messages, "error")
            }
        }
    });
}
    $('#signupForm').validate({
        rules:{
            name_location :{
                required :true
            }
        },
        messages: {
          name_location :{
                required : "Please enter your name location"
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