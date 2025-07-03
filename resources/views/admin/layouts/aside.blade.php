		<!-- Main Menu -->
	<div data-simplebar class="nicescroll-bar">
	    <div class="menu-content-wrap">
	        <div class="menu-group">
	            <div class="nav-header">
	                <span>E-commerce</span>
	            </div>
	                        <ul class="navbar-nav flex-column">
                <li class="nav-item {{ request()->routeIs('admin.home') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('admin.home') }}">
                        <span class="nav-icon-wrap">
                            <span class="svg-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-home" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <polyline points="5,12 3,12 12,3 21,12 19,12" />
                                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                                </svg>
                            </span>
                        </span>
                        <span class="nav-link-text">{{ __('Home') }}</span>
                    </a>
                </li>
                <li class="nav-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.categories.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-category-2" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M14 4h6v6h-6z" />
	                                    <path d="M4 14h6v6h-6z" />
	                                    <circle cx="17" cy="17" r="3" />
	                                    <circle cx="7" cy="7" r="3" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Categories') }}</span>
	                    </a>
	                </li>
					<li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.products.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-package" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <polyline points="12,3 20,7.5 20,16.5 12,21 4,16.5 4,7.5 12,3" />
	                                    <line x1="12" y1="12" x2="20" y2="7.5" />
	                                    <line x1="12" y1="12" x2="4" y2="7.5" />
	                                    <line x1="12" y1="12" x2="12" y2="21" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Products') }}</span>
	                    </a>
	                </li>
					<li class="nav-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.brands.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-tag" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M7.5 7.5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />
	                                    <path d="M3 6v5.172a2 2 0 0 0 .586 1.414l8.5 8.5a2.828 2.828 0 0 0 4 0l4.828 -4.828a2.828 2.828 0 0 0 0 -4l-8.5 -8.5a2 2 0 0 0 -1.414 -.586h-5.172a2 2 0 0 0 -2 2z" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Brands') }}</span>
	                    </a>
	                </li>
					<li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.orders.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-shopping-cart" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <circle cx="6" cy="19" r="2" />
	                                    <circle cx="17" cy="19" r="2" />
	                                    <path d="M17 17h-11v-14h-2" />
	                                    <path d="M6 5l14 1l-1 7h-13" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Orders') }}</span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	        
	        <!-- Website Content Management Section -->
	        <div class="menu-group">
	            <div class="nav-header">
	                <span>{{ __('Website Content') }}</span>
	            </div>
	            <ul class="navbar-nav flex-column">
	                <li class="nav-item {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.sliders.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-slideshow" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M15 6l.01 0" />
	                                    <rect x="3" y="3" width="18" height="14" rx="3" />
	                                    <path d="M3 13l4 -4a3 5 0 0 1 3 0l4 4" />
	                                    <path d="M13 12l2 -2a3 5 0 0 1 2 0l2 2" />
	                                    <path d="M8 21l.01 0" />
	                                    <path d="M12 21l.01 0" />
	                                    <path d="M16 21l.01 0" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Sliders') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.banners.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-photo" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <rect x="3" y="3" width="18" height="14" rx="3" />
	                                    <path d="M3 13l4 -4a3 5 0 0 1 3 0l4 4" />
	                                    <path d="M13 12l2 -2a3 5 0 0 1 2 0l2 2" />
	                                    <path d="M9 8h.01" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Banners') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.special-offers.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.special-offers.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-gift" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <rect x="3" y="8" width="18" height="4" rx="1" />
	                                    <line x1="12" y1="8" x2="12" y2="21" />
	                                    <path d="M19 12v7a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-7" />
	                                    <path d="M7.5 8a2.5 2.5 0 0 1 0 -5a4.9 4.9 0 0 1 6 6a4.9 4.9 0 0 1 6 -6a2.5 2.5 0 0 1 0 5" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Special Offers') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.blogs.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-blog" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M4 6h16a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-16a2 2 0 0 1 -2 -2v-10a2 2 0 0 1 2 -2" />
	                                    <path d="M4 10h16" />
	                                    <path d="M10 14h6" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Blogs') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.about.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.about.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-info-circle" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <circle cx="12" cy="12" r="9" />
	                                    <line x1="12" y1="8" x2="12.01" y2="8" />
	                                    <polyline points="11,12 12,12 12,16 13,16" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('About Us') }}</span>
	                    </a>
	                </li>
	                <li class="nav-item {{ request()->routeIs('admin.team.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.team.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <circle cx="9" cy="7" r="4" />
	                                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
	                                    <circle cx="16" cy="11" r="3" />
	                                    <path d="M16 21v-1a4 4 0 0 0 -4 -4h-1" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Team') }}</span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	        
	        <!-- System Settings Section -->
	        <div class="menu-group">
	            <div class="nav-header">
	                <span>{{ __('System') }}</span>
	            </div>
	            <ul class="navbar-nav flex-column">
	                <li class="nav-item {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
	                    <a class="nav-link" href="{{ route('admin.settings.index') }}">
	                        <span class="nav-icon-wrap">
	                            <span class="svg-icon">
	                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-settings" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
	                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
	                                    <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
	                                    <circle cx="12" cy="12" r="3" />
	                                </svg>
	                            </span>
	                        </span>
	                        <span class="nav-link-text">{{ __('Settings') }}</span>
	                    </a>
	                </li>
	            </ul>
	        </div>
	    </div>
	</div>
	<!-- /Main Menu -->