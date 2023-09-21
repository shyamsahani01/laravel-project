<?php require_once '../includes/functions.php';
   if ($getData["plan_add"] == '0') {
     move("../index/");
   }
   secureSchool();
   
   $sessionSelectSchool = select("session","start_date <= '".$getSchoolSession["start_date"]."' AND end_date >= '".$getSchoolSession["start_date"]."'");
   $getSessionSelectSchool = fetch($sessionSelectSchool);
   $newLbfSessionToken = $getSessionSelectSchool["token"];
   /*Available Plans*/
   $selectBuyPlan = mysqli_query($conn, "SELECT *,a.token as PlanToken from ohtt_plan a where NOT EXISTS (SELECT b.plan_token FROM ohtt_plan_details b WHERE b.school_token='$schoolMainToken' AND b.plan_token=a.token) AND a.plan_status='Paid' AND a.start_date <= CAST(CURRENT_TIMESTAMP AS DATE) AND a.end_date >= CAST(CURRENT_TIMESTAMP AS DATE) ORDER BY a.id DESC");
    $buyPlanCount = howMany($selectBuyPlan);
   ?>
<!doctype html>
<html class="no-js" lang="">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>Plan | LBF OHTT School Admin</title>
      <meta name="description" content="">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <!-- Favicon -->
      <?php include 'includes/style.php';?>
      <style>
         @media (min-width:1200px)
         {.custom-bg-body #wrapper .lbf-publications {width:100%; }
         .fixed{
         position:fixed;
         z-index:999;
         }
         @media only screen and (max-width: 1900px) and (min-width: 1300px)  {
         .fixed{
         position:fixed;
         z-index:999;
         }
         }
         } .circle {background: radial-gradient(circle at top, white 14px,  white 14px); position: absolute; top: -15px; left: 110px; width: 30px; height: 30px; -webkit-border-radius: 20px; border-radius: 20px; } h4 p {color : white ; } p{margin: 0 0 0px 0; } h4 {margin-bottom: -1px; } @media only screen and (max-width: 480px){.buy-book-btns {text-align: center; margin-top: 0px; font-size: -5px; font-size: 9px !important; width: 87px; }} .buy-book-btns a {font-weight: 500; background: #2e1d86; color: #fff; padding: 5px 29px; border-radius: 20px; display: block; } /*@media only screen and (max-width: 2600px) and (min-width: 1300px)  {*/ /*         .modal-backdrop.show{*/ /*           display:none;*/ /*       }*/ /*   }*/ .text-white{margin-top:8px; }
         .badge-light{
         position: relative;
         left: 10px;
         line-height: 7px;
         border-radius: 50%;
         }
         .form-check-input {
         position: absolute; 
         margin-top: .3rem; 
         margin-left: unset;
         border-radius:20px;
         }
         @media (max-width:600px) {
         .select2 {
         width:170px !important;
         position:unset !important;
         }
         }
         input:focus{
         outline: none;
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
                  <li>
                    <a href="<?php echo $redirectURL; ?>/dashboard/"><img src="<?php echo $redirectURL; ?>/images/logo/lbf-logo.svg" alt="dashboad-pencil" /></a>
                   </li>
                   <li>
                       <div class="form-group">
                           <select class="select2" style="width: 250px; height: 35px; border: none; border-radius: 50px; position: relative; left: 69px; font-weight: bold;">
                              <option> &nbsp; &nbsp;Session 21-22</option>
                           </select>
                       </div>
                   </li>
                   <li style="float: right; margin-top: 15px;"><img src="<?php echo $redirectURL; ?>/images/logo/sms-logo.svg" alt="dashboad-pencil" /></li>
               </ul>
            </div>
            <!-- Header Menu Area Start Here -->
            <?php include 'includes/header.php';?>
            <!-- Header Menu Area End Here -->
            <!-- Page Area Start Here -->
            <div class="dashboard-page-one">
               <!-- Sidebar Area Start Here -->
               <?php include 'includes/sidebar.php';?>
               <!-- Sidebar Area End Here -->
               <div class="dashboard-content-one">
                  <div class="row">
                     <!-- Student Info Area Start Here -->
                     <!--<div class="col-4-xxxl col-6 col-md-6 col-sm-6 fixed-top" style="">-->
                     <!--   <div id="demo" class="carousel slide" data-ride="carousel">-->
                          
                     <!--      <ul class="carousel-indicators">-->
                     <!--         <li data-target="#demo" data-slide-to="0" class="active"></li>-->
                     <!--         <li data-target="#demo" data-slide-to="1"></li>-->
                     <!--      </ul>-->
                       
                     <!--      <div class="carousel-inner">-->
                     <!--         <div class="carousel-item active">-->
                     <!--            <div class="card dashboard-card-ten">-->
                     <!--               <div class="card-body" style="background-color:#7171b1;">-->
                     <!--                  <div class="heading-layout1">-->
                     <!--                     <div class="item-title">-->
                     <!--                     </div>-->
                     <!--                     <div class="dropdown">-->
                     <!--                     </div>-->
                     <!--                  </div>-->
                     <!--                  <div class="student-info">-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="item-title text-white"style="text-align:center;">Active Plans</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="item-title text-white"style="text-align:center;">Freedom Plan</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;">A</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 11px;">28 Days remaining</p>-->
                     <!--                     </div>-->
                     <!--                     <hr style="background-color:#8C8CC0;">-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 14px;margin-top:8px;">GST 18% included</h4>-->
                     <!--                     </div>-->
                                        
                                             
                     <!--                        </div> -->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;"><del>Rs.200</del></h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 10px;margin-top:8px;">50% Discount</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;">Rs.100</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 10px;margin-top:8px;">No. of Teachers</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;"> 10</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 13px;margin-top:8px;">Total paid Rs.1000</h4>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div clas="container">-->
                     <!--                        <div class="row"style="border-radius: 20px;-->
                     <!--                           border: 1px solid white;padding:10px;">-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4" >-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Total Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">265</p>-->
                     <!--                           </div>-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4">-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Subscribe Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">10</p>-->
                     <!--                           </div>-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4">-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Assigned Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">0</p>-->
                     <!--                           </div>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div class="row">-->
                     <!--                        <div class="col-md-6">-->
                     <!--                           <div class="d-flex justify-content-left">-->
                     <!--                              <p class="text-white"style="text-align:left;font-size: 14px;">FOC Teachers: 1</p>-->
                     <!--                           </div>-->
                     <!--                        </div>-->
                     <!--                        <div class="col-md-6">-->
                     <!--                           <p class="text-white"style="text-align:right;font-size: 14px;">From 01-01-2021 to 01-02-2021</p>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div class="container">-->
                     <!--                        <div class="d-flex justify-content-center">-->
                     <!--                           <a href="#" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold;margin-right: 10px;">Assign Teachers</a>-->
                     <!--                            <a href="javascript:;" data-title="Freedom Plan" data-toggle="modal" data-target="#getplanmodel" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold;margin-right: 10px;">Buy Top up</a>-->
                     <!--                           <a href="javascript:;" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold; ">View Top up</a>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </div>-->
                     <!--         </div>-->
                     <!--         <div class="carousel-item">-->
                     <!--            <div class="card dashboard-card-ten">-->
                     <!--               <div class="card-body" style="background-color:#7171b1;">-->
                     <!--                  <div class="heading-layout1">-->
                     <!--                     <div class="item-title">-->
                     <!--                     </div>-->
                     <!--                     <div class="dropdown">-->
                     <!--                     </div>-->
                     <!--                  </div>-->
                     <!--                  <div class="student-info">-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="item-title text-white"style="text-align:center;">Freeddom Plan</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;">A</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 11px;">28 Days remaining</p>-->
                     <!--                     </div>-->
                     <!--                     <hr style="background-color:#8C8CC0;">-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 14px;margin-top:8px;">GST 18% included</h4>-->
                     <!--                     </div>-->
                                      
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;"><del>Rs.200</del></h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 10px;margin-top:8px;">50% Discount</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;">Rs.100</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <p class="text-white"style="text-align:center;font-size: 10px;margin-top:8px;">No. of Teachers</p>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 16px;margin-top:8px;"> 10</h4>-->
                     <!--                     </div>-->
                     <!--                     <div class="d-flex justify-content-center">-->
                     <!--                        <h4 class="text-white"style="text-align:center;font-size: 13px;margin-top:8px;">Total paid Rs.1000</h4>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div clas="container">-->
                     <!--                        <div class="row"style="border-radius: 20px;-->
                     <!--                           border: 1px solid white;padding:10px;">-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4" >-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Total Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">265</p>-->
                     <!--                           </div>-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4">-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Subscribe Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">10</p>-->
                     <!--                           </div>-->
                     <!--                           <div class="col-lg-4 col-md-12 col-xs-4 col-4">-->
                     <!--                              <h4 class="text-white"style="font-size: 13px;-->
                     <!--                                 font-weight: bold;">Assigned Teachers</h4>-->
                     <!--                              <p class="text-white"style="font-size: 14px;">0</p>-->
                     <!--                           </div>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div class="row">-->
                     <!--                        <div class="col-md-6">-->
                     <!--                           <div class="d-flex justify-content-left">-->
                     <!--                              <p class="text-white"style="text-align:left;font-size: 14px;">FOC Teachers: 1</p>-->
                     <!--                           </div>-->
                     <!--                        </div>-->
                     <!--                        <div class="col-md-6">-->
                     <!--                           <p class="text-white"style="text-align:right;font-size: 14px;">30 days Validity</p>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                     <br>-->
                     <!--                     <div class="container">-->
                     <!--                        <div class="d-flex justify-content-center">-->
                     <!--                           <a href="#" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold;margin-right: 10px;">Assign Teachers</a>-->
                     <!--                           <a href="javascript:;" data-title="Freedom Plan" data-toggle="modal" data-target="#getplanmodel" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold;margin-right: 10px;">Buy Top up</a>-->
                     <!--                           <a href="javascript:;" class="btn btn-default" style="border-radius: 50px; background: white; border: 1px solid white; color: #7171b1;font-weight:bold; ">View Top up</a>-->
                     <!--                        </div>-->
                     <!--                     </div>-->
                     <!--                  </div>-->
                     <!--               </div>-->
                     <!--            </div>-->
                     <!--         </div>-->
                     <!--      </div>-->
                        
                     <!--      <a class="carousel-control-prev" href="#demo" data-slide="prev">-->
                     <!--      <span class="carousel-control-prev-icon"></span>-->
                     <!--      </a>-->
                     <!--      <a class="carousel-control-next" href="#demo" data-slide="next">-->
                     <!--      <span class="carousel-control-next-icon"></span>-->
                     <!--      </a>-->
                     <!--      <div class="buy-book-btn">-->
                     <!--         <a href="<//?php echo $redirectOhttURL; ?>/view_all_plans.php/" class="planBuyButton_view" data-token="" style="float: right;text-align: -webkit-right;background:">View All Plans</a>-->
                     <!--      </div>-->
                     <!--   </div>-->
                     <!--</div>-->
                  
                     <div class="col-12-xxxl col-12 col-md-12 col-sm-12 ">
                        <div class="row">
                           <div class="card ui-tab-card">
                              <div class="card-body" style="background-color:transparent;">
                                 <div class="heading-layout1 mg-b-25">
                                 </div>
                                 <div class="icon-tab">
                                    <ul class="nav nav-tabs" role="tablist">
                                       <li class="nav-item">
                                          <a class="nav-link active show" data-toggle="tab" href="#tab13" role="tab" aria-selected="false">Buy Plans <span class="badge badge-light"><?php echo $buyPlanCount;?></span></a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" data-toggle="tab" href="#tab14" role="tab" aria-selected="false">Free Plans <span class="badge badge-light">1</span></a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link" data-toggle="tab" href="#tab15" role="tab" aria-selected="false">Purchased Plans <span class="badge badge-light">0</span></a>
                                       </li>
                                       <li class="nav-item">
                                          <a class="nav-link  " data-toggle="tab" href="#tab16" role="tab" aria-selected="true">Past Plans <span class="badge badge-light">3</span></a>
                                       </li>
                                    </ul>
                                    <div class="tab-content">
                                       <!-- Buy Plan -->
                                       <div class="tab-pane fade active show" id="tab13" role="tabpanel">
                                          <?php 
                                             $i=0;
                                             while($getBuyPlan=fetch($selectBuyPlan)){
                                             /*Select Class Name*/
                                             $selectClass=mysqli_query($conn,"SELECT a.class_name,b.token,b.name AS className FROM class a INNER JOIN all_classes b ON a.class_name=b.token WHERE a.school_token='$schoolToken' AND a.status='1'");
                                             if($getBuyPlan['implement_type'] == 'Single Class User'){
                                             ?>
                                          <div class="row">
                                             <div class="col-md-12">
                                                <div class="dashboard-main-sliders">
                                                   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                      <ol class="carousel-indicators">
                                                      </ol>
                                                      <div class="carousel-inner">
                                                         <div class="carousel-item active">
                                                            <div class="dashboard-sliders">
                                                               <div class="row">
                                                                  <div class="slider-cnt col-6 col-xs-6 col-md-6 col-sm-6">
                                                                     <p style="font-weight:bold;"><?php echo $getBuyPlan['plan_category'].' ('.$getBuyPlan['implement_type'].')';?></p>
                                                                      <p style="font-weight:bold;"><?php echo $getBuyPlan['plan_name'];?></p>
                                                                       <span style="font-size: 10px;">Validity <?php echo '&nbsp'.$getBuyPlan['validity'].'&nbsp';?>Days</span>
                                                                     <br/><br/>
                                                                     <?php
                                                                     while ($getClass=mysqli_fetch_assoc($selectClass)) {
                                                                     ?>
                                                                     <input type="checkbox" class="form-check-input checkclass" name="singleUserRedio[]" data-classtoken="<?php echo $getClass["token"];?>" data-token="<?php echo $i.$getClass["token"];?>" data-name="<?php echo $getBuyPlan["plan_name"]; ?>" data-price="<?php echo $getBuyPlan["price"] ?>" data-discount="<?php echo isset($getSchoolSession["ohtt_discount"]) ? $getSchoolSession["ohtt_discount"] : '0'; ?>" data-plantoken="<?php echo $getBuyPlan["PlanToken"] ?>" value="<?php echo $getClass["className"];?>"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php  echo $getClass["className"];?>&nbsp;&nbsp;
                                                                     <span class="showArea showArea<?php echo $i.$getClass["token"];?>"></span><br>
                                                                  <?php } ?>
                                                                   
                                                                  </div>
                                                                  <div class="slider-cnt col-6 col-xs-6 col-md-6 col-sm-6">
                                                                     <p style="font-weight:bold;">Rs: <?php echo $getBuyPlan['price'];?>  </p>
                                                                     <br/><br/>
                                                                     <p style="font-weight:bold;">Total User:&nbsp; <span class="totalStudents totalStudents<?php echo $getBuyPlan['PlanToken'];?>">0</span></p>
                                                                     <p style="font-weight:bold;">Total:&nbsp;Rs &nbsp;<span class="totalPrice totalPrice<?php echo $getBuyPlan['PlanToken'];?>">0</span></p>
                                                                     Plan Start Date&nbsp;:&nbsp;<input type="text" name="choosePlanStartDate" class="form-check-input choosePlanStartDate choosePlanStartDate<?php echo $getBuyPlan["token"]; ?>" placeholder="Plan Start Date" style="width: 100px;height: 19px;"/>
                                                                        <br/><br/>
                                                                  </div>
                                                                  <div class="slider-cnt col-12 col-xs-12 col-md-12 col-sm-12">
                                                                     <div class="buy-book-btn">
                                                                        <a href="javascript:;"  class="planBuyButton" data-token="<?php echo $getBuyPlan['PlanToken'];?>" style="width:108px;float: right;text-align: -webkit-right;background:#2e1d86"><i class="fa fa-shopping-cart" style="margin-left:-10px;"></i>  Buy now</a>
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        
                                                                        <a href="javascript:;" class="planBuyButtonOffline" data-token="" style="width:128px;float: right;margin-right: 10px;text-align: -webkit-right;background:"><i class="fa fa-shopping-cart" style="margin-left:-10px;"></i>  Buy offline</a>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <?php }else{?>
                                                   <div class="row">
                                             <div class="col-md-12">
                                                <div class="dashboard-main-sliders">
                                                   <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                                      <ol class="carousel-indicators">
                                                      </ol>
                                                      <div class="carousel-inner">
                                                         <div class="carousel-item active">
                                                            <div class="dashboard-sliders">
                                                               <div class="row">
                                                                  <div class="slider-cnt col-6 col-xs-6 col-md-6 col-sm-6">
                                                                     <p style="font-weight:bold;"><?php echo $getBuyPlan['plan_category'].' ('.$getBuyPlan['implement_type'].')';?></p>
                                                                      <p style="font-weight:bold;"><?php echo $getBuyPlan['plan_name'];?></p>
                                                                       <span style="font-size: 10px;">Validity <?php echo '&nbsp'.$getBuyPlan['validity'].'&nbsp';?>Days</span>
                                                                     <br/><br/>
                                                            
                                                                    All Class&nbsp;:&nbsp;
                                                                     <input type="text" autofocus class="form-check-input numOfuser getUser<?php echo $getBuyPlan['PlanToken'];?> numOfuser<?php echo $getBuyPlan['PlanToken'];?>"placeholder="No.of Users" data-token="<?php echo $getBuyPlan['PlanToken'];?>" data-plantoken="<?php echo $getBuyPlan['PlanToken'];?>" data-name="<?php echo $getBuyPlan['plan_name'];?>" data-price="<?php echo $getBuyPlan['price'];?>" data-discount="<?php echo isset($getSchoolSession["ohtt_discount"]) ? $getSchoolSession["ohtt_discount"] : '0'; ?>" name="numOfUser" value="" style="width: 100px;height: 19px;"/>
                                                                        <br>
                                                                        Plan Start Date&nbsp;:&nbsp;<input type="text" name="choosePlanStartDate" class="form-check-input choosePlanStartDate choosePlanStartDate<?php echo $getBuyPlan["PlanToken"]; ?>" placeholder="Plan Start Date" style="width: 100px;height: 19px;"/>
                                                                        <input type="hidden" class="classUser<?php echo $getBuyPlan['PlanToken'];?>" value="AllUser">
                                                                        <br/><br/>
                                                                  </div>
                                                                  <div class="slider-cnt col-6 col-xs-6 col-md-6 col-sm-6">
                                                                     <p style="font-weight:bold;">Rs: <?php echo $getBuyPlan['price'];?>  </p>
                                                                     <br/><br/>

                                                                     <p style="font-weight:bold;">Total User:&nbsp; <span class="totalUser totalUser<?php echo $getBuyPlan['PlanToken'];?>">0</span></p>
                                                                     <p style="font-weight:bold;">Total:&nbsp;Rs &nbsp;<span class="totalPrice totalPrice<?php echo $getBuyPlan['PlanToken'];?>">0</span></p>
                                                                  </div>
                                                                  <div class="slider-cnt col-12 col-xs-12 col-md-12 col-sm-12">
                                                                     <div class="buy-book-btn">
                                                                        <a href="javascript:;" class="planBuyButton" data-token="<?php echo $getBuyPlan['PlanToken'];?>" style="width:108px;float: right;text-align: -webkit-right;background:"><i class="fa fa-shopping-cart" style="margin-left:-10px;"></i>  Buy now</a>
                                                                        <a href="javascript:;" class="planBuyButtonOffline" data-token="" style="width:128px;float: right;margin-right: 10px;text-align: -webkit-right;background:"><i class="fa fa-shopping-cart" style="margin-left:-10px;"></i>  Buy offline</a>
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <?php  } $i++;} if($i==0){?>
                                          <div class="dashboard-main-sliders">
                                             <p style="text-align: center; ">No Plan Available</p>
                                          </div>
                                          <?php }?>
                                       </div>
                                       <!-- Free Plan -->
                                      
                                       <!-- Purchase Plan -->
                                       <div class="tab-pane fade" id="tab15" role="tabpanel">
                                          <div class="row">
                                             <div class="col-md-12">
                                                <div class="dashboard-main-sliders">
                                                   <p style="text-align: center; ">No Plan Available</p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                       <!-- Past Plan -->
                                       <div class="tab-pane fade" id="tab16" role="tabpanel">
                                          <div class="row">
                                             <div class="col-md-12">
                                                <div class="dashboard-main-sliders">
                                                   <p style="text-align: center; ">No Plan Available</p>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Summery Area Start Here -->
                        </div>
                     </div>
                  </div>
                  <!-- Send Enquiry Email Modal -->
                  <div class="modal fade" id="emailModalForEnquiry" tabindex="-1" role="dialog" aria-hidden="true" style="display: none;">
                     <div class="modal-dialog modal-sm" role="document" style="position: relative;top: 250px;">
                        <div class="modal-content">
                           <div class="modal-header">
                              <h5 class="modal-title">Send Performa Invoice Email</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">×</span>
                              </button>
                           </div>
                           <div class="modal-body">
                              <div class="row">
                                 <div class="col-md-12">
                                    <form id="inqueryForm">
                                       <div class="form-group">
                                          <label for="email">Enter Email Address :- </label>
                                          <input type="email" class="form-control" id="emailAddressPlanForEnquiry" placeholder="Enter Email Address" name="email">
                                       </div>
                                       <input type="hidden" class="token">
                                       <input type="hidden" class="enteredUser">
                                       <input type="text" class="class_token">
                                       <button type="submit" class="btn btn-default sendEmailEnquiryForUsers">Submit</button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <?php include 'includes/footer_publication.php';?>
            <!-- Page Area End Here -->
         </div>
      </div>
      <!-- jquery-->
      <?php include 'includes/script.php';?>
      <script type="text/javascript">
         $('body').on('change','input[name=optradio]:checked',function(){
            var token=$(this).data("token");
            var classToken = $(".classToken" + token).val();
            $(".totalUser").html('0');
            $(".totalPrice").html('0');
         });
            
         /*Number Of User*/
         $('body').on('keyup','.numOfuser',function(){
            var numberOfUser = $(this).val();
            var token = $(this).data('token');
           

            if (numberOfUser != '' && numberOfUser != '0') {
               var price = $(this).data('price');
               var discount = $(this).data('discount');
               var discountPrice = parseInt(price) * parseInt(discount) / 100;
               var getPrice = price - discountPrice;
               var totalPrice = getPrice * numberOfUser;
               $(".totalUser").html('0');
               $(".totalPrice").html('0');
               $(".numOfuser" ).each(function(index) {
                  if (!$(this).hasClass("getUser" + token)) {
                     $(this).val('');
                  }
               });
               $(".totalUser" + token).html(numberOfUser);
               $(".totalPrice" + token).html(totalPrice);
            }else{
               $(".totalUser").html('0');
               $(".totalPrice").html('0');
            }
         });
         
         $('.choosePlanStartDate').bootstrapMaterialDatePicker({
           format : 'DD-MM-YYYY',
           time: false,
           minDate: new Date(),
           maxDate: '<?php echo date('d-m-Y', strtotime($getSchoolSession["end_date"])); ?>',
         });
         
        var val = [];
        
         $('body').on('click','.checkclass',function(){
            $(':checkbox:checked').each(function(i){
               sList += "(" + $(this).val() + "-" + (this.checked ? "checked" : "not checked") + ")";
               alert(sList);
               if($('.checkclass').is(":checked")){ 
                  var getPlanVal = $(this).val();
                  var token = $(this).data('token');
                  var classtoken = $(this).data('classtoken');
                  var plantoken = $(this).data('plantoken');
                  var name = $(this).data('name');
                  var price = $(this).data('price');
                  var discount = $(this).data('discount');
                  //$(".showArea").html('');
                  $(".showArea" + token).html('<input type="text" autofocus class="form-check-input totalStudent getUser'+plantoken+' numOfuser'+token+'" placeholder="No.of Users" data-token="'+plantoken+'" data-token="'+token+'" data-name="'+name+'" data-price="'+price+'" data-discount="'+discount+'" name="numOfUser[]"  style="width: 100px;height: 19px;"/> <input type="hidden" class="classUser'+plantoken+'" value="'+classtoken+'">');
               }
            });
            
         });

       $('body').on('keyup','.totalStudent',function(){
           
            var values = $("input[name='numOfUser[]']")
              .map(function(){return $(this).val();}).get();
              var someArray = JSON.stringify(values);
              var total = 0; 
              for (var i = 0; i < someArray.length; i++) { 
               total += someArray[i] << 0; 
              }
            var numberOfUser = total;
            
            var token = $(this).data('token');
            if (numberOfUser != '' && numberOfUser != '0') {
               var price = $(this).data('price');
               var discount = $(this).data('discount');
               var discountPrice = parseInt(price) * parseInt(discount) / 100;
               var getPrice = price - discountPrice;
               var totalPrice = getPrice * numberOfUser;
               $(".totalStudents").html('0');
               $(".totalPrice").html('0');
               $(".numOfuser" ).each(function(index) {
                  if (!$(this).hasClass("getUser" + token)) {
                     $(this).val('');
                  }
               });
               $(".totalStudents" + token).html(numberOfUser);
               $(".totalPrice" + token).html(totalPrice);
            }else{
               $(".totalStudents").html('0');
               $(".totalPrice").html('0');
            }
         });

          $('body').on('keyup','.totaluser',function(){
            var numberOfUser = $(this).val();
           // alert(numberOfUser);
            var token = $(this).data('token');
            if (numberOfUser != '' && numberOfUser != '0') {
               var price = $(this).data('price');
               var discount = $(this).data('discount');
               var discountPrice = parseInt(price) * parseInt(discount) / 100;
               var getPrice = price - discountPrice;
               var totalPrice = getPrice * numberOfUser;
               $(".totalUser").html('0');
               $(".totalPrice").html('0');
               $(".numOfuser" ).each(function(index) {
                  if (!$(this).hasClass("getUser" + token)) {
                     $(this).val('');
                  }
               });
               $(".totalUser" + token).html(numberOfUser);
               $(".totalPrice" + token).html(totalPrice);
            }else{
               $(".totalUser").html('0');
               $(".totalPrice").html('0');
            }
         });

         
         $(".planBuyButton").click(function(event) {
            var token = $(this).data('token');
            var getUser = $("body").find(".getUser" + token).val();
            var choosePlanStartDate = $(".choosePlanStartDate" + token).val();
            var classUser = $(".classUser" + token).val();
            if (getUser != '' && getUser != undefined && choosePlanStartDate != '') {
               window.location.href="../razorpay/index.php?getUser="+getUser+"&token="+token+"&choosePlanStartDate="+choosePlanStartDate;
            }else{
               swal("Oh Snap!", "Please Enter All Fileds", "error");
            }
         });

         
      </script>
   </body>
</html>