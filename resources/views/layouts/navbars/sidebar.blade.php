<nav class="navbar navbar-vertical fixed-left navbar-expand-md navbar-light bg-white" id="sidenav-main">
    <div class="container-fluid">
        <!-- Toggler -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Brand -->
        <a class="navbar-brand pt-0" href="{{ route('home') }}">
            <img src="{{ asset('argon') }}/img/brand/blue.png" class="navbar-brand-img" alt="...">
        </a>
        <!-- User -->
        <ul class="nav align-items-center d-md-none">
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="media align-items-center">
                        <span class="avatar avatar-sm rounded-circle">
                        <img alt="Image placeholder" src="{{ asset('argon') }}/img/theme/team-1-800x800.jpg">
                        </span>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-right">
                    <div class=" dropdown-header noti-title">
                        <h6 class="text-overflow m-0">{{ __('Welcome!') }}</h6>
                    </div>
                    <a href="{{ route('profile.edit') }}" class="dropdown-item">
                        <i class="ni ni-single-02"></i>
                        <span>{{ __('My profile') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-settings-gear-65"></i>
                        <span>{{ __('Settings') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-calendar-grid-58"></i>
                        <span>{{ __('Activity') }}</span>
                    </a>
                    <a href="#" class="dropdown-item">
                        <i class="ni ni-support-16"></i>
                        <span>{{ __('Support') }}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                        <i class="ni ni-user-run"></i>
                        <span>{{ __('Logout') }}</span>
                    </a>
                </div>
            </li>
        </ul>
        <!-- Collapse -->
        <div class="collapse navbar-collapse" id="sidenav-collapse-main">
            <!-- Collapse header -->
            <div class="navbar-collapse-header d-md-none">
                <div class="row">
                    <div class="col-6 collapse-brand">
                        <a href="{{ route('home') }}">
                            <img src="{{ asset('argon') }}/img/brand/blue.png">
                        </a>
                    </div>
                    <div class="col-6 collapse-close">
                        <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#sidenav-collapse-main" aria-controls="sidenav-main" aria-expanded="false" aria-label="Toggle sidenav">
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- Form -->
            <form class="mt-4 mb-3 d-md-none">
                <div class="input-group input-group-rounded input-group-merge">
                    <input type="search" class="form-control form-control-rounded form-control-prepended" placeholder="{{ __('Search') }}" aria-label="Search">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <span class="fa fa-search"></span>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Navigation -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}">
                        <i class="ni ni-tv-2 text-primary"></i> {{ __('Dashboard') }}
                    </a>
                </li>
                @php $seg1 = Request::segment(1) @endphp
                <li class="nav-item">
                    @if( $seg1 == 'category' || $seg1 == 'company' || $seg1 == 'distributor' || $seg1 == 'product' || $seg1 == 'customer' || $seg1 == 'employee' || $seg1 == 'unit' || $seg1 == 'bankentry' || $seg1 == 'expense' || $seg1 == 'income' || $seg1 == 'card') @php $li1 = true @endphp @else @php $li1 = false @endphp  @endif
                    <a class="nav-link active" href="#navbar-examples" data-toggle="collapse" role="button" aria-expanded="@if($li1 == true){{"true"}}@else{{"false"}}@endif" aria-controls="navbar-examples">
                        <i class="fas fa-cog" style="color: #f4645f;"></i>
                        <span class="nav-link-text" style="color: #f4645f;">Setup</span>
                    </a>

                    <div class="collapse @if($li1 == true) show @endif" id="navbar-examples">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'category') bg-primary text-white @endif" href="{{ route('category.index') }}">
                                    Category Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'company') bg-primary text-white @endif" href="{{ route('company.index') }}">
                                    Company Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'distributor') bg-primary text-white @endif" href="{{ route('distributor.index') }}">
                                    Distributor Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'product') bg-primary text-white @endif" href="{{ route('product.index') }}">
                                    Product Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'customer') bg-primary text-white @endif" href="{{ route('customer.index') }}">
                                    Customer Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'employee') bg-primary text-white @endif" href="{{ route('employee.index') }}">
                                    Employee Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'unit') bg-primary text-white @endif" href="{{ route('unit.index') }}">
                                    Unit Setup
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'bankentry') bg-primary text-white @endif" href="{{ route('bankentry.index') }}">
                                    Bank Entry
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'expense') bg-primary text-white @endif" href="{{ route('expense.index') }}">
                                    Expense Entry
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'income') bg-primary text-white @endif" href="{{ route('income.index') }}">
                                    Income Entry
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link @if($seg1 == 'card') bg-primary text-white @endif" href="{{ route('card.index') }}">
                                    Card Entry
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                
            </ul>
            <!-- Divider -->
            <hr class="my-3">
            <!-- Heading -->
            <h6 class="navbar-heading text-muted">Documentation</h6>
            <!-- Navigation -->
            <ul class="navbar-nav mb-md-3">
                <li class="nav-item">
                    <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
                        <i class="ni ni-spaceship"></i> Getting started
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>