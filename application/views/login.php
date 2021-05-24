<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <title>XCRUD | Log in</title>
    <meta name="description" content="Latest updates and statistic charts">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">

    <!--begin::Web font -->
    <script src="https://ajax.googleapis.com/ajax/libs/webfont/1.6.16/webfont.js"></script>
    <script>
      WebFont.load({
            google: {"families":["Poppins:300,400,500,600,700","Roboto:300,400,500,600,700"]},
            active: function() {
                sessionStorage.fonts = true;
            }
          });
        </script>

    <style type="text/css">
      .m_label_font{
        font-color:lightblue;
      }
    </style>
    <!--end::Web font -->

    <!--begin::Global Theme Styles -->
    <link href="<?php echo base_url(); ?>assets/metronic/vendors/base/vendors.bundle.css" rel="stylesheet" type="text/css" />

    <!--RTL version:<link href="../../../assets/vendors/base/vendors.bundle.rtl.css" rel="stylesheet" type="text/css" />-->
    <link href="<?php echo base_url(); ?>assets/metronic/demo/default/base/style.bundle.css" rel="stylesheet" type="text/css" />
    <!--RTL version:<link href="../../../assets/demo/default/base/style.bundle.rtl.css" rel="stylesheet" type="text/css" />-->

    <!--end::Global Theme Styles -->
    <link rel="shortcut icon" href="<?php echo base_url(); ?>images/logo-3.png" />

    <!--previos-->
    

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

    <!-- begin:: Page -->
    <div class="m-grid m-grid--hor m-grid--root m-page">
      <div class="m-grid__item m-grid__item--fluid m-grid m-grid--hor m-login m-login--signin m-login--2 m-login-2--skin-1" id="m_login" style="background-image: url(<?=base_url();?>images/login-1.jpg);">
        <div class="m-grid__item m-grid__item--fluid m-login__wrapper">
          <div class="m-login__container">
            <div class="m-login__logo">
              <a href="#">
                <img src="<?=base_url();?>images/logo-3.png">
              </a>
            </div>
            <div class="m-login__signin">
              <div class="m-login__head">
                <h3 class="m-login__title">Sign In</h3>
              </div>
              <form id="form_login_submit" class="m-login__form m-form" method="POST" onsubmit="return true;" action="loginMe">
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="text" placeholder="Email" name="email" id="email" autocomplete="off">
                </div>
                <div class="form-group m-form__group">
                  <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Password" id="password" name="password">
                </div>
                <div class="row m-login__form-sub">
                  <div class="col m--align-left m-login__form-left">
                    <label class="m-checkbox  m-checkbox--light" style="color: #4615b7">
                      <input type="checkbox" name="remember"> Remember me
                      <span></span>
                    </label>
                  </div>
                  <div class="col m--align-right m-login__form-right">
                    <a href="<?php echo base_url() ?>forgotPassword" id="m_login_forget_password" class="m-link">Forget Password ?</a>
                  </div>
                </div>
                <div class="m-login__form-action">
                  <button id="btnLogin" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary" type="submit"><h4 style="color: #4615b7"> Sign In</h4></button>  
                </div>
              </form>
            </div>
            <div class="m-login__signup">
              <div class="m-login__head">
                <h3 class="m-login__title">Sign Up</h3>
                <div class="m-login__desc" style="color: #4615b7">Enter your details to create your account:</div>
              </div>

              <form class="m-login__form m-form" method="post" id="signupform">
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="text" placeholder="Fullname" name="fullname">
                </div>
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="text" placeholder="Email" name="email" autocomplete="off">
                </div>
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="password" placeholder="Password" name="password">
                </div>
                <div class="form-group m-form__group">
                  <input class="form-control m-input m-login__form-input--last" type="password" placeholder="Confirm Password" name="rpassword">
                </div>
                <div class="row form-group m-form__group m-login__form-sub">
                  <div class="col m--align-left">
                    <label class="m-checkbox m-checkbox--light">
                      <input type="checkbox" name="agree"><font color="#4615b7">I Agree the </font><a href="#" class="m-link m-link--focus"><font color="orange">terms and conditions</font></a>
                      <span></span>
                    </label>
                    <span class="m-form__help"></span>
                  </div>
                </div>
                <div class="m-login__form-action">
                  <button id="m_login_signup_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary"><font color="#ffb822"> Sign Up</font></button>&nbsp;&nbsp;
                  <button id="m_login_signup_cancel" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air  m-login__btn m-login__btn--primary"><font color="red"> Cancel</font></button>
                </div>
              </form>
            </div>
            <div class="m-login__forget-password">
              <div class="m-login__head">
                <h3 class="m-login__title">Forgotten Password ?</h3>
                <div class="m-login__desc">Enter your email to reset your password:</div>
              </div>
              <form class="m-login__form m-form" method="post">
                <div class="form-group m-form__group">
                  <input class="form-control m-input" type="text" placeholder="Email" name="email" id="m_email" autocomplete="off">
                </div>
                <div class="m-login__form-action">
                  <button id="m_login_forget_password_submit" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn m-login__btn--primary">Request</button>&nbsp;&nbsp;
                  <button id="m_login_forget_password_cancel" class="btn m-btn m-btn--pill m-btn--custom m-btn--air m-login__btn" style="color: red">Cancel</button>
                </div>
              </form>
            </div>
            <div class="m-login__account">
              <span class="m-login__account-msg"><font color="#4615b7">
                Don't have an account yet ?</font>
              </span>&nbsp;&nbsp;
              <a href="javascript:;" id="m_login_signup" class="m-link m-link--light m-login__account-link"><font color="#4615b8"> Sign Up</font></a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!---loginbox--->

  <script src="<?php echo base_url(); ?>assets/js/jQuery-2.1.4.min.js"></script>
  
  <!--Metronic Themes initialize --->
  <script src="<?php echo base_url(); ?>assets/metronic/vendors/base/vendors.bundle.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/metronic/demo/default/base/scripts.bundle.js" type="text/javascript"></script>
  <!--end::Global Theme Bundle -->

    <!--begin::Page Scripts -->
  <script src="<?php echo base_url(); ?>assets/metronic/snippets/custom/pages/user/login.js" type="text/javascript"></script>
  <script src="<?php echo base_url(); ?>assets/metronic/demo/default/custom/components/base/toastr.js" type="text/javascript"></script>

</body>

<script type="text/javascript">
  


</script>

</html>