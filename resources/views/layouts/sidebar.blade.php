<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="/dashboard" class="brand-link">
    <img src="/dist/img/AdminLTELogo.png" alt="AmoraPH" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light">AmoraPH</span>
  </a>

  <div class="sidebar">
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image d-none">
        <img src="/dist/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info ml-2">
        <a href="#" class="d-block">Hi, {{ $user->name }}</a>
      </div>
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

        <li class="nav-item">
          <a href="/dashboard" class="nav-link">
            <i class="nav-icon fas fa-th"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-warehouse"></i>
            <p>
              Products
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/products/shopee" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Shopee</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/products/lazada" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Lazada</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/products/shopify" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Shopify</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="/settings" class="nav-link">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Settings
            </p>
          </a>
        </li>
      </ul>
    </nav>

  </div>
</aside>