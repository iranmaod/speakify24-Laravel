<ul class="nav nav-tabs mb-4">
    <li class="nav-item">
        <a class="nav-link py-1 {{ request()->is('instructor-profile*') ? 'active' : '' }}" href="@if($instructor->id) {{ route('instructor.profile.get') }} @else {{ route('instructor.dashboard') }} @endif">Info</a>
    </li>
    <li class="nav-item">
        <a class="nav-link py-1 {{ request()->is('instructor-job*') ? 'active' : '' }} @if(!$instructor->id) {{ 'instructor-id-empty' }} @endif" href="@if($instructor->id) {{ route('instructor.job.get.edit', $instructor->id) }} @else {{ 'javascript:void();' }} @endif">Job</a>
    </li>
	 <li class="nav-item">
        <a class="nav-link py-1 {{ request()->is('instructor-edu*') ? 'active' : '' }} @if(!$instructor->id) {{ 'instructor-id-empty' }} @endif" href="@if($instructor->id) {{ route('instructor.edu.get.edit', $instructor->id) }} @else {{ 'javascript:void();' }} @endif">Education</a>
    </li>
</ul>