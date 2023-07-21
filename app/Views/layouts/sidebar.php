<!-- Sidebar  -->
<nav id="sidebar">
    <div class="sidebar-header">
        <h3 class="text-dark">
            <img src="" alt="" srcset="">
        </h3>
    </div>

    <div class="link-menu">
        <ul class="navbar-nav">
            <!-- <li class="nav-item">
                <div class="accordion-toggle">Dashboard</div>
            </li> -->
            <!-- <li class="nav-item">
                <a href="users" class="links">
                    <div class="accordion-toggle">User</div>
                </a>
            </li> -->
            <li class="nav-item">
                <div class="accordion-toggle" onclick="toggleAccordion('userSubMenu')">User
                    <span class="accordion-icon">▼</span>
                </div>
                <ul class="sub-menu accordion-content" id="userSubMenu">
                    <li><a class="nav-link" href="users">All Users</a></li>
                    <li><a class="nav-link" href="add-user">Add User</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <div class="accordion-toggle" onclick="toggleAccordion('auth')">Authorization
                    <span class="accordion-icon">▼</span>
                </div>
                <ul class="sub-menu accordion-content" id="auth">
                    <li><a class="nav-link" href="auth">Auth</a></li>
                    <li><a class="nav-link" href="new-auth">Add Auth</a></li>
                </ul>
            </li>
<!--            <li class="nav-item">-->
<!--                <div class="accordion-toggle" onclick="toggleAccordion('complaintAndRequest')">Complaint & Request-->
<!--                    <span class="accordion-icon">▼</span>-->
<!--                </div>-->
<!--                <ul class="sub-menu accordion-content" id="complaintAndRequest">-->
<!--                    <li><a class="nav-link" href="complaint">Complaint</a></li>-->
<!--                    <li><a class="nav-link" href="request">Request</a></li>-->
<!--                </ul>-->
<!--            </li>-->
            <li class="nav-item">
                <a href="otp" class="links">
                    <div class="accordion-toggle">OTP</div>
                </a>
            </li>


        </ul>
    </div>
</nav>