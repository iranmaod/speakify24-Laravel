<div class="site-menubar-body">
  <div>
    <div>
      <ul class="site-menu" data-plugin="menu">
        <!-- <li class="site-menu-category">General</li> -->
        <li class="site-menu-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <i class="site-menu-icon wb-dashboard" aria-hidden="true"></i>
                <span class="site-menu-title">Dashboard</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/user*') ? 'active' : '' }}">
            <a href="{{ route('admin.users') }}">
                <i class="site-menu-icon wb-user" aria-hidden="true"></i>
                <span class="site-menu-title">Users Management</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/course*') ? 'active' : '' }}">
            <a href="{{ route('admin.course.list') }}">
                <i class="site-menu-icon fas fa-chalkboard" aria-hidden="true"></i>
                <span class="site-menu-title">Courses Management</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/categor*') ? 'active' : '' }}">
            <a href="{{ route('admin.categories') }}">
                <i class="site-menu-icon wb-tag" aria-hidden="true"></i>
                <span class="site-menu-title">Categories</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/appointments*') ? 'active' : '' }}">
            <a href="{{ route('admin.appointment.listings') }}">
                <i class="site-menu-icon fas fa-calendar" aria-hidden="true"></i>
                <span class="site-menu-title">Appointments</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/teacherpayment*') ? 'active' : '' }}">
            <a href="{{ route('admin.teacherpayment') }}">
                <i class="site-menu-icon fas fa-comments" aria-hidden="true"></i>
                <span class="site-menu-title">Teacher Earning</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/coupons*') ? 'active' : '' }}">
            <a href="{{ route('admin.coupons') }}">
                <i class="site-menu-icon fas fa-gift" aria-hidden="true"></i>
                <span class="site-menu-title">Coupons</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/testimonials*') ? 'active' : '' }}">
            <a href="{{ route('admin.testimonials') }}">
                <i class="site-menu-icon fas fa-comments" aria-hidden="true"></i>
                <span class="site-menu-title">Testimonials</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/languages*') ? 'active' : '' }}">
            <a href="{{ route('admin.languages') }}">
                <i class="site-menu-icon fas fa-language" aria-hidden="true"></i>
                <span class="site-menu-title">Languages</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/subscriptions*') ? 'active' : '' }}">
            <a href="{{ route('admin.subscriptions') }}">
                <i class="site-menu-icon fas fa-credit-card" aria-hidden="true"></i>
                <span class="site-menu-title">Subscription Plans</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/member_subscriptions*') ? 'active' : '' }}">
            <a href="{{ route('admin.member.subscriptions') }}">
                <i class="site-menu-icon fas fa-credit-card" aria-hidden="true"></i>
                <span class="site-menu-title">User Subscriptions</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('messages*') ? 'active' : '' }}">
            <a href="{{ url('/messages') }}">
                <i class="site-menu-icon fas fa-comment-dots" aria-hidden="true"></i>
                <span class="site-menu-title">Messages</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('credits*') ? 'active' : '' }}">
            <a href="{{ url('/credits') }}">
              <i class="fas fa-solid fa-credit-card"></i>
                <span class="site-menu-title">Credits</span>
            </a>
        </li>
        <!-- <li class="site-menu-item {{ request()->is('admin/withdraw-requests') ? 'active' : '' }}">
            <a href="{{ route('admin.withdraw.requests') }}">
                <i class="site-menu-icon fas fa-hand-holding-usd" aria-hidden="true"></i>
                <span class="site-menu-title">Withdraw Requests</span>
            </a>
        </li>
        <li class="site-menu-item {{ request()->is('admin/blog*') ? 'active' : '' }}">
            <a href="{{ route('admin.blogs') }}">
                <i class="site-menu-icon fas fa-blog" aria-hidden="true"></i>
                <span class="site-menu-title">Blogs</span>
            </a>
        </li> -->

        <li class="site-menu-item has-sub {{ request()->is('admin/config/page-*') ? 'active open' : '' }}">
            <a href="javascript:void(0)">
                <i class="site-menu-icon wb-file" aria-hidden="true"></i>
                <span class="site-menu-title">Pages</span>
                <span class="site-menu-arrow"></span>
            </a>
            <ul class="site-menu-sub">
                <li class="site-menu-item {{ request()->is('admin/config/page-home') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageHome') }}">
                    <span class="site-menu-title">Home</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-login') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageLogin') }}">
                    <span class="site-menu-title">Login</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-reset') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageReset') }}">
                    <span class="site-menu-title">Reset Password</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-student-register') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageStudent') }}">
                    <span class="site-menu-title">Student Register</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-teacher-register') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageTeacher') }}">
                    <span class="site-menu-title">Teacher Register</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-about') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageAbout') }}">
                    <span class="site-menu-title">About Us</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-terms-conditions') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageTerm') }}">
                    <span class="site-menu-title">Terms & Conditions</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-platform') ? 'active' : '' }}">
                  <a href="{{ route('admin.pagePlatform') }}">
                    <span class="site-menu-title">Our Platform</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-method') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageMethod') }}">
                    <span class="site-menu-title">Our Method</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-ourteachers') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageOurInstructors') }}">
                    <span class="site-menu-title">Our Teachers</span>
                  </a>
                </li>
      
                <li class="site-menu-item {{ request()->is('admin/config/page-certificate') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageCertificate') }}">
                    <span class="site-menu-title">Our Certificates</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-english') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageEnglish') }}">
                    <span class="site-menu-title">English</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-dutch') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageDutch') }}">
                    <span class="site-menu-title">German</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-spanish') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageSpanish') }}">
                    <span class="site-menu-title">Spanish</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-italian') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageItalian') }}">
                    <span class="site-menu-title">Italian</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-schoolstudent') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageChildrens') }}">
                    <span class="site-menu-title">School Children & Student</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-citizen') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageCitizen') }}">
                    <span class="site-menu-title">Private Citizen</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-company') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageCompany') }}">
                    <span class="site-menu-title">For Companies</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-price') ? 'active' : '' }}">
                  <a href="{{ route('admin.pagePrice') }}">
                    <span class="site-menu-title">Prices</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-contact') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageContact') }}">
                    <span class="site-menu-title">Contact Us</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-hourly') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageHourly') }}">
                    <span class="site-menu-title">Hourly Package</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-monthly') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageMonthly') }}">
                    <span class="site-menu-title">Monthly Package</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-imprint') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageImprint') }}">
                    <span class="site-menu-title">Imprint</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-agreement') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageAgreement') }}">
                    <span class="site-menu-title">Data Protection Agreements</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/page-condition') ? 'active' : '' }}">
                  <a href="{{ route('admin.pageCondition') }}">
                    <span class="site-menu-title">Conditions</span>
                  </a>
                </li>
            </ul>
        </li>

        <li class="site-menu-item has-sub {{ request()->is('admin/config/setting-*') ? 'active open' : '' }}">
            <a href="javascript:void(0)">
                <i class="site-menu-icon fas fa-cogs" aria-hidden="true"></i>
                <span class="site-menu-title">Settings</span>
                <span class="site-menu-arrow"></span>
            </a>
            <ul class="site-menu-sub">
                <li class="site-menu-item {{ request()->is('admin/config/setting-general') ? 'active' : '' }}">
                  <a href="{{ route('admin.settingGeneral') }}">
                    <span class="site-menu-title">General</span>
                  </a>
                </li>
                <li class="site-menu-item {{ request()->is('admin/config/setting-payment') ? 'active' : '' }}">
                  <a href="{{ route('admin.settingPayment') }}">
                    <span class="site-menu-title">Payment</span>
                  </a>
                </li>
                <!-- <li class="site-menu-item {{ request()->is('admin/config/setting-email') ? 'active' : '' }}">
                  <a href="{{ route('admin.settingEmail') }}">
                    <span class="site-menu-title">Email</span>
                  </a>
                </li> -->
            </ul>
        </li>
        
      </ul>

      
    </div>
  </div>
</div>