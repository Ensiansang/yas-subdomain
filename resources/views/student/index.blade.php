@extends('student.student_master')
@section('student')

  <div class="content-wrapper">
	  <div class="container-full">

		<!-- Main content -->
		<section class="content">
			<div class="row">
				
 
 
 
 
<div class="col-12">
<div class="box">
<div class="box-header">
<h1 class="box-title align-items-center d-flex justify-content-center flex-column">
			Welcome {{ $userName }} to your Dashboard
			
		</h1>
		<!-- @if ($grades->count() > 0)
            <h2>Your Grades:</h2>
            <ul>
                @foreach ($grades as $grade)
                    <li>Subject: {{ $grade->assign_subject->school_subject->name }}, Grade: {{ $grade->grade }}</li>
                @endforeach
            </ul>
        @else
            <p>No grades assigned yet.</p>
        @endif -->
	</div>
	<div class="box-body">
		<div class="table-responsive">
			<table class="table no-border">
				<thead>
					<tr class="text-uppercase bg-lightest">
						<!-- <th style="min-width: 250px"><span class="text-white">Name</span></th> -->
						<th style="min-width: 100px"><span class="text-fade">Subject</span></th>
						<th style="min-width: 100px"><span class="text-fade">Grade</span></th>
						<th style="min-width: 150px"><span class="text-fade">Teacher</span></th>
						<th style="min-width: 130px"><span class="text-fade">Status</span></th>
						<!-- <th style="min-width: 100px"><span class="text-fade">Download</span></th> -->
						<!-- <th style="min-width: 120px"></th> -->
					</tr>
				</thead>
				<tbody>
				@if ($grades->count() > 0)
				@foreach ($grades as $grade)
				@php
        $studentName = $grade->student->name; // Fetch the student's name using the user relationship
    @endphp
					<tr>										
						<!-- <td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
	 <div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-1.jpg)"></div>
								</div>

								<div>
									<a class="text-white font-weight-600 font-size-16"> {{ $studentName }}</a>
									<span class="text-fade d-block">Pharetra, Nulla , Nec, Aliquet</span>
								</div>
							</div>
						</td> -->
					
						
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
							{{ $grade->assign_subject->school_subject->name }}
							</span>
							<!-- <span class="text-white font-weight-600 d-block font-size-16">
								$45,800k
							</span> -->
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
							{{ $grade->grade }}
							</span>
							<!-- <span class="text-white font-weight-600 d-block font-size-16">
								$45k
							</span> -->
						</td>
						<td>
							<!-- <span class="text-fade font-weight-600 d-block font-size-16">
								Sophia
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								Pharetra
							</span> -->
							
						</td>
						<td>
							<span class="badge badge-primary-light badge-lg">Graded</span>
						</td>
						<td>
					
						</td>
						</tr>
						<tr>
							<td>
						@endforeach
						@if ($grade->gradeReportCard && $grade->gradeReportCard->user_id == Auth::id())
						<a href="{{ route('student.download.grade.report', ['id' => $grade->gradeReportCard->id, 'type' => 'pdf']) }}" class="btn btn-primary">Download PDF</a>
    <a href="{{ route('student.download.grade.report', ['id' => $grade->gradeReportCard->id, 'type' => 'image']) }}" class="btn btn-primary">Download Image</a>
@else
    
            No File Available
        @endif
		</td>
</tr>
						@else
						<tr>										
						<td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
	 <!-- <div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-1.jpg)"></div> -->
								</div>

								<div>
									<a class="text-white font-weight-600 mb-1 font-size-16"> - </a>
									<!-- <span class="text-fade d-block"></span> -->
								</div>
							</div>
						</td>
					
						
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
							-
							</span>
							<!-- <span class="text-white font-weight-600 d-block font-size-16">
								
							</span> -->
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
							-
							</span>
							<!-- <span class="text-white font-weight-600 d-block font-size-16">
								
							</span> -->
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								-
							</span>
							<!-- <span class="text-white font-weight-600 d-block font-size-16">
								
							</span> -->
						</td>
						<td>
						<span class="badge badge-warning-light badge-lg">In Progress</span>
						</td>
						@endif
						<!-- <td class="text-right">
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-bookmark-plus"></span></a>
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-arrow-right"></span></a>
						</td> -->
					</tr>
					<!-- <tr>										
						<td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
							<div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-2.jpg)"></div>
								</div>

								<div>
									<a href="#" class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus consectetur</a>
									<span class="text-fade d-block">Pharetra, Nulla , Nec, Aliquet</span>
								</div>
							</div>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45,800k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Sophia
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								Pharetra
							</span>
						</td>
						<td>
							<span class="badge badge-warning-light badge-lg">In Progress</span>
						</td>
						<td class="text-right">
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-bookmark-plus"></span></a>
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-arrow-right"></span></a>
						</td>
					</tr> -->
					<!-- <tr>										
						<td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
									<div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-3.jpg)"></div>
								</div>

								<div>
									<a href="#" class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus consectetur</a>
									<span class="text-fade d-block">Pharetra, Nulla , Nec, Aliquet</span>
								</div>
							</div>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45,800k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Sophia
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								Pharetra
							</span>
						</td>
						<td>
							<span class="badge badge-success-light badge-lg">Success</span>
						</td>
						<td class="text-right">
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-bookmark-plus"></span></a>
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-arrow-right"></span></a>
						</td>
					</tr> -->
					<!-- <tr>										
						<td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
									<div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-4.jpg)"></div>
								</div>

								<div>
									<a href="#" class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus consectetur</a>
									<span class="text-fade d-block">Pharetra, Nulla , Nec, Aliquet</span>
								</div>
							</div>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45,800k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Sophia
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								Pharetra
							</span>
						</td>
						<td>
							<span class="badge badge-danger-light badge-lg">Rejected</span>
						</td>
						<td class="text-right">
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-bookmark-plus"></span></a>
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-arrow-right"></span></a>
						</td>
					</tr> -->
					<!-- <tr>										
						<td class="pl-0 py-8">
							<div class="d-flex align-items-center">
								<div class="flex-shrink-0 mr-15">
									<div class="bg-img h-50 w-50" style="background-image: url(../images/gallery/creative/img-5.jpg)"></div>
								</div>

								<div>
									<a href="#" class="text-white font-weight-600 hover-primary mb-1 font-size-16">Vivamus consectetur</a>
									<span class="text-fade d-block">Pharetra, Nulla , Nec, Aliquet</span>
								</div>
							</div>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45,800k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Paid
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								$45k
							</span>
						</td>
						<td>
							<span class="text-fade font-weight-600 d-block font-size-16">
								Sophia
							</span>
							<span class="text-white font-weight-600 d-block font-size-16">
								Pharetra
							</span>
						</td>
						<td>
							<span class="badge badge-warning-light badge-lg">In Progress</span>
						</td>
						<td class="text-right">
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-bookmark-plus"></span></a>
							<a href="#" class="waves-effect waves-light btn btn-info btn-circle mx-5"><span class="mdi mdi-arrow-right"></span></a>
						</td>
					</tr> -->
				</tbody>
			</table>
		</div>
	</div>
</div>  
				</div>
			</div>
		</section>
		<!-- /.content -->
	  </div>
  </div>

  @endsection