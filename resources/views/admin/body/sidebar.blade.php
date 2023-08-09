@php

 $route = Route::current()->getName();

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
						  <h3><b>Yas</b> Admin</h3>
					 </div>
				</a>
			</div>
        </div>
      
      <!-- sidebar menu-->
      <ul class="sidebar-menu" data-widget="tree">  
		  
		<li class="{{ ($route == 'admin.dashboard')?'active':'' }}">
          <a href="{{ route('admin.dashboard')}}">
            <i data-feather="pie-chart"></i>
			<span>Dashboard</span>
          </a>
        </li>  
		
   
          <li class="treeview">
          <a href="#">
            <i data-feather="message-circle"></i>
            <span>Manage User</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'user.view')?'active':'' }}"><a href="{{ route('user.view') }}"><i class="ti-more"></i>View User</a></li>
            <li class="{{ ($route == 'user.add')?'active':'' }}"><a href="{{ route('user.add') }}"><i class="ti-more"></i>Add User</a></li>
            <li class="{{ ($route == 'user.edit')?'active':'' }}"></li>
          </ul>
        </li> 


        
        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Student Management</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'student.reg.view')?'active':'' }}"><a href="{{ route('student.reg.view') }}"><i class="ti-more"></i>Student Registration</a></li>
           
          </ul>
        </li>
		  
        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Manage Profile</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'profile.view')?'active':'' }}"><a href="{{ route('profile.view') }}"><i class="ti-more"></i>Your Profile</a></li>
            <li class="{{ ($route == 'password.view')?'active':'' }}"><a href="{{ route('password.view') }}"><i class="ti-more"></i>Change Password</a></li>
            <li class="{{ ($route == 'profile.edit')?'active':'' }}"> </li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Manage Classes</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'student.class.view')?'active':'' }}"><a href="{{ route('student.class.view') }}"><i class="ti-more"></i>View Class</a></li>
            <li class="{{ ($route == 'student.class.add')?'active':'' }}"> </li>
            <li class="{{ ($route == 'student.class.edit')?'active':'' }}"> </li> 
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Manage Subjects</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'school.subject.view')?'active':'' }}"><a href="{{ route('school.subject.view') }}"><i class="ti-more"></i>View Subject</a></li>
            <li class="{{ ($route == 'school.subject.add')?'active':'' }}"> </li>
            <li class="{{ ($route == 'school.subject.edit')?'active':'' }}"> </li> 
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i data-feather="grid"></i> <span>Assign Subjects to Class</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-right pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ ($route == 'assign.subject.view')?'active':'' }}"><a href="{{ route('assign.subject.view') }}"><i class="ti-more"></i>Assign Subject</a></li>
            <li class="{{ ($route == 'assign.subject.add')?'active':'' }}"> </li>
            <li class="{{ ($route == 'assign.subject.edit')?'active':'' }}"> </li> 
          </ul>
        </li>
		

        
      </ul>
    </section>
	
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
