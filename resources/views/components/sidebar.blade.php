<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="index3.html" class="brand-link">
      {{-- <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8"> --}}
      <span class="brand-text font-weight-light"><b>MyPackaging</b></span>
    </a>
    <div class="sidebar">
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
              <a href="{{url('dashboard')}}" class="nav-link {{Request::segment(1) === 'dashboard' ? 'active' : null}}">
                  <i class="fas fa-home"></i>
                  <p class="p-2">
                      Dashboard
                  </p>
              </a>
          </li>
          <li class="nav-item">
            <a href="{{url('user')}}" class="nav-link {{Request::segment(1) === 'user' ? 'active' : null}}">
              <i class="fas fa-user"></i>
              <p class="p-2">
                User
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('categories')}}" class="nav-link {{Request::segment(1) === 'categories' ? 'active' : null}}">
              <i class="fas fa-boxes"></i>
              <p class="p-2">
                Produk
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('discount')}}" class="nav-link {{Request::segment(1) === 'discount' ? 'active' : null}}">
              <i class="fas fa-tag"></i>
              <p class="p-2">
                Diskon
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('promo')}}" class="nav-link {{Request::segment(1) === 'promo' ? 'active' : null}}">
              <i class="fas fa-percent"></i>
              <p class="p-2">
                Promo
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('order')}}" id="data-order" class="nav-link {{Request::segment(1) === 'order' ? 'active' : null}}">
              <i class="fas fa-shopping-cart"></i>
              <p class="p-2">
                Pesanan
              </p>
              <span class="badge badge-warning right">{{ data_order() }}</span>
            </a>
          </li>
        </ul>
      </nav>
    </div>
</aside>