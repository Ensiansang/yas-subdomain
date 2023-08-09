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
					<h4 class="box-title">Student <strong>Mark Entry</strong></h4>
				  </div>

				  <div class="box-body">
				
		<form method="post" action="{{ route('mark.store') }}">
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
 <input type="submit" class="btn btn-rounded btn-primary" value="Submit">

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
//   $(document).on('click','#search',function(){
//     var class_id = $('#student_classes_id').val();
//     var subject = $('#subject').val();
//      $.ajax({
//       url: "{{ route('student.marks.getstudent')}}",
//       type: "GET",
//       data: {'class_id':class_id},
//       success: function (data) {
//         $('#marks-entry').removeClass('d-none');
//         var html = '';
//         $.each( data, function(key, v){
//           html +=
//           '<tr>'+
// 		  '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' + 
//           '<td>'+v.student.name+'</td>'+
//           '<td><input type="text" class="form-control form-control-sm" name="grade[]" ></td>'+
//           '</tr>';
//         });
//         html = $('#marks-entry-tr').html(html);
//       }
//     });
//   });
// $(document).on('click', '#search', function() {
//     var class_id = $('#student_classes_id').val();
//     var assign_subject_id = $('#subject').val();
//     $.ajax({
//         url: "{{ route('student.marks.getstudent')}}",
//         type: "GET",
//         data: {
//             'class_id': class_id,'subject':assign_subject_id
//         },
//         success: function(data) {
//             $('#marks-entry').removeClass('d-none');
//             var html = '';
//             $.each(data, function(key, v) {
// 				// console.log("v:", v);
// 				// var gradeValue = v.grade !== null ? v.grade : ''; // Check if grade is not null
// 				// console.log("gradeValue:", gradeValue);
//                 html +=
//                     '<tr>' +
//                     '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
//                     '<td>' + v.student.name + '</td>' +
//                     '<td><input type="text" class="form-control form-control-sm grade-input" name="grade[]" value="' + gradeValue +  '"></td>' +
//                     '<td><span class="grade-error text-danger"></span></td>' +
//                     '</tr>';
//             });
//             $('#marks-entry-tr').html(html);
//         }
//     });
// });

$(document).on('click', '#search', function() {
    var class_id = $('#student_classes_id').val();
    var assign_subject_id = $('#subject').val();
    $.ajax({
        url: "{{ route('student.marks.getstudent')}}",
        type: "GET",
        data: {
            'class_id': class_id,
            'subject': assign_subject_id
        },
        success: function(data) {
            $('#marks-entry').removeClass('d-none');
            var html = '';
            $.each(data.allData, function(key, v) {
                var gradeValue = '';
                var studentGrade = data.getStudent.find(function(student) {
                    return student.student.id === v.student.id;
                });
                if (studentGrade) {
                    gradeValue = studentGrade.grade;
                }
                // html +=
                    // '<tr>' +
                    // '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
                    // '<td>' + v.student.name + '</td>' +
                //     '<td><input type="text" class="form-control form-control-sm grade-input" name="grade[]" value="' + gradeValue +  '"></td>' +
                //     '<td><span class="grade-error text-danger"></span></td>' +
                //     '</tr>';
                // Show the grade value if it exists, otherwise show an input field
        if (gradeValue) {
            html += 
            '<tr>' +
            '<td>' + v.student.name + '</td>' +
            '<td>' + gradeValue + '</td>';
            '</tr>';
        } else {
          //   html += 
          //   '<tr>' +
          //  '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
          //   '<td>' + v.student.name + '</td>' +
          //   '<td><input type="text" class="form-control form-control-sm grade-input" name="grade[]" value=""></td>'+
          //   '<td><span class="grade-error text-danger"></span></td>' +
          //   '</tr>';
          html += 
            '<tr>' +
            '<input type="hidden" name="user_id[]" value="' + v.student.id + '">' +
            '<td>' + v.student.name + '</td>' +
            '<td><input type="text" class="form-control form-control-sm grade-input" name="grade[]" value=""></td>'+
            '<td><span class="grade-error text-danger"></span></td>' +
            '</tr>';
        }

            });
            $('#marks-entry-tr').html(html);
        }
    });
});



// $(document).on('input', '.grade-input', function() {
//     var grade = $(this).val();
//     var maxDigits = 3;
//     if (grade.length > maxDigits) {
//         $(this).val(grade.slice(0, maxDigits));
//         $(this).closest('tr').find('.grade-error').text('Grade should not exceed 3 digits');
//     } else {
//         $(this).closest('tr').find('.grade-error').empty();
//     }
// });
// $(document).on('input', '.grade-input', function() {
//     var grade = $(this).val();

//     // Check if the input is a valid number (either an integer or a decimal)
//     if (isNaN(grade) || parseFloat(grade) < 0 || parseFloat(grade) > 100) {
//         $(this).val('');
//         $(this).closest('tr').find('.grade-error').text('Invalid grade. Please enter a number between 0 and 100.');
//     } else {
//         var maxDigits = 5; // Allow up to 5 digits in total (including the decimal point)
//         var maxDecimalDigits = 1; // Allow up to 1 decimal digit

//         // Split the input by the decimal point (if any)
//         var parts = grade.split('.');
//         var wholePart = parts[0];
//         var decimalPart = parts[1] || '';

//         // Ensure the whole part has at most maxDigits - maxDecimalDigits digits
//         if (wholePart.length > maxDigits - maxDecimalDigits) {
//             wholePart = wholePart.slice(0, maxDigits - maxDecimalDigits);
//         }

//         // Combine the whole part and decimal part back together
//         var formattedGrade = wholePart;
//         if (decimalPart !== '') {
//             formattedGrade += '.' + decimalPart.slice(0, maxDecimalDigits);
//         }

//         // Update the input field value with the formatted grade
//         $(this).val(formattedGrade);
//         $(this).closest('tr').find('.grade-error').empty();
//     }
// });
$(document).on('input', '.grade-input', function() {
    var grade = $(this).val();

    // Check if the input is a valid number (either an integer or a decimal)
    if (!/^\d+(\.\d{0,1})?$/.test(grade) || parseFloat(grade) < 0 || parseFloat(grade) > 100) {
        $(this).val('');
        $(this).closest('tr').find('.grade-error').text('Invalid grade. Please enter a number between 0 and 100 with at most one decimal digit.');
    } else {
        // Update the input field value with the grade
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