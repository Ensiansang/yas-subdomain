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
					<h4 class="box-title">Edit <strong>Mark Entry</strong></h4>
				  </div>

				  <div class="box-body">
				
		<form method="post" action="{{ route('mark.update') }}">
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
	  </div>		 
	  </div>
	  
 			</div> <!-- End Col md 3 --> 


 		<div class="col-md-3">

 		 <div class="form-group">
		<h5>Subject <span class="text-danger"> </span></h5>
		<div class="controls">
	 <select name="subject" id="subject"  required="" class="form-control">
			<option  selected="" >Select Subject</option>
			  
			 
		</select>
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
 					<th>Marks</th>
 				 </tr> 				
 			</thead>
 			<tbody id="marks-entry-tr">
 				
 			</tbody>
 			
 		</table>
 <input type="submit" class="btn btn-rounded btn-primary" value="Update">

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
   $(document).on('click','#search',function(){
    var class_id = $('#student_classes_id').val();
    var assign_subject_id = $('#subject').val();
    
     $.ajax({
      url: "{{ route('mark.getstudents')}}",
      type: "GET",
      data: {'student_classes_id':class_id,'subject':assign_subject_id},
      success: function (data) {
        $('#marks-entry').removeClass('d-none');
        var html = '';
        $.each( data, function(key, v){
          html +=
          '<tr>'+
          '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
          '<td>'+v.student.name+'</td>'+
          '<td><input type="text" class="form-control form-control-sm grade-input" name="grade[]" value=" '+ v.grade + '"></td>'+
		  '<td><span class="grade-error text-danger"></span></td>' +
          '</tr>';
        });
        html = $('#marks-entry-tr').html(html);
      }
    });
  });

  $(document).on('input', '.grade-input', function() {
    var grade = $(this).val();
    var maxDigits = 4;
    if (grade.length > maxDigits) {
        $(this).val(grade.slice(0, maxDigits));
        $(this).closest('tr').find('.grade-error').text('Grade should not exceed 3 digits');
    } else {
        $(this).closest('tr').find('.grade-error').empty();
    }
});

</script>


<!--   // for get Student Subject  -->

<script type="text/javascript">
  $(function(){
    $(document).on('change','#student_classes_id',function(){
      var class_id = $('#student_classes_id').val();
      $.ajax({
        url:"{{ route('marks.getsubject') }}",
        type:"GET",
        data:{class_id:class_id},
        success:function(data){
          var html = '<option value="">Select Subject</option>';
          $.each( data, function(key, v) {
            html += '<option value="'+v.id+'">'+v.school_subject.name+'</option>';
          });
          $('#subject').html(html);
        }
      });
    });
  });
</script>



@endsection