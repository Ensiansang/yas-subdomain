@extends('teacher.teacher_master')
@section('teacher')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
		 

		<!-- Main content -->
		<section class="content">
		  <div class="row">

		
<div class="col-12">
<div class="box bb-3 border-warning">
				  <div class="box-header">
					<h4 class="box-title">Student <strong>PDF/IMG Delete</strong></h4>
				  </div>

				  <div class="box-body">
				
		<form method="post" action="" enctype="multipart/form-data">
			@csrf
			<div class="row">







 			
 		<div class="col-md-3">

 		 <div class="form-group">
		<h5>Class <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="student_classes_id" id="student_classes_id"  required="" class="form-control">
			<option value="" selected="" disabled="">Select Class</option>
			 @foreach($classes as $class)
			<option value="{{ $class->id }}">{{ $class->name }}</option>
		 	@endforeach
			 
		</select>
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">
                {{ $error }}
            </div>
        @endforeach
	  </div>		 
	  </div>
	  
 			</div> <!-- End Col md 3 --> 




 			<div class="col-md-3" style="padding-top: 25px;" >

  <a id="search" class="btn btn-primary" name="search"> Search</a>

	  
 			</div> <!-- End Col md 3 --> 		
			</div><!--  end row --> 


 <!--  ////////////////// Mark Entry table /////////////  -->


 <div class="row d-none" id="marks-entry">
 	<div class="col-md-12">
 		<table class="table table-bordered table-striped" style="width: 100%">
 			<thead>
 				<tr>
 					<th>Student Name </th>
 					<th>Delete</th>
 				 </tr> 				
 			</thead>
 			<tbody id="marks-entry-tr">
 				
 			</tbody>
 			
 		</table>
        
 <!-- <input type="submit" class="btn btn-rounded btn-primary" value="Submit"> -->

 	</div>
 	
 </div>
 

		</form> 

			       
			</div>
			<!-- /.col -->
		  </div>
		  <!-- /.row -->
		</section>
		<!-- /.content -->
	  
	  </div>
  </div>


<script type="text/javascript">
$(document).on('click', '#search', function() {
    var class_id = $('#student_classes_id').val();
    
    $.ajax({
        url: "{{ route('img.pdf.getstudent')}}",
        type: "GET",
        data: {
            'class_id': class_id,
            
        },
        success: function(data) {
            $('#marks-entry').removeClass('d-none');
            var html = '';
            $.each(data, function(key, v) {
                html +=
                    '<tr>' +
                    // '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
                    '<td>' + v.student.name + '</td>' +
                    
					(v.uploadedData.length > 0 ? 
					'<td><a href="#" class="delete_student btn btn-danger" name="user_id" data-value="' + v.student.id + '" id="delete">Delete</a></td>' :  '<td><a href="">-</a></td>'
                    ) +
                    '</tr>';
        //         html +=
        // '<tr>' +
        // '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
        // '<td>' + v.student.name + '</td>' +
        // (v.uploadedData.length > 0 ? 
        //     '<td>' + v.uploadedData[0].pdf_file_path + '</td>' +
        //     '<td>' + v.uploadedData[0].image_file_path + '</td>' +
        //     '<td><button class="btn btn-danger delete-user" data-user-id="' + v.student.id + '">Delete</button></td>' 
        //     : '<td colspan="2">No files uploaded</td><td><button class="btn btn-danger delete-user" data-user-id="' + v.student.id + '">Delete</button></td>'
        // ) +
        // '</tr>';

				                   
            });
            $('#marks-entry-tr').html(html);
        }
    });
});


// $(document).on('click', '.delete_student', function(e) {
//     e.preventDefault();
    
//     var clickedDeleteButton = $(this).data('value'); // Capture the clicked button
// 	alert(clickedDeleteButton);
// });

</script>






@endsection