<?php
  header('Content-Type: text/html; charset=utf-8');
  session_start();

  $host="localhost";
  $mysql_username="root";
  $mysql_password="1qaz2wsx";
  $db_name="cuisineDB_v2";

  $conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  mysql_select_db("$db_name")or die("cannot select DB");

  //constant var setting
  $imagePath="../sources/cuisines/photos/";
  $descriptionPath="../sources/cuisines/intros/";

  $sql="SELECT * FROM systemSettings WHERE user='admin'";
  $result=mysql_query($sql);
  $row=mysql_fetch_array($result,MYSQL_ASSOC);
  $systemLanguage = $row['systemLanguage'];

  if ($systemLanguage == "en") {
    $constantString = array(
      'navbar' => array(
        'title' => 'eRestaurant System', 
        'emenu_system' => 'eMenu',
        'staff_management' => 'Staff Management'),
      'edit_mode_navbar' => array(
        'add_cuisine' => 'Add Cuisine',
        'add_cuisine_type' => 'Add Cuisine Type',
        'edit_cuisine_types' => 'Edit Cuisine Types',
        'edit' => 'Edit',
        'done' => 'Done',
        'settings' => 'Settings'),
      'sidebar' => array(
        'cuisine_types' => 'Cuisine Types',
        'special_list' => 'Special List',
        'overview' => 'Cuisine Lists OverView'),
      'main_table' => array(
        'th_cuisines' => 'Cuisines',
        'th_classify' => 'Classify',
        'th_edit' => 'Edit'),
      'settings_menu' => array(
        'title' => 'Settings',
        'language' => 'Language',
        'submit' => 'Submit',
        'cancel' => 'Cancel'),
      'language_choice' => array(
        'English' => 'English',
        'Chinese' => 'Chinese'),
      'delete_cuisine_menu' => array(
        'title_delete' => 'Delete Cuisine',
        'title_remove' => 'Remove Cuisine From this Type',
        'warning_delete' => 'Are you sure you wish to delete this cuisine?',
        'warning_remove' => 'Are you sure you wish to remove this cuisine from this type?',
        'submit' => 'Delete',
        'cancel' => 'Cancel'),
      'edit_cuisine_menu' => array(
        'title_overview' => 'Edit Cuisine',
        'title_edit_price' => 'Edit Price',
        'cuisine_name' => 'Cuisine Name',
        'retailPrice' => 'Retail Price',
        'specialPrice' => 'Special Price',
        'description' => 'Description',
        'cuisine_type' => 'Cuisine Type',
        'daily_special_setting' => 'Daily Special',
        'set_as_daily_special' => 'Set As Daily Special',
        'submit' => 'Submit',
        'cancel' => 'Cancel'),
      'add_cuisine_type_menu' => array(
        'title' => 'Add Cuisine Type',
        'type_name' => 'Cuisine Type Name',
        'add' => 'ADD',
        'cancel' => 'Cancel'),
      'edit_cuisine_type_menu' => array(
        'title' => 'Edit Cuisine Types',
        'th_sortOrder' => 'Order',
        'th_typeName' => 'Cuisine Type Name',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'cancel' => 'Cancel'),
      'delete_cuisine_type_menu' => array(
        'title' => 'Delete Cuisine Type',
        'warning_delete' => 'Are you sure you wish to delete this cuisine type?',
        'submit' => 'Delete',
        'cancel' => 'Cancel'),
      'add_cuisine_menu' => array(
        'title' => 'Add New Cuisine',
        'step1' => 'Step 1: Insert Informations',
        'step2' => 'Step 2: Classify',
        'step3' => 'Step 3: Set Price',
        'step4' => 'Step 4: Upload Image',
        'name' => 'Cuisine Name',
        'description' => 'Description',
        'select_type' => 'Select Cuisine Type',
        'price' => 'Retail Price',
        'choose_image' => 'Choose Cuisine Image',
        'next_step' => 'Next',
        'prev_step' => 'Previous',
        'done' => 'Done',
        'cancel' => 'Cancel')
    );
  } elseif ($systemLanguage == "ch") {
    $constantString = array(
      'navbar' => array(
        'title' => 'eRestaurant System', 
        'emenu_system' => '电子菜单',
        'staff_management' => '员工管理'),
      'edit_mode_navbar' => array(
        'add_cuisine' => '添加菜品',
        'add_cuisine_type' => '添加类别',
        'edit_cuisine_types' => '编辑类别',
        'edit' => '编辑',
        'done' => '完成',
        'settings' => '设置'),
      'sidebar' => array(
        'cuisine_types' => '菜品类别',
        'special_list' => '每日推荐',
        'overview' => '菜品一览'),
      'main_table' => array(
        'th_cuisines' => '菜品',
        'th_classify' => '分类',
        'th_edit' => '编辑'),
      'settings_menu' => array(
        'title' => '系统设置',
        'language' => '语言',
        'submit' => '确定',
        'cancel' => '取消'),
      'language_choice' => array(
        'English' => '英语',
        'Chinese' => '中文'),
      'delete_cuisine_menu' => array(
        'title_delete' => '删除菜品',
        'title_remove' => '从分类中移除菜品',
        'warning_delete' => '您确定要删除该菜品吗？此次操作将不可逆。',
        'warning_remove' => '您确定要将该菜品从此分类中移除吗？',
        'submit' => '删除',
        'cancel' => '取消'),
      'edit_cuisine_menu' => array(
        'title_overview' => '编辑菜品',
        'title_edit_price' => '修改价格',
        'cuisine_name' => '菜品名称',
        'retailPrice' => '售价',
        'specialPrice' => '特价',
        'description' => '简介',
        'cuisine_type' => '分类',
        'daily_special_setting' => '每日特价',
        'set_as_daily_special' => '设置为特价',
        'submit' => '确定',
        'cancel' => '取消'),
      'add_cuisine_type_menu' => array(
        'title' => '添加类别',
        'type_name' => '菜品类别名称',
        'add' => '添加',
        'cancel' => '取消'),
      'edit_cuisine_type_menu' => array(
        'title' => '编辑菜品分类',
        'th_sortOrder' => '顺位',
        'th_typeName' => '类别名称',
        'edit' => '修改',
        'delete' => '删除',
        'cancel' => '取消'),
      'delete_cuisine_type_menu' => array(
        'title' => '删除菜品类别',
        'warning_delete' => '您确定要删除该菜品类别吗?此次操作将不可逆。',
        'submit' => '删除',
        'cancel' => '取消'),
      'add_cuisine_menu' => array(
        'title' => '添加新菜品',
        'step1' => '步骤一：基本信息',
        'step2' => '步骤二：分类',
        'step3' => '步骤三：设置价格',
        'step4' => '步骤四：上传图片',
        'name' => '菜品名称',
        'description' => '菜品简介',
        'select_type' => '选择菜品分类',
        'price' => '售价',
        'choose_image' => '上传菜品配图',
        'next_step' => '下一步',
        'prev_step' => '上一步',
        'done' => '完成',
        'cancel' => '取消')
    );
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>eRestaurant System</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet"
      href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="static/stylesheets/emenu.css">
  </head>
  <body>
    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container-fluid">
        <!--  so that it uses padding -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"
            data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span
              class="icon-bar"></span> <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#"><?php echo $constantString['navbar']['title']; ?></a>
        </div>

        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav edit-actions-hidden">
            <li class="active"><a id="emenu-system" href="emenu.php"><?php echo $constantString['navbar']['emenu_system']; ?></a></li>
            <li><a id="staff-management" href="#"><?php echo $constantString['navbar']['staff_management']; ?></a></li>
          </ul>
          <!-- edit nav bar -->
          <ul class="nav navbar-nav navbar-right">
            <li class="hidden edit-actions"><a id="add-cuisine" href="#" data-toggle="modal" data-target="#insert-cuisine-step1-modal">
              <?php echo $constantString['edit_mode_navbar']['add_cuisine']; ?>
            </a></li>
            <li class="hidden edit-actions"><a id="add-cuisine-type" href="#" data-toggle="modal" data-target="#insert-cuisine-type-modal">
              <?php echo $constantString['edit_mode_navbar']['add_cuisine_type']; ?>
            </a></li>
            <li class="hidden edit-actions"><a id="edit-cuisine-types" href="#" data-toggle="modal" data-target="#edit-cuisine-types-modal">
              <?php echo $constantString['edit_mode_navbar']['edit_cuisine_types']; ?>
            </a></li>
            <li><a id="toggle-edit" href="#"><?php echo $constantString['edit_mode_navbar']['edit']; ?></a></li>
            <li><a id="settings" href="#" data-toggle="modal" 
              data-target="#settings-modal"><?php echo $constantString['edit_mode_navbar']['settings']; ?></a></li>
          </ul>
        </div>
        <!--/.nav-collapse -->
      </div>
    </div>

    <div class="container-fluid">
      <div class="row">
        <!-- cuisine type sidebar-->
        <div class="col-sm-3 col-md-2 sidebar">
          <ul class="nav nav-sidebar">
            <li><h4><?php echo $constantString['sidebar']['cuisine_types']; ?></h4></li>
            <?php
              if (isset($_GET['special'])) {
                echo "<li class=\"active\">";
              } else {
                echo "<li>";
              }
            ?>
            <a href="emenu.php?special"><?php echo $constantString['sidebar']['special_list']; ?></a></li>
            <!-- get all types from databases -->
            <?php
              $sql="SELECT * FROM cuisineType ORDER BY sortOrder ASC";
              $result=mysql_query($sql);
              while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
                if ($systemLanguage == 'en') {
                  $typeName=$row['typeName_en'];
                } elseif ($systemLanguage == 'ch') {
                  $typeName=$row['typeName_ch'];
                }
                if (isset($_GET['type']) && ($_GET['type'] == $row['typeID'])) {
                  echo "<li class=\"active\">";
                } else {
                  echo "<li>";
                }
                echo "<a href=\"emenu.php?type=".$row['typeID']."\">".$typeName."</a></li>";
                $lastSortOrder=$row['sortOrder'];
              }
            ?>
            <hr>
            <?php
              if (!isset($_GET['type']) && !isset($_GET['special'])) {
                echo "<li class=\"active\">";
              } else {
                echo "<li>";
              }
            ?>
            <a href="emenu.php"><?php echo $constantString['sidebar']['overview']; ?><span class="sr-only">(current)</span></a></li>
          </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th><?php echo $constantString['main_table']['th_cuisines']; ?></th>
                  <th class="hidden edit-actions"><?php echo $constantString['main_table']['th_edit']; ?></th>
                </tr>
              </thead>
              <tbody>
              <!-- cuisine view -->
              <?php
                if (isset($_GET['type'])) {
                  $dailySpecial=0;
                  $eMenuOverViewMode=0;
                  $typeID=$_GET['type'];
                  $sql="SELECT * FROM cuisineList WHERE typeID=$typeID";
                } elseif (isset($_GET['special'])) {
                  $dailySpecial=1;
                  $eMenuOverViewMode=0;
                  $sql="SELECT * FROM cuisineList WHERE dailySpecial=1";
                } else {
                  $dailySpecial=0;
                  $eMenuOverViewMode=1;
                  $sql="SELECT * FROM cuisineList ORDER BY typeID ASC";
                }
                $result=mysql_query($sql);
                while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
                  $cuisineID=$row['cuisineID'];
                  $specialPrice=$row['specialPrice'];
                  $retailPrice=$row['retailPrice'];
                  $cuisineTypeID=$row['typeID'];
                  $dailyspecialCheck=$row['dailySpecial'];
                  if ($systemLanguage == 'en') {
                    $cuisineName=$row['cuisineName_en'];
                    $descriptionName=$row['description_en'];
                  } elseif ($systemLanguage == 'ch') {
                    $cuisineName=$row['cuisineName_ch'];
                    $descriptionName=$row['description_ch'];
                  }
                  $f=fopen($descriptionPath.$descriptionName, "r");
                  $description=fgets($f);
                  fclose($f);
                  echo "<tr>";
                  echo "<td>";
                  echo "<div class=\"row\">";
                  echo "<div class=\"image\"><img src=\"".$imagePath.$row['cuisineImage']."\" height=\"100px\"></div>";
                  echo "<div class=\"intro\">";
                  echo "<div class=\"row\">";
                  echo "<div class=\"col-sm-10 cuisineName\">".$cuisineName."</div>";
                  if ($dailySpecial==1) {
                    echo "<div class=\"col-sm-2\">$".$specialPrice."</div>";
                  } else {
                    echo "<div class=\"col-sm-2\">$".$retailPrice."</div>";
                  }
                  echo "</div>";
                  echo "<div class=\"row\"><div class=\"col-sm-12\">".$description."</div></div>";
                  echo "</div>";
                  echo "</div>";
                  echo "</td>";
                  echo "<td class=\"hidden edit-actions\">";
                  echo "<div class=\"row\"><div class=\"col-md-6\">";
                  if ($dailySpecial) {
                    echo "<button data-toggle=\"modal\" data-target=\"#edit-dailyspecialcuisine-mode\" type=\"button\"
                          class=\"edit-dailyspecialcuisine btn btn-success btn-xs\">";
                    echo "<span class=\"glyphicon glyphicon-pencil\"></span>";
                    echo "<div class=\"hidden cuisineID\">".$cuisineID."</div>";
                    echo "<div class=\"hidden cuisineName\">".$cuisineName."</div>";
                    echo "<div class=\"hidden specialPrice\">".$specialPrice."</div>";
                    echo "</button>";
                  } else {
                    echo "<button data-toggle=\"modal\" data-target=\"#edit-cuisine-modal\" type=\"button\"
                          class=\"edit-cuisine btn btn-success btn-xs\">";
                    echo "<span class=\"glyphicon glyphicon-pencil\"></span>";
                    echo "<div class=\"hidden cuisineID\">".$cuisineID."</div>";
                    echo "<div class=\"hidden cuisineName\">".$cuisineName."</div>";
                    echo "<div class=\"hidden retailPrice\">".$retailPrice."</div>";
                    echo "<div class=\"hidden specialPrice\">".$specialPrice."</div>";
                    echo "<div class=\"hidden description\">".$description."</div>";
                    echo "<div class=\"hidden cuisineTypeID\">".$cuisineTypeID."</div>";
                    echo "<div class=\"hidden dailyspecial\">".$dailyspecialCheck."</div>";
                    echo "</button>";
                  }
                  echo "</div>";
                  echo "<div class=\"col-md-6\">";
                  echo "<button data-toggle=\"modal\" data-target=\"#delete-cuisine-modal\" type=\"button\"
                        class=\"delete-cuisine btn btn-danger btn-xs\">";
                  echo "<span class=\"glyphicon glyphicon-trash\"></span>";
                  echo "<div class=\"hidden cuisineID\">".$cuisineID."</div>";
                  echo "</button></div></div></td></tr>";
                }
              ?>      
              <!-- cuisine view end -->
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <!--  SETTINGS MODAL -->
    <div class="modal fade" id="settings-modal" tabindex="-1" role="dialog"
      aria-labelledby="Settings" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['settings_menu']['title']; ?></h4>
          </div>
          <form action="settings.php" method="POST" class="form-horizontal" role="form">
            <input type="text" name="username" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="quote-input" class="col-sm-2 control-label"><?php echo $constantString['settings_menu']['language']; ?></label>
                <div class="col-sm-10">
                  <label class="btn btn-primary"><input type="radio" name="language" value="en" <?php if ($systemLanguage == "en") {echo "checked=\"checked\"";} ?>>
                    <?php echo $constantString['language_choice']['English']; ?></label>
                  <label class="btn btn-primary"><input type="radio" name="language" value="ch" <?php if ($systemLanguage == "ch") {echo "checked=\"checked\"";} ?>>
                    <?php echo $constantString['language_choice']['Chinese']; ?></label>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['settings_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-success"><?php echo $constantString['settings_menu']['submit']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--  EDIT CUISINE MODAL  -->
    <div class="modal fade" id="edit-cuisine-modal" tabindex="-1" role="dialog"
      aria-labelledby="Edit Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['edit_cuisine_menu']['title_overview']; ?></h4>
          </div>
          <form action="<?php 
            if ($eMenuOverViewMode) { 
              echo "editCuisine.php?systemLanguage=".$systemLanguage;
            } else { 
              echo "editCuisine.php?type=".$typeID."&systemLanguage=".$systemLanguage; 
            }
          ?>" method="POST" class="form-horizontal" role="form">
            <input type="text" name="cuisineID" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="name-input" class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['cuisine_name'].": "; ?></label>
                <div class="col-sm-4">
                  <input type="text" name="cuisineName" class="form-control" id="name-input">
                </div>
                <label for="price-input" class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['retailPrice'].": "; ?></label>
                <div class="col-sm-2">
                  <input type="text" name="retailPrice" class="form-control" id="price-input">
                </div>
              </div>
              <div class="form-group">
                <label for="description-input" class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['description'].": "; ?></label>
                <div class="col-sm-9">
                  <textarea name="description" class="form-control" rows="3" id="description-input"></textarea>
                </div>
              </div>
              <div class="form-group">
                <label for="cuisine-type-select" class="col-sm-3 control-label">
                  <?php echo $constantString['edit_cuisine_menu']['cuisine_type'].": "; ?>
                </label>
                <div class="col-sm-9">
                  <select class="form-control" name="cuisine_type" id="cuisine-type-select">
                    <option value="NULL"></option>
                  <?php
                    $sql="SELECT * FROM cuisineType ORDER BY sortOrder ASC";
                    $result=mysql_query($sql);
                    while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
                      $typeID=$row['typeID'];
                      if ($systemLanguage == 'en') {
                        $typeName=$row['typeName_en'];
                      } elseif ($systemLanguage == 'ch') {
                        $typeName=$row['typeName_ch'];
                      }
                      echo "<option value=\"$typeID\">".$typeName."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div>
              <div class="form-group">
                <label for="cuisine-dailyspecial-setting" class="col-sm-3 control-label">
                  <?php echo $constantString['edit_cuisine_menu']['daily_special_setting'].": "; ?>
                </label>
                <div class="col-sm-4 control-label">
                  <input type="checkbox" name="dailyspecial" value="1">
                  <?php echo $constantString['edit_cuisine_menu']['set_as_daily_special']; ?>
                </div>
                <label for="special-price-input" class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['specialPrice'].": "; ?></label>
                <div class="col-sm-2">
                  <input type="text" name="specialPrice" class="form-control" id="special-price-input">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['edit_cuisine_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-success"><?php echo $constantString['edit_cuisine_menu']['submit']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>
    
    <!--  EDIT DAILY SPECIAL CUISINE MODAL  -->
    <div class="modal fade" id="edit-dailyspecialcuisine-mode" tabindex="-1" role="dialog"
      aria-labelledby="Edit DailySpecial Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['edit_cuisine_menu']['title_overview']; ?></h4>
          </div>
          <form action="<?php echo "editCuisine.php?dailyspecial&systemLanguage=".$systemLanguage; ?>" method="POST" class="form-horizontal" role="form">
            <input type="text" name="cuisineID" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['cuisine_name'].": "; ?></label>
                <label class="specialCuisineName col-sm-3 control-label"></label>
                <label for="price-input" class="col-sm-3 control-label"><?php echo $constantString['edit_cuisine_menu']['specialPrice'].": "; ?></label>
                <div class="col-sm-2">
                  <input type="text" name="specialPrice" class="form-control" id="price-input">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['edit_cuisine_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-success"><?php echo $constantString['edit_cuisine_menu']['submit']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--  DELETE CUISINE CONFIRMATION MODAL -->
    <div class="modal fade" id="delete-cuisine-modal" tabindex="-1" role="dialog"
      aria-labelledby="Delete Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title">
            <?php 
              if ($eMenuOverViewMode) { 
                echo $constantString['delete_cuisine_menu']['title_delete']; 
              } else { 
                echo $constantString['delete_cuisine_menu']['title_remove']; 
              }
            ?>
            </h4>
          </div>
          <form action="<?php
            if ($eMenuOverViewMode) { 
              echo "deleteCuisine.php"; 
            } elseif ($dailySpecial) {
              echo "deleteCuisine.php?special";
            }else { 
              echo "deleteCuisine.php?type=".$typeID; 
            }
          ?>" method="POST" class="form-horizontal" role="form">
            <input type="text" name="cuisineID" class="hidden">
            <div class="modal-body">
              <div class="container">
              <?php 
                if ($eMenuOverViewMode) { 
                  echo $constantString['delete_cuisine_menu']['warning_delete']; 
                } else { 
                  echo $constantString['delete_cuisine_menu']['warning_remove']; 
                }
              ?>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['delete_cuisine_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-danger"><?php echo $constantString['delete_cuisine_menu']['submit']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--  ADD CUISINE MODAL  -->
    <div class="modal fade" id="insert-cuisine-step1-modal" tabindex="-1" role="dialog"
      aria-labelledby="Add Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['add_cuisine_menu']['title']." - ".$constantString['add_cuisine_menu']['step1']; ?></h4>
          </div>
          <form action="#" method="POST" class="form-horizontal" role="form">
            <input type="text" name="lastTypeID" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="cuisine-name-input1" class="col-sm-3 control-label">
                  <?php echo $constantString['add_cuisine_menu']['name'].": "; ?>
                </label>
                <div class="col-sm-5">
                  <input type="text" name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_name_ch"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_name_en";
                    }
                  ?>" class="form-control" id="cuisine-name-input1" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['Chinese'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['English'];
                      }
                  ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="cuisine-name-input2" class="col-sm-3 control-label"></label>
                <div class="col-sm-5">
                  <input type="text" name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_name_en"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_name_ch"; 
                    }
                  ?>" class="form-control" id="cuisine-name-input2" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['English'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['Chinese'];
                      }
                  ?>">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label for="cuisine-description-input1" class="col-sm-3 control-label">
                <?php echo $constantString['add_cuisine_menu']['description'].": "; ?>
              </label>
              <div class="col-sm-8">
                <textarea name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_description_ch"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_description_en";
                    }
                  ?>" class="form-control" rows="3" id="cuisine-description-input1" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['Chinese'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['English'];
                      }
                  ?>"></textarea>
              </div>
            </div>
            <div class="form-group">
              <label for="cuisine-description-input2" class="col-sm-3 control-label"></label>
              <div class="col-sm-8">
                <textarea name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_description_en"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_description_ch";
                    }
                  ?>" class="form-control" rows="3" id="cuisine-description-input2" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['English'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['Chinese'];
                      }
                  ?>"></textarea>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['add_cuisine_menu']['cancel']; ?></button>
              <button data-toggle="modal" data-target="#insert-cuisine-step2-modal" type="button" class="insert-cuisine-step1-next btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['next_step']; ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="insert-cuisine-step2-modal" tabindex="-1" role="dialog"
      aria-labelledby="Add Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['add_cuisine_menu']['title']." - ".$constantString['add_cuisine_menu']['step2']; ?></h4>
          </div>
          <form action="#" method="POST" class="form-horizontal" role="form">
            <input type="text" name="lastTypeID" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="cuisine-type-select" class="col-sm-4 control-label">
                  <?php echo $constantString['add_cuisine_menu']['select_type'].": "; ?>
                </label>
                <div class="col-sm-8">
                  <select class="form-control" name="cuisine_type" id="cuisine-type-select">
                    <option value="NULL"></option>
                  <?php
                    $sql="SELECT * FROM cuisineType ORDER BY sortOrder ASC";
                    $result=mysql_query($sql);
                    while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
                      $typeID=$row['typeID'];
                      if ($systemLanguage == 'en') {
                        $typeName=$row['typeName_en'];
                      } elseif ($systemLanguage == 'ch') {
                        $typeName=$row['typeName_ch'];
                      }
                      echo "<option value=\"$typeID\">".$typeName."</option>";
                    }
                  ?>
                  </select>
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button data-toggle="modal" data-target="#insert-cuisine-step1-modal" type="button" class="insert-cuisine-step2-prev btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['prev_step']; ?>
              </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['add_cuisine_menu']['cancel']; ?></button>
              <button data-toggle="modal" data-target="#insert-cuisine-step3-modal" type="button" class="insert-cuisine-step2-next btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['next_step']; ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="insert-cuisine-step3-modal" tabindex="-1" role="dialog"
      aria-labelledby="Add Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['add_cuisine_menu']['title']." - ".$constantString['add_cuisine_menu']['step3']; ?></h4>
          </div>
          <form action="#" method="POST" class="form-horizontal" role="form">
            <input type="text" name="lastTypeID" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="cuisine-price-input" class="col-sm-3 control-label">
                  <?php echo $constantString['add_cuisine_menu']['price'].": "; ?>
                </label>
                <div class="col-sm-5">
                  <input type="text" name="cuisine_price" class="form-control" id="cuisine-price-input" placeholder="0.00">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button data-toggle="modal" data-target="#insert-cuisine-step2-modal" type="button" class="insert-cuisine-step3-prev btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['prev_step']; ?>
              </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['add_cuisine_menu']['cancel']; ?></button>
              <button data-toggle="modal" data-target="#insert-cuisine-step4-modal" type="button" class="insert-cuisine-step3-next btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['next_step']; ?>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <div class="modal fade" id="insert-cuisine-step4-modal" tabindex="-1" role="dialog"
      aria-labelledby="Add Cuisine" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['add_cuisine_menu']['title']." - ".$constantString['add_cuisine_menu']['step4']; ?></h4>
          </div>
          <form action="addCuisine.php" method="POST" class="form-horizontal" role="form" enctype="multipart/form-data">
            <input type="text" name="cuisine_name_ch" class="hidden">
            <input type="text" name="cuisine_name_en" class="hidden">
            <input type="text" name="cuisine_typeID" class="hidden">
            <input type="text" name="cuisine_retailPrice" class="hidden">
            <textarea name="cuisine_description_ch" class="hidden"></textarea>
            <textarea name="cuisine_description_en" class="hidden"></textarea>
            <div class="modal-body">
              <div class="form-group">
                <label for="cuisine-image-upload" class="col-sm-4 control-label">
                  <?php echo $constantString['add_cuisine_menu']['choose_image'].": "; ?>
                </label>
                <!-- upload image here -->
                <div class="col-sm-8">
                  <input type="file" name="imageFile" class="form-control" id="cuisine-image-upload">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button data-toggle="modal" data-target="#insert-cuisine-step3-modal" type="button" class="insert-cuisine-step4-prev btn btn-success" data-dismiss="modal">
                <?php echo $constantString['add_cuisine_menu']['prev_step']; ?>
              </button>
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['add_cuisine_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-success"><?php echo $constantString['add_cuisine_menu']['done']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--  ADD CUISINE TYPE MODAL  -->
    <div class="modal fade" id="insert-cuisine-type-modal" tabindex="-1" role="dialog"
      aria-labelledby="Add Cuisine Type" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['add_cuisine_type_menu']['title']; ?></h4>
          </div>
          <form action="addType.php" method="POST" class="form-horizontal" role="form">
            <input type="text" name="lastSortOrder" class="hidden">
            <div class="modal-body">
              <div class="form-group">
                <label for="cuisine-type-input1" class="col-sm-4 control-label">
                  <?php echo $constantString['add_cuisine_type_menu']['type_name'].": "; ?>
                </label>
                <div class="col-sm-4">
                  <input type="text" name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_type_ch"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_type_en";
                    }
                  ?>" class="form-control" id="cuisine-type-input1" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['Chinese'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['English'];
                      }
                  ?>">
                </div>
              </div>
              <div class="form-group">
                <label for="cuisine-type-input2" class="col-sm-4 control-label"></label>
                <div class="col-sm-4">
                  <input type="text" name="<?php
                    if ($systemLanguage=="ch") { 
                      echo "cuisine_type_en"; 
                    }  elseif ($systemLanguage=="en") {
                      echo "cuisine_type_ch"; 
                    }
                  ?>" class="form-control" id="cuisine-type-input2" 
                    placeholder="<?php 
                      if ($systemLanguage=="ch") {
                        echo $constantString['language_choice']['English'];
                      } elseif ($systemLanguage=="en") {
                        echo $constantString['language_choice']['Chinese'];
                      }
                  ?>">
                </div>
              </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['add_cuisine_type_menu']['cancel']; ?></button>
              <button type="submit" class="btn btn-success"><?php echo $constantString['add_cuisine_type_menu']['add']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--  EDIT CUISINE TYPE MODAL  -->
    <div class="modal fade" id="edit-cuisine-types-modal" tabindex="-1" role="dialog"
      aria-labelledby="Edit Cuisine Type" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['edit_cuisine_type_menu']['title']; ?></h4>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="row">
                <div class="col-sm-2"><?php echo $constantString['edit_cuisine_type_menu']['th_sortOrder']; ?></div>
                <div class="col-sm-8"><?php echo $constantString['edit_cuisine_type_menu']['th_typeName']; ?></div>
              </div>
              <?php
                $sql="SELECT * FROM cuisineType ORDER BY sortOrder ASC";
                $result=mysql_query($sql);
                while ($row=mysql_fetch_array($result,MYSQL_ASSOC)) {
                  if ($systemLanguage == 'en') {
                    $typeName=$row['typeName_en'];
                  } elseif ($systemLanguage == 'ch') {
                    $typeName=$row['typeName_ch'];
                  }
                  echo "<div class=\"row\">";
                  echo "<form action=\"editTypes.php?systemLanguage=".$systemLanguage."\" method=\"POST\" class=\"form-horizontal\" role=\"form\">";
                  echo "<input type=\"text\" name=\"typeID\" class=\"hidden\" value=\"".$row['typeID']."\">";
                  echo "<div class=\"col-sm-2\">";
                  echo "<input type=\"text\" name=\"sortOrder\" class=\"form-control\" id=\"sortOrder-input\" placeholder=\"".$row['sortOrder']."\" value=\"".$row['sortOrder']."\">";
                  echo "</div>";
                  echo "<div class=\"col-sm-6\">";
                  echo "<input type=\"text\" name=\"typeName\" class=\"form-control\" id=\"typeName-input\" placeholder=\"".$typeName."\" value=\"".$typeName."\">";
                  echo "</div>";
                  echo "<div class=\"col-sm-2\">";
                  echo "<button type=\"submit\" class=\"btn btn-sm btn-warning\">".$constantString['edit_cuisine_type_menu']['edit']."</button>";
                  echo "</div>";
                  echo "<div class=\"col-sm-2\">";
                  echo "<button data-toggle=\"modal\" data-target=\"#delete-cuisine-type-modal\" type=\"button\" 
                    class=\"btn btn-sm btn-danger delete-cuisine-type\" data-dismiss=\"modal\">".$constantString['edit_cuisine_type_menu']['delete'];
                  echo "<div class=\"hidden typeID\">".$row['typeID']."</div>";
                  echo "</button>";
                  echo "</div>";
                  echo "</form>";
                  echo "</div>";
                }
              ?>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $constantString['edit_cuisine_type_menu']['cancel']; ?></button>
          </div>
        </div>
      </div>
    </div>

    <!--  DELETE CUISINE TYPE CONFIRMATION MODAL -->
    <div class="modal fade" id="delete-cuisine-type-modal" tabindex="-1" role="dialog"
      aria-labelledby="Delete Cuisine Type" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">
              <span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
            </button>
            <h4 class="modal-title"><?php echo $constantString['delete_cuisine_type_menu']['title']; ?></h4>
          </div>
          <form action="deleteType.php" method="POST" class="form-horizontal" role="form">
            <input type="text" name="typeID" class="hidden">
            <div class="modal-body">
              <div class="container"><?php echo $constantString['delete_cuisine_type_menu']['warning_delete']; ?></div>
            </div>
            <div class="modal-footer">
              <button data-toggle="modal" data-target="#edit-cuisine-types-modal" type="button" class="btn btn-default" data-dismiss="modal">
                <?php echo $constantString['delete_cuisine_menu']['cancel']; ?>
              </button>
              <button type="submit" class="btn btn-danger"><?php echo $constantString['delete_cuisine_menu']['submit']; ?></button>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!--   jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript">
      var editVar = "<?php echo $constantString['edit_mode_navbar']['edit']; ?>";
      var doneVar = "<?php echo $constantString['edit_mode_navbar']['done']; ?>";
      var lastSortOrder = "<?php echo $lastSortOrder; ?>"
    </script>
    <script src="static/js/emenu.js"></script>
  </body>
</html>