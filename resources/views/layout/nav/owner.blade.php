<ul class="menu">
    <li class="sidebar-item">
        <a href="{{route(currentUser().'.dashboard')}}" class='sidebar-link'>
            <i class="bi bi-grid-fill"></i>
            <span>{{__('dashboard') }}</span>
        </a>
    </li>
    
    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'>
            <i class="bi bi-gear-fill"></i>
            <span>{{__('Settings')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.company.index')}}">{{__('Company Details')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.users.index')}}">{{__('Users')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.werehouse.index')}}">{{__('Werehouse')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.supplier.index')}}">{{__('Suppliers')}}</a></li>
            
            <li class="submenu-item sidebar-item has-sub"><a href="#" class='sidebar-link'> {{__('Unit')}}</a>
                <ul class="submenu">
                    <li class="py-1"><a href="{{route(currentUser().'.unitstyle.index')}}">{{__('Unit Style')}}</a></li>
                    <li class="py-1"><a href="{{route(currentUser().'.unit.index')}}">{{__('Unit')}}</a></li>
                </ul>
            </li>

		</ul>
        
    </li>


    {{-- <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-calculator"></i><span>{{__('Accounts')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.master.index')}}" >{{__('Master Head')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.sub_head.index')}}" >{{__('Sub Head')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.child_one.index')}}" >{{__('Child One')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.child_two.index')}}" >{{__('Child Two')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.navigate.index')}}">{{__('Navigate View')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.incomeStatement')}}">{{__('Income Statement')}}</a></li>
            
            <li class="submenu-item sidebar-item has-sub"><a href="#" class='sidebar-link'>{{__('Voucher')}}</a>
                <ul class="submenu">
                    <li class="py-1"><a href="{{route(currentUser().'.credit.index')}}">{{__('Credit Voucher')}}</a></li>
                    <li class="py-1"><a href="{{route(currentUser().'.debit.index')}}">{{__('Debit Voucher')}}</a></li>
                    <li class="py-1"><a href="{{route(currentUser().'.journal.index')}}">{{__('Journal Voucher')}}</a></li>
                </ul>
            </li>
		</ul>
        
    </li> --}}
    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-gear-fill"></i><span>{{__('Employee Settings')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.designation.index')}}" >{{__('Designation list')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.employee.index')}}" >{{__('Employee list')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.emLeave.index')}}" >{{__('Employee Leave list')}}</a></li>
		</ul>
    </li>
    
</ul>