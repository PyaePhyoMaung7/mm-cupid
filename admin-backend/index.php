<?php
    session_start();

    $auth_role = [1,2,3];
    require('../site-config/admin_require.php');
    
    $title = ": Home";
    require('../templates/cp_template_header.php');
    require('../templates/cp_template_sidebar.php');
    require('../templates/cp_template_top_nav.php');
?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="row" style="display: inline-block;">
    <div class=" top_tiles" style="margin: 10px 0;">
      <div class="col-md-3 col-sm-3  tile">
        <span>Total Sessions</span>
        <h2>231,809</h2>
        <span class="sparkline_one" style="height: 160px;">
              <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
          </span>
      </div>
      <div class="col-md-3 col-sm-3  tile">
        <span>Total Revenue</span>
        <h2>$ 231,809</h2>
        <span class="sparkline_one" style="height: 160px;">
              <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
          </span>
      </div>
      <div class="col-md-3 col-sm-3  tile">
        <span>Total Sessions</span>
        <h2>231,809</h2>
        <span class="sparkline_one" style="height: 160px;">
              <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 125px;"></canvas>
          </span> 
      </div>
      <div class="col-md-3 col-sm-3  tile">
        <span>Total Sessions</span>
        <h2>231,809</h2>
        <span class="sparkline_one" style="height: 160px;">
              <canvas width="200" height="60" style="display: inline-block; vertical-align: top; width: 94px; height: 30px;"></canvas>
          </span>
      </div>
    </div>
  </div>
    <br/>


    <div class="row">
      <div class="col-md-12 col-sm-12 ">
        <div class="dashboard_graph x_panel">
          <div class="x_title">
            <div class="col-md-6">
              <h3>Network Activities <small>Graph title sub-title</small></h3>
            </div>
            <div class="col-md-6">
              <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                <span>December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
              </div>
            </div>
          </div>
          <div class="x_content">
            <div class="demo-container" style="height:250px">
              <div id="chart_plot_03" class="demo-placeholder"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- /page content -->
<?php
    require('../templates/cp_template_footer.php');
?>
<!-- Custom javascript code goes here -->
<script>
    
</script>
<?php
    require('../templates/cp_template_html_end.php');
?>