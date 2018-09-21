
<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
<!--       <a class="navbar-brand" href="#"><?php// echo lang('brand'); ?></a>
 -->    </div>
    <ul class="nav navbar-nav">
      <li class="active"><a href="dashbord.php"><?php echo lang('home'); ?></a></li>
            <li><a href="category.php"><?php echo lang('cat'); ?></a></li>

            <li><a href="items.php"><?php echo lang('item'); ?></a></li>

            <li><a href="members.php"><?php echo lang('mem'); ?></a></li>
           

      <li><a href="comments.php"><?php echo lang('comm'); ?></a></li>

      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><?php echo lang('con'); ?><span class="caret"></span></a>
        <ul class="dropdown-menu">
          <li><a href="members.php?do=Edit&userid=<?php echo $_SESSION['ID']; ?>"><?php echo lang('pro'); ?></a></li>
          <li><a href="#"> <?php echo lang('set'); ?></a></li>
<li><a href="../index.php"> Vsite Shop</a></li>

          <li><a href="logout.php"><?php echo lang('log'); ?></a></li>
        </ul>
      </li>
    </ul>
  </div>
</nav>