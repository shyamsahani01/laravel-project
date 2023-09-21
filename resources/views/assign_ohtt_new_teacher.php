<?php require_once '../includes/functions.php';
$users = mysqli_query($conn," SELECT * FROM ohtt_user");
$sql = "SELECT * FROM ohtt_user";
$result = $conn->query($sql);

?>
<!doctype html>
<html class="no-js" lang="">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Dashboard | LBF OLS School Admin</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon -->
    <?php include 'includes/style.php'; ?>
    <link rel="stylesheet" type="text/css" href="https://ots.lbf.in/SuperAdmin_bkp_data/assets/css/multiselect.css">
    <!-- Modernize js -->
    <script src="/js/modernizr-3.6.0.min.js"></script>
    <style>
    .dataTables_filter{float: right !important; } #example_length{width: 100%; margin-bottom: 10px; } @media (min-width:1200px) {.custom-bg-body #wrapper .lbf-publications {width:100%; } } .circle {background: radial-gradient(circle at top, white 14px,  white 14px); position: absolute; top: -15px; left: 110px; width: 30px; height: 30px; -webkit-border-radius: 20px; border-radius: 20px; } p{margin: 0 0 0px 0; } h4 {margin-bottom: -1px; } @media only screen and (max-width: 480px){.buy-book-btns {text-align: center; margin-top: 0px; font-size: -5px; font-size: 9px !important; width: 87px; }} .buy-book-btns a {font-weight: 500; background: #2e1d86; color: #fff; padding: 5px 29px; border-radius: 20px; display: block; } .dark{font-size:10px; } .darks{font-size:13px; font-weight: bold; } @media only screen and (max-width: 2600px) and (min-width: 1300px)  {.modal-backdrop.show{display:none; } } thead input {width: 100%; padding: 3px; box-sizing: border-box; } ::placeholder {font-size:10px !important; } 
    input[type=checkbox], input[type=radio] {
    box-sizing: border-box;
    padding: 34px;
    width: 50px;
}

@media (max-width:600px) {
    .select2 {
        width:170px !important;
        position:unset !important;
    }
}
</style>
  </head>
  <body class="custom-bg-body">
    <!-- Preloader Start Here -->
    <div id="preloader"></div>
    <!-- Preloader End Here -->
    <!--<div id="wrapper" class="wrapper bg-ash">-->
    <div id="wrapper" class="wrapper">
      <div class="container-fluid">
    <div class="dashboard-above-img">
            <ul style="text-align:unset;">
                <li><a href="<?php echo $redirectOhttURL; ?>/index/"><img src="<?php echo $redirectURL; ?>/images/logo/lbf-logo.svg" alt="dashboad-pencil"></a></li>
                <li><div class=" form-group">
                                   <!--  <label>Select Class *</label> -->
                                    <select class="select2" name="ClassToken" id="getfetchcategory" style="width:250px;height: 35px;border: none;border-radius:50px;position: relative;
    left: 69px;font-weight:bold;">
                                        <option> &nbsp; &nbsp;Choose Session</option>
                                      
                                        <option>&nbsp; &nbsp;Session 20-21</option>
                                         <option> &nbsp; &nbsp;Session 21-22</option>
                                          
                                      
                                    </select>
                                    
                                </div></li>
                <li style="float: right;
    margin-top: 15px;"><img src="<?php echo $redirectURL; ?>/images/logo/sms-logo.svg" alt="dashboad-pencil"></li>
            </ul>
            
        </div>
        <!-- Header Menu Area Start Here -->
        <?php include 'includes/header.php'; ?>
        <!-- Header Menu Area End Here -->
        <!-- Page Area Start Here -->
        <div class="dashboard-page-one">
          <!-- Sidebar Area Start Here -->
          <?php include 'includes/sidebar.php'; ?>
          <!-- Sidebar Area End Here -->
          <div class="dashboard-content-one">
            <div class="row">
              <!-- Teacher Info Area Start Here -->
              <!--<div class="col-12-xxxl col-12 col-md-12 col-sm-6">-->
              <!--  <div class="card dashboard-card-ten" style="height: fit-content;">-->
              <!--    <div class="card-body" style="background-color:#7171b1;">-->
              <!--      <div class="heading-layout1">-->
              <!--        <div class="item-title">-->
              <!--        </div>-->
              <!--        <div class="dropdown">-->
              <!--        </div>-->
              <!--      </div>-->
              <!--      <div class="Teacher-info row">-->
              <!--        <div class="col-lg-2 col-md-2 col-xs-4 col-4" >-->
              <!--          <div class="d-flex justify-content-left">-->
              <!--            <p class="text-white dark">Monthly Classwise</p>-->
              <!--          </div>-->
              <!--          <div class="d-flex justify-content-left">-->
              <!--            <p class="text-white dark">A</p>-->
              <!--          </div>-->
              <!--          <div class="d-flex justify-content-left">-->
              <!--            <p class="text-white dark" style="font-weight:bold;">30 days Remaining</p>-->
              <!--          </div>-->
              <!--          <div class="d-flex justify-content-left">-->
              <!--            <p class="text-white dark" style="font-size:9px;">Validity 30 days</p>-->
              <!--          </div>-->
                        
              <!--        </div>-->
                      
              <!--        <div class="col-lg-10 col-md-10 col-xs-4 col-8" >-->
              <!--          <div class="row"style="border-radius: 20px;-->
              <!--            border: 1px solid white;padding:10px;">-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12" >-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">Total Teachers</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks">20</p>-->
              <!--              </div>-->
                            
              <!--            </div>-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12">-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">Subscribed  Teachers</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks">1</p>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12">-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">FOC Credits</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks">1</p>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12">-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">Total Subscribed</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks">1</p>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12">-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">Assigned Teachers</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks assignedTeacher">1</p>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--            <div class="col-lg-2 col-md-12 col-xs-12 col-12">-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white dark">Remaining Teachers</p>-->
              <!--              </div>-->
              <!--              <div class="d-flex justify-content-left">-->
              <!--                <p class="text-white darks remainingTeacher">1</p>-->
              <!--              </div>-->
              <!--            </div>-->
              <!--          </div>-->
              <!--        </div>-->
                      
              <!--        <br>-->
              <!--      </div>-->
              <!--    </div>-->
              <!--  </div>-->
              <!--</div>-->
              <div class="card height-auto" style="width:100%;">
                <div class="card-body">
                  <div class="heading-layout1">
                    <div class="item-title">
                      <!--<h3>All Teacher</h3>-->
                    </div>
                    <div class="col-9" style="text-align: end;">
                    </div>
                  </div>
                  <div class="col-12 form-group" style="margin-top: 20px;">
                    <form method="POST" id="TeacherSearch">
                        <div class="row">
                            <div class="col-md-10 col-sm-12 form-group">
                                <div class="input-group">
                                    <input class="form-control" type="text" name="searchKeyword" placeholder="Search Anything..." value="" style="border: 1px solid black !important;">
                                    <div class="input-group-append">
                                        <a class="btn btn-dark waves-effect waves-light" href="#" style="background: transparent;color: black;"><i class="fa fa-spinner" style="font-size: 35px;"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-sm-12 form-group">
                                <input type="hidden" name="TeacherSearch" value="TeacherSearch">
                                <input type="hidden" name="planToken">
                                <input type="hidden" name="query">
                                <button type="submit" class="btn btn-warning" style="color: black;width: 100%;height: 46px;font-size: initial;"><i class="fa fa-search mr-2"></i><span>Search</span></button>
                            </div>
                        </div>
                    </form>
                  </div>
                  <div class="tableGetSchoolPlanData">
                    <div class="table-responsive">
                     
                      <div class="TeacherTable">
                        <h4 class="header-title" style="margin-bottom: 20px;">Assign All Teachers <span class="addRemoveSpan">
                          <input type="checkbox" value="" data-ajaxtarget="assignAllTeachers" data-plantoken="" data-plugin="switchery" data-color="#64b0f2" data-size="small"/></span></h4>
                        <table id="example" class="table text-nowrap" style="border:none !important;">
                          <thead>
                            <tr>
                                 <th style="font-family: Roboto,sans-serif;"><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"></th>
                              <th style="font-family: Roboto,sans-serif;">S No.</th>
                              <th style="font-family: Roboto,sans-serif;">User Name</th>
                                    <th style="font-family: Roboto,sans-serif;">Logged in User</th>
                        
                                    <th style="font-family: Roboto,sans-serif;"></th>
                                    <th style="font-family: Roboto,sans-serif;"></th>
                                    <th style="font-family: Roboto,sans-serif;"></th>
                            </tr>
                             <?php 
                            if($result->num_rows > 0) {
                             $count = 1; 
                            while($row = $result->fetch_assoc()) {
                            ?>  
                            <tr>
                                <td><input type="checkbox" id="vehicle1" name="vehicle1" value="Bike"></td>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $count++; ?></td>
                                <td><?php echo $row['ohtt_user_name'] ?></td>
                                <td><input type="checkbox" value="" data-ajaxtarget="assignAllTeachers" data-plantoken="" data-plugin="switchery" data-color="#64b0f2" data-size="small"/></td>  
                                <td> <div class="buy-book-btn"> <a href="javascript:;" class="planBuyButtonOffline" data-token="" style="width:77px;float: right;margin-right: 10px;text-align: -webkit-right;color:white !important;">Copy</a></div></td>
                                  <td> <div class="buy-book-btn"> <a href="javascript:;" class="planBuyButtonOffline" data-token="" style="width:108px;float: right;margin-right: 10px;text-align: -webkit-right;color:white !important;">Send Sms</a></div></td>
                                  <td> <div class="buy-book-btn"> <a href="javascript:;" class="planBuyButtonOffline" data-token="" style="width:77px;float: right;margin-right: 10px;text-align: -webkit-right;color:white !important;">Edit</a></div></td>
                                
                            </tr>
                            <?php 
                             } 
                              }
                            ?>  
                          </thead>
                        <tbody>
                          
                        </tbody>
                    </table>
                   
                  </div>
            
                 
                  
                    </div>
                  </div>
                </div>
              </div>
              <!-- Teacher Info Area End Here -->
            </div>
            <!-- Footer Area Start Here -->
            <?php include 'includes/footer.php'; ?>
            <!-- Footer Area End Here -->
          </div>
        </div>
        
        <?php include 'includes/footer_publication.php'; ?>
        <!-- Page Area End Here -->
      </div>
    </div>
    <!-- jquery-->
    <?php include 'includes/script.php'; ?>
      <script src="/SchoolAdmin/assets/libs/bootstrap-filestyle2/bootstrap-filestyle.min.js"></script>
    <script type="text/javascript" src="https://ots.lbf.in/SuperAdmin_bkp_data/assets/js/pages/bootstrap-multiselect.js"></script> 
    
    
  </html>
</body>
</html>