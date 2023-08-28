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
            <li class="py-1"><a href="{{route(currentUser().'.bill.index')}}">{{__('Bill Term')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.supplier.index')}}">{{__('Distributor')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.customer.index')}}">{{__('Customers')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.shop.index')}}">{{__('Shop')}}</a></li>

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
     {{--  <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-gear-fill"></i><span>{{__('Employee Settings')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.designation.index')}}" >{{__('Designation list')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.employee.index')}}" >{{__('Employee list')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.emLeave.index')}}" >{{__('Employee Leave list')}}</a></li>
		</ul>
    </li>  --}}

    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-boxes"></i><span>{{__('Products')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.category.index')}}" >{{__('Category')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.group.index')}}" >{{__('Group')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.batch.index')}}" >{{__('Batch')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.product.index')}}" >{{__('Product')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.returnproduct.index')}}" >{{__('Return Product')}}</a></li>
		</ul>
    </li>
    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-boxes"></i><span>{{__('DO Setting')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.docontroll.create')}}" >{{__('Do')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.docontroll.index')}}" >{{__('Do List')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.doreceive')}}" >{{__('Do Receive')}}</a></li>
		</ul>
    </li>
    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-boxes"></i><span>{{__('Sales')}}</span>
        </a>
        <ul class="submenu">
            <li class="py-1"><a href="{{route(currentUser().'.sales.create')}}" >{{__('New Sales')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.sales.index')}}" >{{__('Sales List')}}</a></li>
            {{--  <li class="py-1"><a href="{{route(currentUser().'.sales.edit',1)}}" >{{__('Sales Return')}}</a></li>  --}}
		</ul>
    </li>
    <li class="sidebar-item has-sub">
        <a href="#" class='sidebar-link'><i class="bi bi-card-checklist"></i><span>{{__('Report')}}</span>
        </a>
        <ul class="submenu">
            {{-- <li class="py-1"><a href="{{route(currentUser().'.preport')}}" >{{__('Purchase Report')}}</a></li> --}}
            <li class="py-1"><a href="{{route(currentUser().'.sreport')}}" >{{__('Stock Report')}}</a></li>
            <li class="py-1"><a href="{{route(currentUser().'.shopdue')}}" >{{__('Shop Due Report')}}</a></li>
		</ul>
    </li>

</ul>
