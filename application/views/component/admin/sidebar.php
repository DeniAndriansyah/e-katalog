<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="<?=base_url('dashboard')?>">Inzomnia</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="<?=base_url('dashboard')?>">INZ</a>
        </div>
        <ul class="sidebar-menu">
            <li class="<?=$this->uri->segment(1) === 'dashboard' ? "active" : ""?>"><a class="nav-link"
                    href="<?=base_url('dashboard')?>"><i class="fas fa-fire"></i> <span>Dashboard</span></a></li>

            <li class="menu-header">APPS</li>
            <li class="<?=$this->uri->segment(1) === 'product' ? "active" : ""?>"><a class="nav-link"
                    href="<?=base_url('product')?>"><i class="fas fa-utensils"></i> <span>Product</span></a></li>
            <li class="<?=$this->uri->segment(1) === 'category' ? "active" : ""?>"><a class="nav-link"
                    href="<?=base_url('category')?>"><i class="fas fa-tags"></i> <span>Category Product</span></a>
            </li>
            <li class="<?=$this->uri->segment(1) === 'order' ? "active" : ""?>"><a class="nav-link"
                    href="<?=base_url('order')?>"><i class="fas fa-shopping-cart"></i></i><span>Orders</span></a>
            </li>
            <li class="<?=$this->uri->segment(1) === 'report' ? "active" : ""?>"><a class="nav-link"
                    href="<?=base_url('report')?>"><i class="fas fa-file-signature"></i></i><span>Report</span></a>
            </li>


        </ul>


    </aside>
</div>