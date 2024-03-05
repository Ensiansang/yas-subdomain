@extends('admin.admin_master')
@section('admin')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
      $('.select2-autocomplete').select2({
        placeholder: 'Search for a student',
        minimumInputLength: 2,
        tags: true, 
        ajax: {
          url: '/search-students', 
          dataType: 'json',
          delay: 250,
          processResults: function(data) {
            return {
              results: data.students
            };
          },
          cache: true
        }
      });
    });
  </script>


 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
	

<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Add Student </h4>
			  
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

	 <form method="post" action="{{ route('student.reg.store') }}">
	 	@csrf
					  <div class="row">
						<div class="col-12">	
 

 	
 		<div class="row"> <!-- 1st Row -->
 			
 			<div class="col-md-4">

 		
<div class="form-group">
  <h5>Student Name <span class="text-danger">*</span></h5>
  <div class="controls">
    <input type="text" name="student" required="" class="form-control" id="student_name">
    <select name="student" id="student_dropdown" class="form-control" style="margin-top: 5px;">
      <option value="" selected disabled>Select Student</option>
      @foreach($students as $student)
        <option value="{{ $student->id }}">{{ $student->name }}</option>
      @endforeach
    </select>
  </div>		 
</div>

 			</div> <!-- End Col md 4 -->

             <div class="col-md-4">

<div class="form-group">
<h5>Class <span class="text-danger">*</span></h5>
<div class="controls">
<select name="class_id"  required="" class="form-control">
  <option value="" selected="" disabled="">Select Class</option>
   @foreach($classes as $class)
  <option value="{{ $class->id }}">{{ $class->name }}</option>
   @endforeach
   
</select>
</div>		 
</div>

   </div> <!-- End Col md 4 --> 



			
 		</div> <!-- End 1stRow -->






	<div class="row"> <!-- 2nd Row -->
 			
 	 
 			
 		</div> <!-- End 2nd Row -->



<div class="row"> <!-- 3rd Row -->


 
 			
 		</div> <!-- End 3rd Row -->




<div class="row"> <!-- 4TH Row -->






 			


 
 			
 		</div> <!-- End 4TH Row -->




<div class="row"> <!-- 5TH Row -->

 
 			
 		</div> <!-- End 5TH Row -->

 
  
							 
						<div class="text-xs-right">
	 <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		</section>


 
 
	  
	  </div>
  </div>



<script>
    $(document).ready(function() {
  $('#student_name').on('input', function() {
    var searchQuery = $(this).val();

    $.ajax({
      url: '/search-students', 
      method: 'GET',
      data: { name: searchQuery },
      success: function(response) {
        var students = response.students;
        var dropdown = $('#student_dropdown');

        // Clear previous results
        dropdown.empty();

        // Add matching student records
        students.forEach(function(student) {
          var option = $('<option>').val(student.id).text(student.name);
          dropdown.append(option);
        });
      }
    });
  });
});

</script>
@endsection
