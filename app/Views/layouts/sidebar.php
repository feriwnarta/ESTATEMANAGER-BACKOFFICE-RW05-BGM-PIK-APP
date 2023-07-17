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
                <div class="accordion-toggle" onclick="toggleAccordion('userSubMenu')">OTP
                    <span class="accordion-icon">▼</span>
                </div>
                <ul class="sub-menu accordion-content" id="userSubMenu">
                    <li><a class="nav-link" href="users">All Users</a></li>
                    <li><a class="nav-link" href="add-user">Add User</a></li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="otp" class="links">
                    <div class="accordion-toggle">OTP</div>
                </a>
            </li>

            <!-- <li class="nav-item">
                <div class="accordion-toggle" onclick="toggleAccordion('userSubMenu')">Setting Firebase
                    <span class="accordion-icon">▼</span>
                </div>
                <ul class="sub-menu accordion-content" id="userSubMenu">
                    <li><a class="nav-link" href="crashlytic">Crashlytic</a></li>
                    <li><a class="nav-link" href="firebase">Firebase</a></li>
                </ul>
            </li> -->
        </ul>
    </div>
</nav>