 <div class="app-sidebar-menu">
                <div class="h-100" data-simplebar>

                    <!--- Sidemenu -->
                    <div id="sidebar-menu">

                        <div class="logo-box">
                            <a href="{{ route('dashboard') }}" class="logo logo-light">
                                <span class="logo-sm">
                                   <img src="{{ asset('backend/assets/images/logo.webp')}}" alt="" height="32">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('backend/assets/images/logo.webp')}}" alt="" height="32">
                                </span>
                            </a>
                            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                                <span class="logo-sm">
                                   <img src="{{ asset('backend/assets/images/logo.webp')}}" alt="" height="32">
                                </span>
                                <span class="logo-lg">
                                    <img src="{{ asset('backend/assets/images/logo.webp')}}" alt="" height="32">
                                </span>
                            </a>
                        </div>

                        <ul id="side-menu">

                            <li class="menu-title">Menu</li>

                            <li>
                                <a href="{{ route('dashboard')}}">
                                    <i data-feather="home"></i>
                                    <span> Dashboard </span>
                                   
                                </a>
                              
                            </li>
                
                            <li class="menu-title">Docs</li>

                            <li>
                                <a href="#sidebarAuth" data-bs-toggle="collapse">
                                    <i data-feather="package"></i>
                                    <span> Documents </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="sidebarAuth">
                                    <ul class="nav-second-level">

                                        <li>
                                            <a href="{{ route('documents.index') }}" class="tp-link">All Documents</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('documents.create') }}" class="tp-link">Add New Documents</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>



                            <li class="menu-title mt-2">Tags</li>

                            <li>
                                <a href="#application" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Application </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="application">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'applications') }}" class="tp-link">All Applications</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.create', 'applications') }}" class="tp-link">Add New Application</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                             <li>
                                <a href="#brands" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Brands </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="brands">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'brands') }}" class="tp-link">All Brands</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.create', 'brands') }}" class="tp-link">Add New Brand</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                              <li>
                                <a href="#documents" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Document Types </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="documents">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'document-types') }}" class="tp-link">All Document Types</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.create', 'document-types') }}" class="tp-link">Add New Documents Type</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                             <li>
                                <a href="#locations" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Location </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="locations">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'locations') }}" class="tp-link">All Locations</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.create', 'locations') }}" class="tp-link">Add New Location</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#productCategory" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Product Category </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="productCategory">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'product-categories') }}" class="tp-link">All Categories</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.create', 'product-categories') }}" class="tp-link">Add New Category</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#solutions" data-bs-toggle="collapse">
                                    <i data-feather="file-text"></i>
                                    <span> Solutions </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="solutions">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'solutions') }}" class="tp-link">All Solutions</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('taxonomy.index', 'solutions') }}" class="tp-link">Add New Solution</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>
                            
                           
                          
                           

                        </ul>
            
                    </div>
                    <!-- End Sidebar -->

                    <div class="clearfix"></div>

                </div>
            </div>