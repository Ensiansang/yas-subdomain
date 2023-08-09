@php

 $route = Route::current()->getName();
 $user = DB::table('users')->where('name',Auth::user()->name)->first();
 @endphp

<aside class="main-sidebar">
    <!-- sidebar-->
    <section class="sidebar">	
		
        <div class="user-profile">
			<div class="ulogo">
				 <a href="index.html">
				  <!-- logo for regular state and mobile devices -->
					 <div class="d-flex align-items-center justify-content-center">					 	
						  <img src="{{asset('backend/images/logo-dark.png')}}" alt="">
						  <h3><b>{{ $user->name }}</b> Dashboard</h3>
					 </div>
				</a>
			</div>
        </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">  
		  
		<li class="{{ ($route == 'teacher.dashboard')?'active':'' }}">
          <a href="{{ route('teacher.dashboard')}}">
            <i data-feather="pie-chart"></i>
			<span>Dashboard</span>
          </a>
        </li>  
		
        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Marks Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'mark.add')?'active':'' }}"><a href="{{ route('mark.add') }}"><i class="ti-more"></i>Mark Add</a></li>
            <li class="{{ ($route == 'mark.edit')?'active':'' }}"><a href="{{ route('mark.edit') }}"><i class="ti-more"></i>Mark Edit</a></li>
           
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Upload Grade IMG/PDF</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'img.pdf.add')?'active':'' }}"><a href="{{ route('img.pdf.add') }}"><i class="ti-more"></i>IMG/PDF Add</a></li>
            <li class="{{ ($route == 'img.pdf.edit')?'active':'' }}"><a href="{{ route('img.pdf.edit') }}"><i class="ti-more"></i>IMG/PDF Edit</a></li>
            <li class="{{ ($route == 'img.pdf.delete')?'active':'' }}"><a href="{{ route('img.pdf.delete') }}"><i class="ti-more"></i>IMG/PDF Delete</a></li>
           
          </ul>
        </li>
		  

		
       
		 

        
      </ul>
    </section>
	
	<!-- <div class="sidebar-footer">
		item
		<a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Settings" aria-describedby="tooltip92529"><i class="ti-settings"></i></a>
		item
		<a href="mailbox_inbox.html" class="link" data-toggle="tooltip" title="" data-original-title="Email"><i class="ti-email"></i></a>
		item
		<a href="javascript:void(0)" class="link" data-toggle="tooltip" title="" data-original-title="Logout"><i class="ti-lock"></i></a>
	</div> -->
  </aside>
<script>
  document.getElementById('manageUserMenuItem').addEventListener('click', function() {
  var activeItem = document.querySelector('.treeview.active');
  if (activeItem) {
    activeItem.classList.remove('active');
  }
  this.classList.add('active');
});

</script>