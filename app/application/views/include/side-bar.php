<!-- App-Sidebar -->
<div class="sticky">
    <div class="app-sidebar__overlay" data-bs-toggle="sidebar"></div>
    <div class="app-sidebar">
        <div class="side-header">
            <!-- Logo -->
            <a class="header-brand1" href="<?php echo base_url('statistics');?>">
                <img src="<?php echo base_url('assets/images/brand/logo-white.png'); ?>" class="header-brand-img desktop-logo" alt="logo">
                <img src="<?php echo base_url('assets/images/brand/icon-white.png'); ?>" class="header-brand-img toggle-logo" alt="logo">
                <img src="<?php echo base_url('assets/images/brand/icon-dark.png'); ?>" class="header-brand-img light-logo" alt="logo">
                <img src="<?php echo base_url('assets/images/brand/logo-dark.png'); ?>" class="header-brand-img light-logo1" alt="logo">
            </a>
            <!-- Logo Ends-->
        </div>

        <div class="main-sidemenu">
            <div class="slide-left disabled" id="slide-left">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M13.293 6.293 7.586 12l5.707 5.707 1.414-1.414L10.414 12l4.293-4.293z" />
                </svg>
            </div>
				<ul class="side-menu">
				<?php $i=0; foreach($this->session->menusData as $menu) { ?>
                
                <?php if ($menu == 'Logout'): continue; ?>
                        
                    <?php endif ?>    
                <li class="slide">
                    <?php if(in_array($menu, $this->session->allModuleArray)) { ?>
                        <a class="side-menu__item"  href="<?php echo base_url(str_replace(" ", "-", strtolower($menu)));?>">

                        <i class="side-menu__icon fe fe-<?php echo $_SESSION['iconData'][$menu] ;?>"></i>
                        <span class="side-menu__label"><?php echo $menu;?></span>
                        <!--i class="angle fe fe-chevron-right"></i-->
                    </a>
                       <?php } else { ?> 
                    <a class="side-menu__item" data-bs-toggle="slide" href="javascript:void(0)">
                        <i class="side-menu__icon fe fe-<?php echo $_SESSION['iconData'][$menu] ;?>"></i>
                        <span class="side-menu__label"><?php echo $menu;?></span>
                        <i class="angle fe fe-chevron-right"></i>
                    </a>
                    <?php } ?>
					<ul class="slide-menu">
                        <li class="panel sidetab-menu">
                            <div class="panel-body tabs-menu-body p-0 border-0">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="side9">
                                        <ul class="sidemenu-list">
											<?php foreach($this->session->rolesData as $subMenu) { ?>
											<?php if($menu == $subMenu->parent_menu_name && $subMenu->event=="view" && $subMenu->name != $menu) { ?>
                                            <li>
                                                <a href="<?php echo base_url($subMenu->menu_url)?>" class="slide-item"> <?php echo $subMenu->name;?></a>
                                            </li>
											<?php } ?>
                                            
											<?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
					
                </li>
					<?php $i++; } ?>
				</ul>
					
			
           
            <div class="slide-right" id="slide-right">
                <svg xmlns="http://www.w3.org/2000/svg" fill="#7b8191" width="24" height="24" viewBox="0 0 24 24">
                    <path d="M10.707 17.707 16.414 12l-5.707-5.707-1.414 1.414L13.586 12l-4.293 4.293z" />
                </svg>
            </div>
        </div>
    </div>
</div>
<!-- App-Sidebar Ends -->