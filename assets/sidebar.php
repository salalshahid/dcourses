<!-- start sidebar -->
<div class="col-auto vh-100 border-end sticky-top px-0  ccolor  myside">
                <div id="sidebar" class="collapse collapse-horizontal
                    dont-collapse-sm py-5">
                    <div id="sidebar-nav" class="mt-4">
                        <ul class="nav nav-pills mt-4 ms-2 flex-column mb-auto px-0 me-2">
                            <li class="nav-item"></li>
                            <li class="mb-1 <?php if ($filename == 'dashboard') { echo ' asidebar rounded';  } ?>">
                                <a href="dashboard.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                              
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house-door-fill" viewBox="0 0 16 16">
                                <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5Z"/>
                                </svg>
                                <div class="ps-2 pt-2 mb-2 fw-bold">Dashboard</div>
                            </div> 

                            
                            </a>
                            </li>


                            <li class="mb-1 <?php if ($filename == 'VIP') { echo ' asidebar rounded';  } ?>">
                                <a href="vip.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                              
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gem" viewBox="0 0 16 16">
  <path d="M3.1.7a.5.5 0 0 1 .4-.2h9a.5.5 0 0 1 .4.2l2.976 3.974c.149.185.156.45.01.644L8.4 15.3a.5.5 0 0 1-.8 0L.1 5.3a.5.5 0 0 1 0-.6l3-4zm11.386 3.785-1.806-2.41-.776 2.413 2.582-.003zm-3.633.004.961-2.989H4.186l.963 2.995 5.704-.006zM5.47 5.495 8 13.366l2.532-7.876-5.062.005zm-1.371-.999-.78-2.422-1.818 2.425 2.598-.003zM1.499 5.5l5.113 6.817-2.192-6.82L1.5 5.5zm7.889 6.817 5.123-6.83-2.928.002-2.195 6.828z"/>
</svg>
                                <div class="ps-2 pt-2 mb-2 fw-bold">Purchased Courses</div>
                            </div> 

                            
                            </a>
                            </li>

                            <?php if ($_SESSION['activeuser'] == 1) {
                            ?>


                            <li class="mb-1 <?php if ($filename == 'courses') { echo ' asidebar rounded';  } ?>">
                                <a href="courses.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                              
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-bookmark-fill" viewBox="0 0 16 16">
  <path d="M2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2z"/>
</svg>
                                <div class="ps-2 pt-2 mb-2 fw-bold">Courses</div>
                            </div> 

                            
                            </a>
                            </li>

                            <li class="mb-1 <?php if ($filename == 'Lectures') { echo ' asidebar rounded';  } ?>">
                                <a href="lectures.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                              
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-journal-medical" viewBox="0 0 16 16">
  <path fill-rule="evenodd" d="M8 4a.5.5 0 0 1 .5.5v.634l.549-.317a.5.5 0 1 1 .5.866L9 6l.549.317a.5.5 0 1 1-.5.866L8.5 6.866V7.5a.5.5 0 0 1-1 0v-.634l-.549.317a.5.5 0 1 1-.5-.866L7 6l-.549-.317a.5.5 0 0 1 .5-.866l.549.317V4.5A.5.5 0 0 1 8 4zM5 9.5a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5z"/>
  <path d="M3 0h10a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-1h1v1a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H3a1 1 0 0 0-1 1v1H1V2a2 2 0 0 1 2-2z"/>
  <path d="M1 5v-.5a.5.5 0 0 1 1 0V5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0V8h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1zm0 3v-.5a.5.5 0 0 1 1 0v.5h.5a.5.5 0 0 1 0 1h-2a.5.5 0 0 1 0-1H1z"/>
</svg>
                                <div class="ps-2 pt-2 mb-2 fw-bold">Lectures</div>
                            </div> 

                            
                            </a>
                            </li>


                          


       <li class="mb-1 <?php if ($filename == 'member') { echo ' asidebar rounded';  } ?>">
                                <a href="member.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                                <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1H7Zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm-5.784 6A2.238 2.238 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.325 6.325 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1h4.216ZM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"/>
                                </svg>
                                <div class="ps-2 pt-2  mb-2 fw-bold">Members</div>
                            </div> 

                            
                            </a>
                            </li>
                           
                            <li class="mb-1 <?php if ($filename == 'settings') { echo ' asidebar rounded';  } ?>">
                                <a href="settings.php" class="nav-link text-light "> 

                                <div class="ms-2 d-flex align-items-center" role="alert">
                                <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class=" img-fluid bi bi-gear-fill" viewBox="0 0 16 16">
                                <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z"/>
                                </svg>  
                                <div class="ps-2 pt-2  mb-2 fw-bold">Settings</div>
                            </div> 

                            
                            </a>
                            </li>

                            <?php
                            }else{

                            }
                            ?>

                        </ul>
                    </div>
                </div>
</div>                
                <!-- end sidebar -->