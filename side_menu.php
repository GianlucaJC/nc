  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="<?php echo $path; ?>index.php" class="brand-link">
      <img src="<?php echo $path; ?>dist/img/logo.jpg" alt="Logo NC" class="brand-image img-circle elevation-3" style="opacity: .7">
      <span class="brand-text font-weight-light">NonConformità-</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
		<?php
			$fx_logo=$path."dist/img/log.png";
			if (isset($_SESSION['user_nc'])) {?>
			  
			  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
				<div class="image">

					<font color='green'>
				  <i class="fas fa-user-check"></i>
				  </font>
				</div>
				<div class="info">
				  <a href="#" class="d-block"><?php echo $_SESSION['operatore_nc']; ?></a>


				  <?php
$nc_access=$_SESSION['nc_access'];
/*				  
Segnalatore base: può segnalare la NC e visualizzare il resto (preclusione analisi NC)
Segnalatore Caporeparto: come base ma vede analisi NC
Valutatore: può segnalare, valutare e chiudere la NC
Eliminatore : può segnalare una NC e può compilare la parte dell'eliminazione
ADMIN: può fare tutte le modifiche delle tabelle, eliminare le nc 			  
*/
					if ($nc_access=="1")
						echo "<span class='badge badge-primary' title='Privilegi Admin'>Adm</span> ";
					if ($nc_access=="2")
						echo "<span class='badge badge-info' title='Privilegi Segnalatore Base'>Segnalatore Base</span> ";
					if ($nc_access=="3")
						echo "<span class='badge badge-success' title='Privilegi Valutatore'>Valutatore</span> ";
					if ($nc_access=="4")
						echo "<span class='badge badge-warning' title='Privilegi Eliminatore'>Eliminatore</span> ";
					if ($nc_access=="5")
						echo "<span class='badge badge-danger' title='Privilegi Segnalatore Caporeparto'>Segnalatore Caporeparto</span> ";
				  ?>

				</div>
			  </div>
		<?php } ?>	  

      <!-- SidebarSearch Form -->
      <div class="form-inline" style='display:none'>
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          
		  <?php 
		   if (isset($page_ref) && $page_ref=="index") 
			   echo "<li class='nav-item menu-open'>" ;
		   else 
			   echo "<li class='nav-item menu'>" ;
		  ?>
		  <?php 
		  
		  if ($nc_access=="1" || $nc_access=="3") {?>
			<a href="<?php echo $path; ?>index.php" class="nav-link">
			  <i class="far fa-circle nav-icon"></i>
			  <p>Dashboard</p>
			</a>
          </li>

		  <?php 
		  }
		  if (1==1) {
				if (isset($page_ref) && $page_ref=="new_nc_pr") 
				   echo "<li class='nav-item menu-open'>" ;
			   else 
				   echo "<li class='nav-item menu'>" ;
			  ?>
			  
				<a href="<?php echo $path; ?>pages/insert/new_nc_pr.php" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>NC Prodotto</p>
				</a>
			  </li>

			  <?php 
			   if (isset($page_ref) && $page_ref=="new_nc_mt") 
				   echo "<li class='nav-item menu-open'>" ;
			   else 
				   echo "<li class='nav-item menu'>" ;
			  ?>
			  
				<a href="<?php echo $path; ?>pages/insert_mt/new_nc_mt.php" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>NC Materiale</p>
				</a>
			  </li>

			  <?php 
			   if (isset($page_ref) && $page_ref=="lista") 
				   echo "<li class='nav-item menu-open'>" ;
			   else 
				   echo "<li class='nav-item menu'>" ;
			  ?>
				<a href="<?php echo $path; ?>pages/elenconc/lista.php" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Consultazione NC-PR</p>
				</a>

			  </li>
			  
			  <?php 
			   if (isset($page_ref) && $page_ref=="lista_mt") 
				   echo "<li class='nav-item menu-open'>" ;
			   else 
				   echo "<li class='nav-item menu'>" ;
			  ?>
				<a href="<?php echo $path; ?>pages/elenconc/lista_mt.php" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Consultazione NC-MT</p>
				</a>

			  </li>
			  
		  <?php } ?>
		  
		  
	  <?php 
		if ($nc_access=="1" || $nc_access=="3") {?>			
		  <li class="nav-item">
			<a href="#" class="nav-link">
			  <i class="nav-icon fas fa-table"></i>
			  <p>
				Gestione tabelle
				<i class="fas fa-angle-left right"></i>
			  </p>
			</a>

			<ul class="nav nav-treeview">
		  <?php 
			if ($nc_access=="1") {?>
				  <li class="nav-item">
					<a href="<?php echo $path; ?>pages/tabelle/utenti.php"  class="nav-link">
					  <i class="far fa-circle nav-icon"></i>
					  <p>Utenti/Team</p>
					</a>
				  </li>
			<?php } ?>

		  <?php 
			if ($nc_access=="3" || $nc_access=="1") {?>
			  <li class="nav-item">
				<a href="<?php echo $path; ?>pages/tabelle/reparti.php"  class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Reparti</p>
				</a>
			  </li>

			  <li class="nav-item">
				<a href="<?php echo $path; ?>pages/tabelle/attrezzature.php"  class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Attrezzature</p>
				</a>
			  </li>

			  <li class="nav-item">
				<a href="<?php echo $path; ?>pages/tabelle/tipologie_nc_pr.php"  class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Tipologie NC-PR</p>
				</a>
			  </li>

			  <li class="nav-item">
				<a href="<?php echo $path; ?>pages/tabelle/classificazione_nc_pr.php"  class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Classificazione NC-PR</p>
				</a>
			  </li>

			  <li class="nav-item">
				<a href="<?php echo $path; ?>pages/tabelle/tipologie_nc_mt.php"  class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Tipologie NC-MT</p>
				</a>
			  </li>
			  
			<?php } ?>  
			</ul>
		  </li>


		<?php
		}
			
			if (isset($_SESSION['user_nc'])) {?>
			   <li class="nav-item">
				<a href="<?php echo $path; ?>index.php?logout=1" class="nav-link">
				  <i class="far fa-circle nav-icon"></i>
				  <p>Logout</p>
				</a>

			  </li>
		<?php  } ?>

		
		
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
