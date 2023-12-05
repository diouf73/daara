<?php
    $this->load->view('template/header');
?>
<!-- Begin page -->
<div id="wrapper">
    <?php
        $this->load->view('template/top_bar');
        $this->load->view('template/left_sidebar');
        $this->load->view('template/right_content');
      //  $this->load->view('template/right_sidebar');
    ?>
</div>
<!-- END wrapper -->


<?php
    $this->load->view('template/footer');
?>
