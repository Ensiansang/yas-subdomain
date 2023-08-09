<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // Now you can put your specific AJAX calls here
            // ...
            
        });
    </script>
    <link rel="icon" href="{{asset('backend/images/favicon.ico')}}">

    <title>Yas School Management System - Dashboard</title>
    
	<!-- Vendors Style-->
	<link rel="stylesheet" href="{{ asset('backend/css/vendors_css.css') }}">
	  
	<!-- Style-->  
	<link rel="stylesheet" href="{{ asset('backend/css/style.css') }}">
	<link rel="stylesheet" href="{{ asset('backend/css/skin_color.css') }}">
   
 <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
     
  </head>

<body class="hold-transition dark-skin sidebar-mini theme-primary fixed">
	
<div class="wrapper">

  @include('teacher.body.header')
  <!-- Left side column. contains the logo and sidebar -->
  @include('teacher.body.sidebar')

  <!-- Content Wrapper. Contains page content -->
  @yield('teacher')
  <!-- /.content-wrapper -->

 @include('teacher.body.footer')

  <div class="control-sidebar-bg"></div>
  
</div>
<!-- ./wrapper -->
  	
	  
	<!-- Vendor JS -->
	<script src="{{ asset('backend/js/vendors.min.js') }}"></script>
    <script src="{{ asset('../assets/icons/feather-icons/feather.min.js') }}"></script>	
	<script src="{{ asset('../assets/vendor_components/easypiechart/dist/jquery.easypiechart.js') }}"></script>
	<script src="{{ asset('../assets/vendor_components/apexcharts-bundle/irregular-data-series.js') }}"></script>
	<script src="{{ asset('../assets/vendor_components/apexcharts-bundle/dist/apexcharts.js') }}"></script>
	

<script src="{{asset('../assets/vendor_components/datatable/datatables.min.js')}}"></script>
  <script src="{{asset('backend/js/pages/data-table.js')}}"></script>


	<!-- Sunny Admin App -->
	<script src="{{ asset('backend/js/template.js') }}"></script>
	<script src="{{ asset('backend/js/pages/dashboard.js') }}"></script>
	

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

<script type="text/javascript">
$(document).on('click', '#delete', function(e) {
    e.preventDefault();
    
    var clickedDeleteButton = $(this); // Capture the clicked button
    // alert(clickedDeleteButton);
    var user_id = clickedDeleteButton.data('value');

    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});


    Swal.fire({
        title: 'Are you sure?',
        text: 'Delete PDF for this student?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            var url = "{{ route('img.pdf.real.delete', ['user_id' => ':user_id']) }}";
            url = url.replace(':user_id', user_id);
            // Send the DELETE request using AJAX
            $.ajax({
                type: 'DELETE',
                url: url,
                success: function(data) {
                    Swal.fire({
                        title: 'Deleted!',
                        text: 'The PDF for this student has been deleted.',
                        icon: 'success'
                    }).then(() => {
                        // Use the captured context to remove the closest row
                        // clickedDeleteButton.closest('tr').remove();
                        clickedDeleteButton.closest('tr').remove();
                    });
                },
                error: function(error) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Something went wrong. Please try again later.',
                        icon: 'error'
                    });
                }
            });
        }
    });
});



</script> 


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
 @if(Session::has('message'))
 var type = "{{ Session::get('alert-type','info') }}"
 switch(type){
    case 'info':
    toastr.info(" {{ Session::get('message') }} ");
    break;

    case 'success':
    toastr.success(" {{ Session::get('message') }} ");
    break;

    case 'warning':
    toastr.warning(" {{ Session::get('message') }} ");
    break;

    case 'error':
    toastr.error(" {{ Session::get('message') }} ");
    break; 
 }
 @endif 
</script>


	
</body>
</html>