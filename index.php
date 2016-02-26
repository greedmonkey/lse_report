<?php
/**
 * Created by PhpStorm.
 * User: Sruit Angkavanitsuk
 * Date: 1/16/15 AD
 * Time: 4:19 AM
 */
require_once('../data/initial_data.php');
$validateAccount();

require_once('../data/encrypt_decrypt_algorithm.php');
$data = $prepareData();
?>
<!DOCTYPE html>

<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en" class="no-js">
<!--<![endif]-->
<head>
    <meta charset="utf-8"/>
    <title><?php echo $SYSTEM_NAME . ' | Report';  ?></title>
    <?php
    require_once('../template/pre_load.php');
    ?>
    <!--
    ========================================================================================================
    BEGIN CUSTOM CSS -->
    <!--
    <link href="../assets/plugins/select2/select2.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/select2/select2-metronic.css" rel="stylesheet" type="text/css"/>-->
    <link href="../assets/plugins/select2-4-00-r2/css/select2.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/bootstrap-fileinput/css/fileinput.min.css" rel="stylesheet" type="text/css"/>
    <link href="../assets/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" >
    <link href="../assets/css/custom.css" rel="stylesheet" type="text/css"/>
    <!--
    END CUSTOM CSS
    ========================================================================================================
    -->
</head>
<!-- BEGIN BODY -->
<body class="page-header-fixed  page-sidebar-fixed">
<?php
require_once('../template/page_header.php');
?>
<div id="page-classroom-information" class="page-container">
    <?php
    require_once('../template/page_sidebar.php');
    ?>
    <!--
    ============================================================================================================
    BEGIN CONTENT
    ============================================================================================================
    -->
    <div class="page-content-wrapper">
        <div class="page-content">
            <!-- BEGIN PAGE HEADER-->
            <div class="row hidden-print">
                <div class="col-lg-10 col-md-12 col-xs-12">
                    <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                    <h3 class="page-title">
                        Report &nbsp;
                        <?php
                        echo ' <small>' . $SYSTEM_NAME . '</small>';
                        ?>
                    </h3>
                    <!--
                    <ul class="page-breadcrumb breadcrumb">
                        <li class="btn-group">
                        </li>
                        <li>
                            <i class="fa fa-home"></i>
                            <a href="<?php echo $WEB_BACKEND_URL; ?>index.php">
                                Home
                            </a>
                        </li>
                        >
                        <li>
                            <a href="#">
                                Report
                            </a>
                        </li>
                    </ul>
                    -->
                </div>
            </div>
            <!-- END PAGE HEADER-->
            <div class="clearfix">
            </div>
            <div class="form row">
                <div class="col-lg-10 col-md-12 col-xs-12">
                    <hr/>
                    <p>
                        <?php //require_once('defer_income.php'); ?>
                        <a href="sale_income.php" >sale income</a>
                        <a href="defer_income.php" >defer income</a>
                    </p>
                    <p>
                        <a href="#">Example of Report 1 (put it in report folder)</a>
                    </p>
                </div>
            </div>
            <?php
            // -------------------------------------
            // log part
            // -------------------------------------
            ?>
        </div>
    </div>
    <!--
    ============================================================================================================
    END CONTENT
    ============================================================================================================
    -->
</div>
<?php
require_once('../template/page_footer.php');
?>
</body>
<!-- END BODY -->
<?php
require_once('../template/post_load.php');
?>
<!--
========================================================================================================
BEGIN CUSTOM JS -->
<script src="../assets/plugins/select2-4-00-r2/js/select2.full.min.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<script src="../assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript" ></script>
<script src="../assets/plugins/bootstrap-fileinput/js/fileinput.min.js" type="text/javascript"></script>
<script src="../assets/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="../assets/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script>

    jQuery(document).ready(function() {

        <?php
        /* ------------------->
        set sidebar
        <-------------------- */
        ?>
        $('#sb-bid<?php echo $_GET["bid"]; ?>').addClass('active');
        $('#sb-bid<?php echo $_GET["bid"]; ?>').addClass('open');
        $('#sb-bid<?php echo $_GET["bid"]; ?> > a > span.arrow').addClass('open');
        $('#sb-bid<?php echo $_GET["bid"]; ?> > ul.sub-menu').css("display","block");
        $('#sb-bid<?php echo $_GET["bid"]; ?>-report').addClass('active');
        $('#sb-bid<?php echo $_GET["bid"]; ?>-report ').addClass('open');

        <?php
        /* ------------------->
        set plugin for page
        <-------------------- */
        ?>
        // initial select2
        $('select.select2').select2({
            width: '100%'
        });
        $('select.select2-long').select2({
            width: '100%',
            minimumInputLength: 2
        });
        $('select.select2-free').select2({
            width: '100%',
            tags: true
        });
        $('select.select2-free-long').select2({
            width: '100%',
            minimumInputLength: 2,
            tags: true
        });

        $('.select2-selection__rendered').css('padding-right', '8px');
        $('.select2-selection__arrow').hide();

        // initial datepicker
        if (jQuery().datepicker) {
            $('.date-picker').datepicker({
                autoclose: true,
                clearBtn: true,
                todayHighlight: true
            });

            $('.date-picker-month').datepicker({
                autoclose: true,
                minViewMode: 'months',
                format: 'mm/yyyy',
                clearBtn: true,
                todayHighlight: true
            });

            $('body').removeClass("modal-open"); // fix bug when inline picker is used in modal
        }
    });

    // continue jquery here

</script>
<!--
END CUSTOM JS
========================================================================================================
-->
</html>
